<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use App\Models\Member;
use App\Models\Fund;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferingController extends Controller
{
    public function index(Request $request)
    {
        return view('finance.index', $this->filteredListings($request));
    }

    public function create()
    {
        $members = Member::all();
        $funds = Fund::all();
        return view('finance.create', compact('members', 'funds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|string',
            'date' => 'required|date',
            'receipt_number' => 'nullable|string',
            'fund_id' => 'nullable|exists:funds,id',
            'notes' => 'nullable|string',
        ]);

        $offering = Offering::create($validated);

        AuditService::created('Offering', $offering->id, $validated, 'Offering recorded: TZS ' . number_format($validated['amount']));

        if ($request->fund_id) {
            $fund = Fund::find($request->fund_id);
            $fund->increment('balance', $request->amount);
        }

        return redirect()->route('offerings.index')->with('success', 'Offering recorded successfully!');
    }

    public function show(Offering $offering)
    {
        $offering->load('member', 'fund');
        return view('finance.show', compact('offering'));
    }

    public function edit(Offering $offering)
    {
        $members = Member::all();
        $funds = Fund::all();
        return view('finance.edit', compact('offering', 'members', 'funds'));
    }

    public function update(Request $request, Offering $offering)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|string',
            'date' => 'required|date',
            'receipt_number' => 'nullable|string',
            'fund_id' => 'nullable|exists:funds,id',
            'notes' => 'nullable|string',
        ]);

        if ($offering->fund_id) {
            $offering->fund->decrement('balance', $offering->amount);
        }

        $oldData = $offering->toArray();
        $offering->update($validated);

        AuditService::updated('Offering', $offering->id, $oldData, $validated, 'Offering updated: TZS ' . number_format($validated['amount']));

        if ($request->fund_id) {
            $fund = Fund::find($request->fund_id);
            $fund->increment('balance', $request->amount);
        }

        return redirect()->route('offerings.index')->with('success', 'Offering updated successfully!');
    }

    public function destroy(Offering $offering)
    {
        if ($offering->fund_id) {
            $offering->fund->decrement('balance', $offering->amount);
        }
        $oldData = $offering->toArray();
        $offering->delete();

        AuditService::deleted('Offering', $offering->id, $oldData, 'Offering deleted: TZS ' . number_format($oldData['amount']));

        return redirect()->route('offerings.index')->with('success', 'Offering deleted successfully!');
    }

    public function tithe(Request $request)
    {
        return view('finance.index', $this->filteredListings($request, fn ($q) => $q->where('type', 'Tithe')));
    }

    public function funds()
    {
        $funds = Fund::all();
        return view('finance.funds', compact('funds'));
    }

    public function storeFund(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:funds,name',
            'description' => 'nullable|string',
            'balance' => 'nullable|numeric|min:0',
        ]);

        Fund::create($validated);

        return redirect()->route('offerings.funds')->with('success', 'Fund created successfully!');
    }

    public function editFund(Fund $fund)
    {
        return view('finance.fund-edit', compact('fund'));
    }

    public function updateFund(Request $request, Fund $fund)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:funds,name,' . $fund->id,
            'description' => 'nullable|string',
            'balance' => 'required|numeric|min:0',
        ]);

        $fund->update($validated);

        return redirect()->route('offerings.funds')->with('success', 'Fund updated successfully!');
    }

    public function destroyFund(Fund $fund)
    {
        $fund->delete();
        return redirect()->route('offerings.funds')->with('success', 'Fund deleted successfully!');
    }

    public function receipts(Request $request)
    {
        return view('finance.index', $this->filteredListings($request, fn ($q) => $q->whereNotNull('receipt_number')));
    }

    public function bulk()
    {
        return view('finance.bulk');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');

        if ($handle === false) {
            return back()->with('error', 'Unable to read the CSV file.');
        }

        $header = fgetcsv($handle);
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 4) {
                $errorCount++;
                $errors[] = 'Row with insufficient columns skipped.';
                continue;
            }

            $memberName = trim($row[0]);
            $amount = trim($row[1]);
            $type = trim($row[2]);
            $date = trim($row[3]);

            $member = Member::where('first_name', 'like', "%{$memberName}%")
                ->orWhere('last_name', 'like', "%{$memberName}%")
                ->first();

            if (!$member) {
                $errorCount++;
                $errors[] = "Member '{$memberName}' not found.";
                continue;
            }

            if (!is_numeric($amount) || $amount <= 0) {
                $errorCount++;
                $errors[] = "Invalid amount for member '{$memberName}'.";
                continue;
            }

            Offering::create([
                'member_id' => $member->id,
                'amount' => $amount,
                'type' => $type ?: 'Other',
                'date' => $date ?: date('Y-m-d'),
            ]);

            $successCount++;
        }

        fclose($handle);

        $message = "Import complete: {$successCount} records imported.";
        if ($errorCount > 0) {
            $message .= " {$errorCount} errors encountered.";
        }

        return redirect()->route('offerings.index')->with('success', $message);
    }

    public function export(Request $request)
    {
        $offerings = $this->filteredQuery($request)->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="offerings_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($offerings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Member', 'Member ID', 'Type', 'Amount', 'Receipt #', 'Notes']);

            foreach ($offerings as $offering) {
                fputcsv($file, [
                    $offering->date,
                    $offering->member->full_name,
                    $offering->member->member_id,
                    $offering->type,
                    $offering->amount,
                    $offering->receipt_number ?? '',
                    $offering->notes ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function filteredQuery(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return Offering::query()
            ->with('member', 'fund')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = trim($request->input('q'));

                $query->where(function ($query) use ($q) {
                    $query->where('receipt_number', 'like', "%{$q}%")
                        ->orWhere('notes', 'like', "%{$q}%")
                        ->orWhereHas('member', function ($query) use ($q) {
                            $query->where('first_name', 'like', "%{$q}%")
                                ->orWhere('last_name', 'like', "%{$q}%")
                                ->orWhere('member_id', 'like', "%{$q}%");
                        });
                });
            })
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->input('type')))
            ->when($request->filled('fund'), fn ($query) => $query->where('fund_id', $request->input('fund')))
            ->when(
                $request->filled('date_from') && strtotime((string) $request->input('date_from')) !== false,
                fn ($query) => $query->whereDate('date', '>=', $request->input('date_from'))
            )
            ->when(
                $request->filled('date_to') && strtotime((string) $request->input('date_to')) !== false,
                fn ($query) => $query->whereDate('date', '<=', $request->input('date_to'))
            )
            ->when(
                $request->filled('amount_min') && is_numeric($request->input('amount_min')),
                fn ($query) => $query->where('amount', '>=', $request->input('amount_min'))
            )
            ->when(
                $request->filled('amount_max') && is_numeric($request->input('amount_max')),
                fn ($query) => $query->where('amount', '<=', $request->input('amount_max'))
            )
            ->when($request->filled('has_receipt'), function ($query) use ($request) {
                $request->boolean('has_receipt')
                    ? $query->whereNotNull('receipt_number')
                    : $query->whereNull('receipt_number');
            });
    }

    private function filteredListings(Request $request, ?callable $scope = null): array
    {
        $query = $this->filteredQuery($request);

        if ($scope) {
            $scope($query);
        }

        $summary = (clone $query)
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(amount), 0) as total')
            ->first();

        $offerings = $query->latest()->paginate(10)->withQueryString();

        return compact('offerings', 'summary') + [
            'types' => Offering::query()->distinct()->orderBy('type')->pluck('type'),
            'funds' => Fund::orderBy('name')->get(),
        ];
    }
}
