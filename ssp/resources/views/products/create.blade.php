@extends('layouts.app')

@section('title', 'Create Product')

@section('contents')
    <h1 class="mb-0">Add Product</h1>
    <hr />
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>
            <div class="col">
                <input type="text" name="price" class="form-control" placeholder="Price" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="product_code" class="form-control" placeholder="Product Code" required>
            </div>
            <div class="col">
                <textarea class="form-control" name="description" placeholder="Description" required></textarea>
            </div>
        </div>

        <!-- Category dropdown and quantity input -->
        <div class="row mb-3">
            <div class="col">
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="mobile">Mobile</option>
                    <option value="laptop">Laptops</option>
                    <option value="speaker">Speakers</option>
                    <option value="headphone">Headphones</option>
                </select>
            </div>
            <div class="col">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
            </div>
        </div>

        <!-- Location dropdown -->
        <div class="row mb-3">
            <div class="col">
                <label for="location" class="form-label">Location (Sri Lanka District)</label>
                <select name="location" class="form-control" required>
                    <option value="">Select Location</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Gampaha">Gampaha</option>
                    <option value="Kandy">Kandy</option>
                    <!-- Add more districts as needed -->
                </select>
            </div>
        </div>

        <!-- Attributes (dynamic based on category) -->
        <div class="row mb-3">
            <div class="col">
                <label for="attributes" class="form-label">Attributes</label>
                <div id="attributes-container"></div>
            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
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
