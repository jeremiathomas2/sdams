<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Offering;
use App\Models\Event;
use App\Models\Transfer;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function membership()
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('membership_status', 'Active')->count();
        $inactiveMembers = Member::where('membership_status', 'Inactive')->count();
        $baptizedMembers = Member::where('membership_class', 'Baptized')->count();
        
        return view('reports.membership', compact('totalMembers', 'activeMembers', 'inactiveMembers', 'baptizedMembers'));
    }

    public function finance()
    {
        $totalOfferings = Offering::sum('amount');
        $monthlyOfferings = Offering::whereMonth('date', now()->month)->sum('amount');
        $offeringsByType = Offering::selectRaw('type, sum(amount) as total')->groupBy('type')->get();
        
        return view('reports.finance', compact('totalOfferings', 'monthlyOfferings', 'offeringsByType'));
    }

    public function attendance()
    {
        $events = Event::withCount('attendances')->latest()->take(10)->get();
        return view('reports.attendance', compact('events'));
    }

    public function transfers()
    {
        $totalTransfers = Transfer::count();
        $pendingTransfers = Transfer::where('status', 'Pending')->count();
        $approvedTransfers = Transfer::where('status', 'Approved')->count();
        
        return view('reports.transfers', compact('totalTransfers', 'pendingTransfers', 'approvedTransfers'));
    }
}
