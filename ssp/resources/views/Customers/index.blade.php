@extends('layouts.app')

@section('title', 'Customers')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Customer List</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Add Customer</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($customers->count() > 0)
                @foreach($customers as $customer)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">{{ $customer->first_name }}</td>
                    <td class="align-middle">{{ $customer->last_name }}</td>
                    <td class="align-middle">{{ $customer->username }}</td>
                    <td class="align-middle">{{ $customer->email }}</td>
                    <td class="align-middle">{{ $customer->phone_number }}</td>
                    <td class="align-middle">
                        <div class="btn-group" role="group">
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary">Details</a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="7">No customers found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
