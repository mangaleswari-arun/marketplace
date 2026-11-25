<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function home(Request $request)
    {
        $listings = Listing::published()->with(['category', 'images'])
            ->when($request->filled('q'), fn ($q) => $q->where(function ($sub) use ($request) {
                $sub->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('detail', 'like', '%' . $request->q . '%');
            }))
            ->when($request->filled('city'), fn ($q) => $q->where('city', 'like', '%' . $request->city . '%'))
            ->latest()->paginate(100)->withQueryString();

        $categories = Category::whereNull('parent_id')->where('is_active', true)->orderBy('name')->get();

        return view('marketplace.home', compact('listings', 'categories'));
    }

    public function category(Category $category)
    {
        $listings = Listing::published()->where('category_id', $category->id)
            ->with(['category', 'images'])->latest()->paginate(12);
        return view('marketplace.results', ['listings' => $listings, 'heading' => $category->name]);
    }

    public function city(string $country, string $state, string $city)
    {
        $listings = Listing::published()->where('country', 'like', str_replace('-', ' ', $country))
            ->where('state', 'like', str_replace('-', ' ', $state))
            ->where('city', 'like', str_replace('-', ' ', $city))
            ->with(['category', 'images'])->latest()->paginate(12);
        return view('marketplace.results', ['listings' => $listings, 'heading' => ucwords(str_replace('-', ' ', $city))]);
    }

    public function cityCategory(string $country, string $state, string $city, Category $category)
    {
        $listings = Listing::published()->where('country', 'like', str_replace('-', ' ', $country))
            ->where('state', 'like', str_replace('-', ' ', $state))
            ->where('city', 'like', str_replace('-', ' ', $city))
            ->where('category_id', $category->id)
            ->with(['category', 'images'])->latest()->paginate(12);
        return view('marketplace.results', [
            'listings' => $listings,
            'heading' => $category->name . ' in ' . ucwords(str_replace('-', ' ', $city)),
        ]);
    }

    public function show(Listing $listing)
    {
        abort_unless($listing->status === 'published', 404);
        $listing->load(['category', 'images', 'user']);
        return view('marketplace.show', compact('listing'));
    }
}
