<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::where('user_id', auth()->id())->with('images')->latest()->get();
    
        return view('account.listings.index', compact('listings'));
    }


    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('account.listings.form', ['listing' => new Listing(), 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $category = Category::findOrFail($data['category_id']);

        $data['user_id'] = auth()->id();
        //print_r($data);exit;
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(6));
        $data['sub_cat_id'] =  $data['category_id'];
        $data['detail'] =  $data['description'];
        $data['category_id'] = $category->parent_id ?? $category->id;
        //$data['category_id'] = $category->parent_id;
        $listing = Listing::create($data);
        $this->saveImages($request, $listing);

        return redirect()->route('home', $listing)->with('success', 'Your listing has been published.');
    }

    public function edit(Listing $listing)
    {
        $this->authorizeOwner($listing);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('account.listings.form', compact('listing', 'categories'));
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorizeOwner($listing);
        //print_r("before validate");
        $data = $this->validated($request);
        $category = Category::findOrFail($data['category_id']);
        $data['category_id'] = $category->parent_id ?? $category->id;
        $data['sub_cat_id'] =  $data['category_id'];
        $data['detail'] =  $data['description'];
        //print_r($data);exit;
        $listing->update($data);
        $this->saveImages($request, $listing);

        return redirect()->route('account.listings.index')->with('success', 'Listing updated.');
    }

    public function destroy(Listing $listing)
    {
        $this->authorizeOwner($listing);
        foreach ($listing->images as $image) Storage::disk('public')->delete($image->path);
        $listing->delete();

        return back()->with('success', 'Listing deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:product,service'],
            'name' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:10000'],
            'category_id' => ['required', 'exists:categories,id'],
            'country' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:150'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }

    private function saveImages(Request $request, Listing $listing): void
    {
        foreach ($request->file('images', []) as $index => $file) {
            $path = $file->store('listings', 'public');
            $listing->images()->create(['path' => $path, 'sort_order' => $index]);
        }
    }

    private function authorizeOwner(Listing $listing): void
    {
        abort_unless($listing->user_id === auth()->id(), 403);
    }
}
