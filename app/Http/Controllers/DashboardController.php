<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Offering;
use App\Models\Transfer;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('membership_status', 'Active')->count();
        $newMembersThisMonth = Member::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $monthlyOfferings = Offering::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $lastMonthOfferings = Offering::whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year)
            ->sum('amount');

        $offeringChange = $lastMonthOfferings > 0
            ? round((($monthlyOfferings - $lastMonthOfferings) / $lastMonthOfferings) * 100, 1)
            : 0;

        $pendingTransfers = Transfer::where('status', 'Pending')->count();

        $totalAttendance = DB::table('attendances')
            ->whereMonth('created_at', now()->month)
            ->count();

        $presentCount = DB::table('attendances')
            ->whereMonth('created_at', now()->month)
            ->where('status', 'Present')
            ->count();

        $avgAttendance = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 0;

        $monthlyOfferingsChart = [];
        $yearOfferings = Offering::whereYear('date', now()->year)->get(['date', 'amount']);
        foreach ($yearOfferings as $row) {
            $month = (int) substr($row->date, 5, 2);
            $monthlyOfferingsChart[$month] = ($monthlyOfferingsChart[$month] ?? 0) + $row->amount;
        }
        ksort($monthlyOfferingsChart);

        $statusCounts = Member::selectRaw('membership_status, count(*) as count')
            ->groupBy('membership_status')
            ->pluck('count', 'membership_status')
            ->toArray();

        $recentMembers = Member::latest()->take(5)->get();

        $recentOfferings = Offering::with('member')->latest()->take(5)->get();

        $recentEvents = Event::latest()->take(3)->get();

        return view('dashboard', compact(
            'totalMembers',
            'activeMembers',
            'newMembersThisMonth',
            'monthlyOfferings',
            'offeringChange',
            'pendingTransfers',
            'avgAttendance',
            'monthlyOfferingsChart',
            'statusCounts',
            'recentMembers',
            'recentOfferings',
            'recentEvents'
        ));
    }
}
