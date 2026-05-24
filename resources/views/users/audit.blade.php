@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ Audit Logs</span></div>
<div class="page-header">
    <div>
        <h2>📋 Audit Logs</h2>
        <p>Track system activity and user actions</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ now()->subMinutes(5)->format('M d, Y H:i') }}</td>
                    <td><strong>Super Admin</strong></td>
                    <td><span class="badge badge-success">Create</span></td>
                    <td>Members</td>
                    <td>Added new member <em>John Mwangi</em></td>
                </tr>
                <tr>
                    <td>{{ now()->subHours(2)->format('M d, Y H:i') }}</td>
                    <td><strong>Finance Clerk</strong></td>
                    <td><span class="badge badge-info">Update</span></td>
                    <td>Finance</td>
                    <td>Recorded tithe for <em>Sarah Kioko</em></td>
                </tr>
                <tr>
                    <td>{{ now()->subDays(1)->format('M d, Y H:i') }}</td>
                    <td><strong>Super Admin</strong></td>
                    <td><span class="badge badge-warning">Login</span></td>
                    <td>Auth</td>
                    <td>Successful login from IP 127.0.0.1</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;text-align:center;color:var(--text-muted);font-size:0.85rem;">
        Showing last 20 activities. <a href="#" style="color:var(--primary);font-weight:600">Download full logs (CSV)</a>
    </div>
</div>
@endsection
