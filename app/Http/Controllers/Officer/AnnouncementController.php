<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\NewContentPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('officer.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('officer.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'         => 'required|in:image,text',
            'title'        => 'required|string|max:255',
            'body'         => 'nullable|string|max:5000',
            'link_url'     => 'nullable|url|max:2048',
            'category'     => 'required|in:announcement,schedule',
            'active'       => 'boolean',
            'published_at' => 'nullable|date',
            'image'        => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image_path'] = $request->file('image')->store('announcements', 'public');
            }

            unset($validated['image']);
            $validated['active'] = $request->boolean('active', true);
            $validated['published_at'] = $validated['published_at'] ?? now();

            $announcement = Announcement::create($validated);

            Notification::send(
                User::where('is_active', true)->get(),
                new NewContentPosted('announcement', $announcement->title)
            );

            return redirect()->route('officer.announcements.index')->with('success', 'Announcement created.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create announcement: ' . $e->getMessage());
        }
    }

    public function edit(Announcement $announcement)
    {
        return view('officer.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'type'         => 'required|in:image,text',
            'title'        => 'required|string|max:255',
            'body'         => 'nullable|string|max:5000',
            'link_url'     => 'nullable|url|max:2048',
            'category'     => 'required|in:announcement,schedule',
            'active'       => 'boolean',
            'published_at' => 'nullable|date',
            'image'        => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($announcement->image_path) {
                    Storage::disk('public')->delete($announcement->image_path);
                }
                $validated['image_path'] = $request->file('image')->store('announcements', 'public');
            }

            unset($validated['image']);
            $validated['active'] = $request->boolean('active');

            $announcement->update($validated);

            return redirect()->route('officer.announcements.index')->with('success', 'Announcement updated.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update announcement: ' . $e->getMessage());
        }
    }

    public function destroy(Announcement $announcement)
    {
        try {
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $announcement->delete();
            return back()->with('success', 'Announcement deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete announcement: ' . $e->getMessage());
        }
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['active' => ! $announcement->active]);
        return back()->with('success', 'Visibility updated.');
    }
}
