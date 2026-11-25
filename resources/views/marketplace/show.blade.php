@extends('layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        @if($listing->images->isNotEmpty())
            <div class="row g-2">
            @foreach($listing->images as $image)
                <div class="col-6"><img class="img-fluid rounded-3 w-100" style="max-height:340px;object-fit:cover" src="{{ Storage::url($image->path) }}" alt="{{ $listing->name }}"></div>
            @endforeach
            </div>
        @else
            <div class="bg-light rounded-3 p-5 text-center text-secondary">No photos provided</div>
        @endif
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm"><div class="card-body p-4">
            <div class="text-secondary small text-uppercase">{{ ucfirst($listing->type) }} · {{ $listing->category->name }}</div>
            <h1 class="h3 mt-2">{{ $listing->name }}</h1>
            <div class="display-6 fw-bold my-3">{{ $listing->price !== null ? '₹'.number_format((float)$listing->price, 2) : 'Price on request' }}</div>
            <p class="text-secondary">{{ $listing->area ? $listing->area.', ' : '' }}{{ $listing->city }}, {{ $listing->state }}, {{ $listing->country }}</p>
            <hr><h2 class="h5">Description</h2><p style="white-space:pre-line">{{ $listing->detail }}</p>
            <hr><div class="fw-semibold">Posted by {{ $listing->user->name }}</div>
            <p class="small text-secondary mb-0">Posted {{ $listing->created_at->diffForHumans() }}</p>
        </div></div>
    </div>
</div>
@endsection
