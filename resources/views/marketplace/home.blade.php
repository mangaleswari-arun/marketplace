@extends('layouts.app')

@section('content')
<div class="bg-light rounded-4 p-4 p-md-5 mb-4">
    <h1 class="fw-bold">Find it. Sell it. Share your services.</h1>
    <p class="text-secondary">Discover great deals and trusted services near you.</p>
    <form method="GET" action="{{ route('home') }}" class="row g-2">
        <div class="col-md-6"><input class="form-control form-control-lg" name="q" value="{{ request('q') }}" placeholder="What are you looking for?"></div>
        <div class="col-md-4"><input class="form-control form-control-lg" name="city" value="{{ request('city') }}" placeholder="City"></div>
        <div class="col-md-2 d-grid"><button class="btn btn-primary btn-lg">Search</button></div>
    </form>
</div>
<h2 class="h4 mb-3">Browse categories</h2>
<div class="d-flex flex-wrap gap-2 mb-4">
@forelse($categories as $category)
    <a class="btn btn-outline-secondary rounded-pill" href="{{ route('category.show', $category) }}">{{ $category->name }}</a>
@empty
    <span class="text-secondary">Categories will appear here once added by an administrator.</span>
@endforelse
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4 mb-0">Latest listings</h2>
    <!-- @auth <a class="btn btn-primary" href="{{ route('account.listings.create') }}">Post an Ad</a>
    @else <a class="btn btn-primary" href="{{ route('login') }}">Login to Post an Ad</a> @endauth -->
</div>
@include('marketplace.partials.cards', ['listings' => $listings])
@endsection
