<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'boolean',
        ]);

        $validated['image'] = $this->imageService->upload($request->file('image'), null, 'banners');

        $banner = Banner::create($validated);

        if (!empty($validated['status'])) {
            $banner->status = true;
            $banner->save();
        }

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageService->upload($request->file('image'), $banner->image, 'banners');
        } else {
            $validated['image'] = $banner->image;
        }

        $banner->update($validated);

        if (!empty($validated['status'])) {
            $banner->status = true;
            $banner->save();
        }

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $this->imageService->delete($banner->image);
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    public function toggle(Banner $banner)
    {
        $banner->status = !$banner->status;
        $banner->save();

        $message = $banner->status ? 'Banner activated.' : 'Banner deactivated.';

        return redirect()->route('admin.banners.index')
            ->with('success', $message);
    }
}
