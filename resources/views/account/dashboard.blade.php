```blade
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>My Dashboard</h2>

    <p>Welcome, {{ auth()->user()->name }}!</p>

    <a href="{{ route('account.listings.index') }}"
       class="btn btn-primary">
        My Listings
    </a>

    <a href="{{ route('account.listings.create') }}"
       class="btn btn-success">
        Add New Listing
    </a>
</div>
@endsection
```