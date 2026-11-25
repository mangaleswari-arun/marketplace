<div class="row g-3">
@forelse($listings as $listing)
    <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('listing.show', $listing) }}" class="text-decoration-none text-dark">
            <div class="card h-100 border-0 shadow-sm">
                @if($listing->images->first())
                    <img src="{{ Storage::url($listing->images->first()->path) }}" class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $listing->name }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center text-secondary" style="height:180px">No image</div>
                @endif
                <div class="card-body">
                    <div class="fw-bold fs-5">{{ $listing->price !== null ? '₹'.number_format((float)$listing->price) : 'Price on request' }}</div>
                    <div class="text-truncate">{{ $listing->name }}</div>
                    <div class="small text-secondary mt-2">{{ $listing->city }} · {{ $listing->category->name }}</div>
                </div>
            </div>
        </a>
    </div>
@empty
    <p class="text-secondary">No listings found. Try another search.</p>
@endforelse
</div>

