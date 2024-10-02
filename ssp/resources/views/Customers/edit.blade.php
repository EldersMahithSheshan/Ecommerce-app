@extends('layouts.app')

@section('title', 'Edit Customer')

@section('contents')
    <h1 class="mb-0">Edit Customer</h1>
    <hr />
    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $customer->first_name }}">
            </div>
            <div class="col">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $customer->last_name }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="{{ $customer->username }}">
            </div>
            <div class="col">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ $customer->phone_number }}">
            </div>
            <div class="col">
                <label class="form-label">Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection
