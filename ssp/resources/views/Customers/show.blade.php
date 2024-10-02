@extends('layouts.app')

@section('title', 'Customer Details')

@section('contents')
    <h1 class="mb-0">Customer Details</h1>
    <hr />
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" value="{{ $customer->first_name }}" readonly>
        </div>
        <div class="col">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" value="{{ $customer->last_name }}" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="{{ $customer->username }}" readonly>
        </div>
        <div class="col">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $customer->email }}" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" value="{{ $customer->phone_number }}" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Created At</label>
            <input type="text" class="form-control" value="{{ $customer->created_at }}" readonly>
        </div>
        <div class="col">
            <label class="form-label">Updated At</label>
            <input type="text" class="form-control" value="{{ $customer->updated_at }}" readonly>
        </div>
    </div>
@endsection
