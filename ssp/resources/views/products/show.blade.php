@extends('layouts.app')

@section('title', 'Show Product')

@section('contents')
    <h1 class="mb-0">Product Details</h1>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $product->title }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" value="{{ $product->price }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Product Code</label>
            <input type="text" name="product_code" class="form-control" value="{{ $product->product_code }}" readonly>
        </div>
        <div class="col">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" readonly>{{ $product->description }}</textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="{{ ucfirst($product->category) }}" readonly>
        </div>
        <div class="col">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $product->location }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Attributes</label>
            <input type="text" name="attributes" class="form-control" value="{{ is_array($product->attributes) ? implode(', ', $product->attributes) : 'N/A' }}" readonly>
        </div>
        <div class="col">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" readonly>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" value="{{ $product->created_at }}" readonly>
        </div>
        <div class="col">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" value="{{ $product->updated_at }}" readonly>
        </div>
    </div>
@endsection
