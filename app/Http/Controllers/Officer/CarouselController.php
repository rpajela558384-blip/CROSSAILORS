<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\CarouselItem;
use App\Models\User;
use App\Notifications\NewContentPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $items = CarouselItem::orderBy('type')->orderBy('order')->paginate(10);
        return view('officer.carousel.index', compact('items'));
    }

    public function create()
    {
        return view('officer.carousel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'nullable|string|max:255',
            'caption'  => 'nullable|string|max:1000',
            'link_url' => 'nullable|url|max:2048',
            'order'    => 'integer|min:0',
            'active'   => 'boolean',
            'media'    => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,webm|max:51200',
        ]);

        try {
            if ($request->hasFile('media')) {
                $validated['image_path'] = $request->file('media')->store('carousel', 'public');
            }

            unset($validated['media']);
            $validated['type']   = 'intro';
            $validated['active'] = $request->boolean('active', true);

            $item = CarouselItem::create($validated);

            Notification::send(
                User::where('is_active', true)->get(),
                new NewContentPosted('carousel', $item->title ?? 'New item added to the home page')
            );

            return redirect()->route('officer.carousel.index')->with('success', 'Home page item added.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to add slide: ' . $e->getMessage());
        }
    }

    public function edit(CarouselItem $carousel)
    {
        return view('officer.carousel.edit', compact('carousel'));
    }

    public function update(Request $request, CarouselItem $carousel)
    {
        $validated = $request->validate([
            'title'    => 'nullable|string|max:255',
            'caption'  => 'nullable|string|max:1000',
            'link_url' => 'nullable|url|max:2048',
            'order'    => 'integer|min:0',
            'active'   => 'boolean',
            'media'    => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,webm|max:51200',
        ]);

        try {
            if ($request->hasFile('media')) {
                if ($carousel->image_path) {
                    Storage::disk('public')->delete($carousel->image_path);
                }
                $validated['image_path'] = $request->file('media')->store('carousel', 'public');
            }

            unset($validated['media']);
            $validated['active'] = $request->boolean('active', $carousel->active);

            $carousel->update($validated);

            return redirect()->route('officer.carousel.index')->with('success', 'Slide updated.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update slide: ' . $e->getMessage());
        }
    }

    public function destroy(CarouselItem $carousel)
    {
        try {
            if ($carousel->image_path) {
                Storage::disk('public')->delete($carousel->image_path);
            }
            $carousel->delete();
            return back()->with('success', 'Item deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete slide: ' . $e->getMessage());
        }
    }

    public function toggle(CarouselItem $carousel)
    {
        $carousel->update(['active' => ! $carousel->active]);
        return back()->with('success', 'Visibility updated.');
    }
}
