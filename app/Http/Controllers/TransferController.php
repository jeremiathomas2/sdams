<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Member;
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
        return view('transfers.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:In,Out',
            'from_church' => 'required|string',
            'to_church' => 'required|string',
            'request_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $transfer = Transfer::create($validated);

        AuditService::created('Transfer', $transfer->id, $validated, 'Transfer created: ' . $validated['type'] . ' from ' . $validated['from_church']);

        return redirect()->route('transfers.index')->with('success', 'Transfer request created successfully!');
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
