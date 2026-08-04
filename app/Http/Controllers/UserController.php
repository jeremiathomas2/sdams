<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\AuditLog;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('member')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $members = Member::orderBy('member_id')->get();
        return view('users.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'member_id' => 'nullable|integer|exists:members,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'member_id' => $validated['member_id'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->hasFile('profile_photo')) {
            $user->profile_photo_path = $request->file('profile_photo')->store('avatars/users', 'public');
            $user->save();
        }

        AuditService::created('User', $user->id, $user->only(['name', 'email', 'role', 'member_id', 'profile_photo_path']), 'User created: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        $user->load('member');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $members = Member::orderBy('member_id')->get();
        return view('users.edit', compact('user', 'members'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'member_id' => 'nullable|integer|exists:members,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $oldData = $user->only(['name', 'email', 'role', 'member_id', 'profile_photo_path']);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'member_id' => $validated['member_id'] ?? null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->boolean('remove_photo') && $user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $data['profile_photo_path'] = null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $data['profile_photo_path'] = $request->file('profile_photo')->store('avatars/users', 'public');
        }

        $user->update($data);

        AuditService::updated('User', $user->id, $oldData, $user->fresh()->only(['name', 'email', 'role', 'member_id', 'profile_photo_path']), 'User updated: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself!');
        }

        $oldData = $user->toArray();
        $user->delete();

        if ($oldData['profile_photo_path'] ?? null) {
            Storage::disk('public')->delete($oldData['profile_photo_path']);
        }

        AuditService::deleted('User', $user->id, $oldData, 'User deleted: ' . $oldData['name']);

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
