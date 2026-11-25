@extends('layouts.app')
@section('content')
<!-- <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">My listings</h1><a class="btn btn-primary" href="{{ route('account.listings.create') }}">Post an Ad</a>
</div> -->
<div class="list-group">
@forelse($listings as $listing)
    <div class="list-group-item d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div><a class="fw-semibold text-decoration-none" href="{{ route('listing.show', $listing) }}">{{ $listing->name }}</a><div class="small text-secondary">{{ ucfirst($listing->type) }} · {{ $listing->city }} · {{ ucfirst($listing->status) }}</div></div>
        <div class="d-flex gap-2"><a class="btn btn-outline-secondary btn-sm" href="{{ route('account.listings.edit', $listing) }}">Edit</a><form method="POST" action="{{ route('account.listings.destroy', $listing) }}" onsubmit="return confirm('Delete this listing?')">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">Delete</button></form></div>
    </div>
@empty <div class="list-group-item text-secondary">You have not posted any listings yet.</div> @endforelse
</div>

@endsection
