@extends('layouts.app')

@section('title', 'Edit Product')

@section('contents')
    <h1 class="mb-0">Edit Product</h1>
    <hr />
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $product->title }}" required>
            </div>
            <div class="col">
                <label class="form-label">Price</label>
                <input type="text" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Product Code</label>
                <input type="text" name="product_code" class="form-control" value="{{ $product->product_code }}" required>
            </div>
            <div class="col">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" required>{{ $product->description }}</textarea>
            </div>
        </div>

        <!-- Category dropdown and quantity input -->
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Category</label>
                <select name="category" class="form-control" required>
                    <option value="mobile" {{ $product->category == 'mobile' ? 'selected' : '' }}>Mobile</option>
                    <option value="laptop" {{ $product->category == 'laptop' ? 'selected' : '' }}>Laptops</option>
                    <option value="speaker" {{ $product->category == 'speaker' ? 'selected' : '' }}>Speakers</option>
                    <option value="headphone" {{ $product->category == 'headphone' ? 'selected' : '' }}>Headphones</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
            </div>
        </div>

        <!-- Location dropdown -->
        <div class="row mb-3">
            <div class="col">
                <label for="location" class="form-label">Location (Sri Lanka District)</label>
                <select name="location" class="form-control" required>
                    <option value="Colombo" {{ $product->location == 'Colombo' ? 'selected' : '' }}>Colombo</option>
                    <option value="Gampaha" {{ $product->location == 'Gampaha' ? 'selected' : '' }}>Gampaha</option>
                    <option value="Kandy" {{ $product->location == 'Kandy' ? 'selected' : '' }}>Kandy</option>
                </select>
            </div>
        </div>

        <!-- Attributes (dynamic based on category) -->
        <div class="row mb-3">
            <div class="col">
                <label for="attributes" class="form-label">Attributes</label>
                <div id="attributes-container">
                    @if($product->category == 'mobile')
                        <div><input type="checkbox" name="attributes[]" value="Storage" {{ is_array($product->attributes) && in_array('Storage', $product->attributes) ? 'checked' : '' }}> Storage</div>
                        <div><input type="checkbox" name="attributes[]" value="RAM" {{ is_array($product->attributes) && in_array('RAM', $product->attributes) ? 'checked' : '' }}> RAM</div>
                    @elseif($product->category == 'laptop')
                        <div><input type="checkbox" name="attributes[]" value="CPU" {{ is_array($product->attributes) && in_array('CPU', $product->attributes) ? 'checked' : '' }}> CPU</div>
                        <div><input type="checkbox" name="attributes[]" value="GPU" {{ is_array($product->attributes) && in_array('GPU', $product->attributes) ? 'checked' : '' }}> GPU</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>

    <script>
        document.querySelector('select[name="category"]').addEventListener('change', function() {
            const category = this.value;
            const attributesContainer = document.getElementById('attributes-container');

            attributesContainer.innerHTML = ''; // Clear previous checkboxes

            if (category === 'mobile') {
                attributesContainer.innerHTML = `
                    <div><input type="checkbox" name="attributes[]" value="Storage"> Storage</div>
                    <div><input type="checkbox" name="attributes[]" value="RAM"> RAM</div>
                `;
            } else if (category === 'laptop') {
                attributesContainer.innerHTML = `
                    <div><input type="checkbox" name="attributes[]" value="CPU"> CPU</div>
                    <div><input type="checkbox" name="attributes[]" value="GPU"> GPU</div>
                `;
            }
        });
    </script>
@endsection
