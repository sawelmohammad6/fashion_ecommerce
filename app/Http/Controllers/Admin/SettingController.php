<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $imageUpload;

    public function __construct(ImageUploadService $imageUpload)
    {
        $this->imageUpload = $imageUpload;
    }

    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'website_name' => ['nullable', 'string', 'max:255'],
            'website_email' => ['nullable', 'email', 'max:255'],
            'website_phone' => ['nullable', 'string', 'max:255'],
            'website_address' => ['nullable', 'string', 'max:1000'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'twitter_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,ico', 'max:1024'],
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'logo' || $key === 'favicon') {
                continue;
            }
            Setting::set($key, $value);
        }

        if ($request->hasFile('logo')) {
            $logo = $this->imageUpload->upload($request->file('logo'), Setting::get('logo'), 'settings');
            Setting::set('logo', $logo);
        }

        if ($request->hasFile('favicon')) {
            $favicon = $this->imageUpload->upload($request->file('favicon'), Setting::get('favicon'), 'settings');
            Setting::set('favicon', $favicon);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function profile()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        auth()->user()->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
