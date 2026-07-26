<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself!');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function roles()
    {
        return view('users.roles');
    }

    public function audit(Request $request)
    {
        $filters = $request->only(['action', 'model', 'user_id', 'date_from', 'date_to', 'search']);
        $filters = array_filter($filters);

        $hasFilters = !empty($filters);

        $filteredQuery = AuditLog::with('user')->filter($filters);
        $logs = (clone $filteredQuery)->latest()->paginate(20)->withQueryString();

        $baseQuery = $hasFilters ? (clone $filteredQuery) : AuditLog::query();

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'today' => (clone $baseQuery)->whereDate('created_at', today())->count(),
            'this_week' => (clone $baseQuery)->whereDate('created_at', '>=', now()->subWeek())->count(),
            'unique_users' => (clone $baseQuery)->whereNotNull('user_id')->count(DB::raw('DISTINCT user_id')),
        ];

        $actionCounts = (clone $baseQuery)
            ->selectRaw('action, count(*) as count')
            ->groupBy('action')
            ->pluck('count', 'action')
            ->toArray();

        $modelCounts = (clone $baseQuery)
            ->selectRaw('model, count(*) as count')
            ->groupBy('model')
            ->orderByDesc('count')
            ->pluck('count', 'model')
            ->toArray();

        $allUsers = User::orderBy('name')->pluck('name', 'id');
        $allModels = (clone ($hasFilters ? AuditLog::query() : AuditLog::query()))
            ->distinct()
            ->pluck('model')
            ->filter()
            ->values();

        return view('users.audit', compact(
            'logs', 'stats', 'actionCounts', 'modelCounts',
            'allUsers', 'allModels', 'filters', 'hasFilters'
        ));
    }

    public function auditExport(Request $request)
    {
        $filters = $request->only(['action', 'model', 'user_id', 'date_from', 'date_to', 'search']);
        $filters = array_filter($filters);

        $logs = AuditLog::with('user')->filter($filters)->latest()->get();

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Timestamp', 'User', 'Action', 'Model', 'Model ID', 'IP Address', 'Description', 'Changes']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user->name ?? 'System',
                    $log->action,
                    $log->model,
                    $log->model_id ?? '',
                    $log->ip_address ?? '',
                    $log->description ?? '',
                    $log->diff_text,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="audit-logs-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
