<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LocalMarket — Buy, Sell & Find Services')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
/* Add Product modal: reliable scrolling fix */
#addProductModal .modal-dialog {
    height: calc(100vh - 32px);
    max-height: calc(100vh - 32px);
    margin: 16px auto;
}

#addProductModal .modal-content {
    height: 100%;
    max-height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

#addProductModal form {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
    overflow: hidden;
}

#addProductModal .modal-header,
#addProductModal .modal-footer {
    flex: 0 0 auto;
    background: #fff;
}

#addProductModal .modal-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: scroll !important;
    overscroll-behavior: contain;
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 575.98px) {
    #addProductModal .modal-dialog {
        height: calc(100vh - 16px);
        max-height: calc(100vh - 16px);
        margin: 8px;
    }
}

    </style>
</head>
<body class="bg-white">
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container py-2">
        <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('home') }}">LocalMarket</a>
        <div class="d-flex align-items-center gap-2 ms-auto">
            @auth
                <a class="btn btn-outline-secondary" href="{{ route('account.listings.index') }}">My listings</a>
                <!-- <a class="btn btn-primary" href="{{ route('account.listings.create') }}">Add Product</a> -->
                <button type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addProductModal">
                    Add Product
                </button>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-link text-secondary">Logout</button></form>
            @else
                <a class="btn btn-outline-secondary" href="{{ route('login') }}">Login</a>
                <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>
<main class="container py-4">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @yield('content')
</main>
<footer class="border-top mt-5 py-4"><div class="container text-secondary small">© {{ date('Y') }} LocalMarket · Buy, sell and discover local services.</div></footer>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1"
     aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold" id="addProductModalLabel">
                        Add Product / Service
                    </h5>
                    <!-- <small class="text-muted">
                        Enter your listing details below.
                    </small> -->
                </div>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('account.listings.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Listing type -->
                        <div class="col-md-6">
                            <label class="form-label">Listing Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="">Select type</option>
                                <option value="product" @selected(old('type') === 'product')>
                                    Product
                                </option>
                                <option value="service" @selected(old('type') === 'service')>
                                    Service
                                </option>
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @selected((string) old('category_id') === (string) $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product name -->
                        <div class="col-12">
                            <label class="form-label">Product / Service Name *</label>
                            <input type="text" name="name"
                                   class="form-control"
                                   value="{{ old('title') }}"
                                   placeholder="Enter product or service name"
                                   maxlength="160" required>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control"
                                      rows="4" required
                                      placeholder="Describe your product or service">{{ old('description') }}</textarea>
                        </div>

                        <!-- Price -->
                        <div class="col-md-6">
                            <label class="form-label">Price (₹) *</label>
                            <input type="number" name="price"
                                   class="form-control"
                                   value="{{ old('price') }}"
                                   min="0" step="0.01" required
                                   placeholder="Enter price">
                        </div>

                        <!-- Country -->
                        <div class="col-md-6">
                            <label class="form-label">Country *</label>
                            <input type="text" name="country"
                                   class="form-control"
                                   value="{{ old('country', 'India') }}" required>
                        </div>

                        <!-- State -->
                        <div class="col-md-6">
                            <label class="form-label">State *</label>
                            <input type="text" name="state"
                                   class="form-control"
                                   value="{{ old('state') }}"
                                   placeholder="Enter state" required>
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <label class="form-label">City *</label>
                            <input type="text" name="city"
                                   class="form-control"
                                   value="{{ old('city') }}"
                                   placeholder="Enter city" required>
                        </div>

                        <!-- Area -->
                        <div class="col-12">
                            <label class="form-label">Area / Locality</label>
                            <input type="text" name="area"
                                   class="form-control"
                                   value="{{ old('area') }}"
                                   placeholder="Enter area or locality">
                        </div>

                        <!-- Images -->
                        <div class="col-12">
                            <label class="form-label">Product Images</label>
                            <input type="file" name="images[]"
                                   class="form-control"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   multiple>
                            <small class="text-muted">
                                Upload up to 8 images, maximum 5 MB per image.
                            </small>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Submit Listing
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
