@extends('layouts.app')
@section('content')
<h1 class="h3 mb-4">{{ $listing->exists ? 'Edit listing' : 'Post a new ad' }}</h1>
<form method="POST" enctype="multipart/form-data" action="{{ $listing->exists ? route('account.listings.update', $listing) : route('account.listings.store') }}" class="card border-0 shadow-sm">
    @csrf
    @if($listing->exists) @method('PUT') @endif
    <div class="card-body p-4"><div class="row g-3">
        <div class="col-md-6"><label class="form-label">Listing type *</label><select class="form-select" name="type" required><option value="product" @selected(old('type', $listing->type)==='product')>Product</option><option value="service" @selected(old('type', $listing->type)==='service')>Service</option></select></div>
        <div class="col-md-6"><label class="form-label">Category *</label><select class="form-select" name="category_id" required><option value="">Choose category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $listing->category_id)==$category->id)>{{ $category->parent ? $category->parent->name.' / ' : '' }}{{ $category->name }}</option>@endforeach</select></div>
        <div class="col-12"><label class="form-label">Name *</label><input class="form-control" name="name" maxlength="180" required value="{{ old('name', $listing->name) }}"></div>
        <div class="col-12"><label class="form-label">Details *</label><textarea class="form-control" name="description" rows="5" required>{{ old('detail', $listing->detail) }}</textarea></div>
        <div class="col-md-4"><label class="form-label">Country *</label><input class="form-control" name="country" required value="{{ old('country', $listing->country ?? 'India') }}"></div>
        <div class="col-md-4"><label class="form-label">State *</label><input class="form-control" name="state" required value="{{ old('state', $listing->state) }}"></div>
        <div class="col-md-4"><label class="form-label">City *</label><input class="form-control" name="city" required value="{{ old('city', $listing->city) }}"></div>
        <div class="col-md-6"><label class="form-label">Area / locality</label><input class="form-control" name="area" value="{{ old('area', $listing->area) }}"></div>
        <div class="col-md-6"><label class="form-label">Price (INR)</label><input class="form-control" type="number" name="price" min="0" step="0.01" value="{{ old('price', $listing->price) }}"></div>
        <div class="col-12"><label class="form-label">Photos (up to 8, 5 MB each)</label><input class="form-control" type="file" name="images[]" accept=".jpg,.jpeg,.png,.webp" multiple></div>
        @if($errors->any())<div class="col-12 alert alert-danger mb-0"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="col-12"><button class="btn btn-primary btn-lg">{{ $listing->exists ? 'Save changes' : 'Publish listing' }}</button></div>
    </div></div>
</form>
@endsection
