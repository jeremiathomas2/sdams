<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Member;
use App\Models\Setting;
use App\Services\AuditService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {
        $transfers = Transfer::with('member')->latest()->paginate(10);
        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        $members = Member::all();
        [$churches, $thisChurch] = $this->knownChurches();

        return view('transfers.create', compact('members', 'churches', 'thisChurch'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:In,Out',
            'from_church' => 'required|string|max:255',
            'to_church' => 'required|string|max:255',
            'request_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $fromChurch = trim($validated['from_church']);
        $toChurch = trim($validated['to_church']);

        if (strcasecmp($fromChurch, $toChurch) === 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'from_church' => 'The "From Church" and "To Church" must be different churches.',
                ]);
        }

        $validated['from_church'] = $fromChurch;
        $validated['to_church'] = $toChurch;

        $transfer = Transfer::create($validated);

        AuditService::created('Transfer', $transfer->id, $validated, 'Transfer created: ' . $validated['type'] . ' from ' . $validated['from_church']);

        return redirect()->route('transfers.index')->with('success', 'Transfer request created successfully!');
    }

    /**
     * Build the list of known churches from settings and existing transfer records.
     *
     * @return array{0: array<int, string>, 1: string}
     */
    private function knownChurches(): array
    {
        $thisChurch = trim((string) Setting::getValue('church_name', 'SDA Church'));

        $used = Transfer::query()
            ->selectRaw("from_church AS name")
            ->union(Transfer::query()->selectRaw("to_church AS name"))
            ->pluck('name');

        $churches = collect()
            ->concat($used)
            ->map(fn ($name) => trim((string) $name))
            ->filter(fn ($name) => $name !== '')
            ->unique(fn ($name) => mb_strtolower($name))
            ->values()
            ->all();

        usort($churches, function ($a, $b) use ($thisChurch) {
            if ($thisChurch !== '') {
                if (strcasecmp($a, $thisChurch) === 0) return -1;
                if (strcasecmp($b, $thisChurch) === 0) return 1;
            }

            return strcasecmp($a, $b);
        });

        $hasThisChurch = $thisChurch !== ''
            && collect($churches)->contains(fn ($church) => mb_strtolower($church) === mb_strtolower($thisChurch));

        if ($thisChurch !== '' && ! $hasThisChurch) {
            array_unshift($churches, $thisChurch);
        }

        return [$churches, $thisChurch];
    }

    public function show(Transfer $transfer)
    {
        return view('transfers.show', compact('transfer'));
    }

    public function edit(Transfer $transfer)
    {
        $members = Member::all();
        return view('transfers.edit', compact('transfer', 'members'));
    }

    public function update(Request $request, Transfer $transfer)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'approval_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $oldData = $transfer->toArray();
        $transfer->update($validated);

        AuditService::updated('Transfer', $transfer->id, $oldData, $validated, 'Transfer status changed to: ' . $validated['status']);

        if ($validated['status'] == 'Approved') {
            $member = $transfer->member;
            if ($transfer->type == 'Out') {
                $member->update(['membership_status' => 'Transferred']);
            } else {
                $member->update(['membership_status' => 'Active']);
            }
        }

        return redirect()->route('transfers.index')->with('success', 'Transfer request updated successfully!');
    }

    public function destroy(Transfer $transfer)
    {
        $oldData = $transfer->toArray();
        $transfer->delete();

        AuditService::deleted('Transfer', $transfer->id, $oldData, 'Transfer deleted: ' . $oldData['type'] . ' from ' . $oldData['from_church']);

        return redirect()->route('transfers.index')->with('success', 'Transfer request deleted successfully!');
    }

    public function pending()
    {
        $transfers = Transfer::where('status', 'Pending')->with('member')->latest()->paginate(10);
        return view('transfers.index', compact('transfers'));
    }

    public function history()
    {
        $transfers = Transfer::where('status', '!=', 'Pending')->with('member')->latest()->paginate(10);
        return view('transfers.index', compact('transfers'));
    }
}
