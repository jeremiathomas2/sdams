<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use App\Models\Member;
use App\Models\Fund;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    public function index()
    {
        $offerings = Offering::with('member', 'fund')->latest()->paginate(10);
        return view('finance.index', compact('offerings'));
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

        if ($request->fund_id) {
            $fund = Fund::find($request->fund_id);
            $fund->increment('balance', $request->amount);
        }

        return redirect()->route('offerings.index')->with('success', 'Offering recorded successfully!');
    }

    public function show(Offering $offering)
    {
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

        // Adjust fund balance if amount or fund changed
        if ($offering->fund_id) {
            $offering->fund->decrement('balance', $offering->amount);
        }

        $offering->update($validated);

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
        $offering->delete();
        return redirect()->route('offerings.index')->with('success', 'Offering deleted successfully!');
    }

    public function tithe()
    {
        $offerings = Offering::where('type', 'Tithe')->with('member')->latest()->paginate(10);
        return view('finance.index', compact('offerings'));
    }

    public function funds()
    {
        $funds = Fund::all();
        return view('finance.funds', compact('funds'));
    }

    public function receipts()
    {
        $offerings = Offering::whereNotNull('receipt_number')->with('member')->latest()->paginate(10);
        return view('finance.index', compact('offerings'));
    }

    public function bulk()
    {
        return view('finance.bulk');
    }
}
