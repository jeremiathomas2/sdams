@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Members / <span>Edit Member</span></div>
<div class="page-header">
    <div>
        <h2>👤 Edit Member: {{ $member->full_name }}</h2>
        <p>Update member information in the database</p>
    </div>
</div>

<div class="card">
    <form action="{{ route('members.update', $member) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid-3">
            <div class="form-group-app">
                <label class="form-label-app">First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $member->first_name }}" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" value="{{ $member->middle_name }}">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $member->last_name }}" required>
            </div>
        </div>

        <div class="grid-3">
            <div class="form-group-app">
                <label class="form-label-app">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" value="{{ $member->date_of_birth }}" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $member->gender == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Marital Status</label>
                <select name="marital_status" class="form-control">
                    <option value="Single" {{ $member->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ $member->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Widowed" {{ $member->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    <option value="Divorced" {{ $member->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ $member->phone_number }}" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ $member->email }}">
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Residential Address</label>
            <textarea name="residential_address" class="form-control">{{ $member->residential_address }}</textarea>
        </div>

        <div class="grid-3">
            <div class="form-group-app">
                <label class="form-label-app">Baptism Date</label>
                <input type="date" name="baptism_date" class="form-control" value="{{ $member->baptism_date }}">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Membership Class</label>
                <select name="membership_class" class="form-control" required>
                    <option value="Baptized" {{ $member->membership_class == 'Baptized' ? 'selected' : '' }}>Baptized</option>
                    <option value="Non-Baptized" {{ $member->membership_class == 'Non-Baptized' ? 'selected' : '' }}>Non-Baptized</option>
                    <option value="Associate" {{ $member->membership_class == 'Associate' ? 'selected' : '' }}>Associate</option>
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Membership Status</label>
                <select name="membership_status" class="form-control" required>
                    <option value="Active" {{ $member->membership_status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $member->membership_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Probation" {{ $member->membership_status == 'Probation' ? 'selected' : '' }}>Probation</option>
                    <option value="Transferred" {{ $member->membership_status == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                </select>
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Department/Ministry</label>
            <input type="text" name="department_ministry" class="form-control" value="{{ $member->department_ministry }}" placeholder="e.g. Choir, Youth, Deaconry">
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('members.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Update Member</button>
        </div>
    </form>
</div>
@endsection
