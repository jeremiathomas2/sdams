<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'residential_address' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'membership_class' => 'required|string',
            'membership_status' => 'required|string',
            'department_ministry' => 'nullable|string',
        ]);

        $validated['member_id'] = 'SDA-' . rand(1000, 9999);

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Member added successfully!');
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'residential_address' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'membership_class' => 'required|string',
            'membership_status' => 'required|string',
            'department_ministry' => 'nullable|string',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member updated successfully!');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
    }

    public function inactive()
    {
        $members = Member::where('membership_status', 'Inactive')->latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $members = Member::query()
            ->when($query, function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%")
                  ->orWhere('member_id', 'like', "%{$query}%")
                  ->orWhere('phone_number', 'like', "%{$query}%");
            })
            ->when($status, function ($q) use ($status) {
                $q->where('membership_status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('members.index', compact('members'));
    }
}
