@extends('layouts.app')

@section('title', 'Create Customer')

@section('contents')
    <h1 class="mb-0">Add Customer</h1>
    <hr />
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="first_name" class="form-control" placeholder="First Name">
            </div>
            <div class="col">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="username" class="form-control" placeholder="Username">
            </div>
            <div class="col">
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="phone_number" class="form-control" placeholder="Phone Number">
            </div>
            <div class="col">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
