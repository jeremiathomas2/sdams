@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Members <span>/ Add Member</span></div>
<div class="page-header">
    <div>
        <h2>👤 Add New Member</h2>
        <p>Register a new member to the church database</p>
    </div>
</div>

<div class="card">
    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <div class="grid-3">
            <div class="form-group-app">
                <label class="form-label-app">First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Middle Name</label>
                <input type="text" name="middle_name" class="form-control">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
        </div>

        <div class="grid-3">
            <div class="form-group-app">
                <label class="form-label-app">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Marital Status</label>
                <select name="marital_status" class="form-control">
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Divorced">Divorced</option>
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Email Address</label>
                <input type="email" name="email" class="form-control">
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Residential Address</label>
            <textarea name="residential_address" class="form-control"></textarea>
        </div>

        <div class="grid-3">
            <div class="form-group-app">
                <label class="form-label-app">Baptism Date</label>
                <input type="date" name="baptism_date" class="form-control">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Membership Class</label>
                <select name="membership_class" class="form-control" required>
                    <option value="Baptized">Baptized</option>
                    <option value="Non-Baptized">Non-Baptized</option>
                    <option value="Associate">Associate</option>
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Membership Status</label>
                <select name="membership_status" class="form-control" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Probation">Probation</option>
                    <option value="Transferred">Transferred</option>
                </select>
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Department/Ministry</label>
            <input type="text" name="department_ministry" class="form-control" placeholder="e.g. Choir, Youth, Deaconry">
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('members.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Save Member</button>
        </div>
    </form>
</div>
@endsection
