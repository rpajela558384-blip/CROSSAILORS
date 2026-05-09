<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficerProfileController extends Controller
{
    public function index()
    {
        $officers = OfficerProfile::with('user')->orderBy('display_order')->orderBy('created_at')->get();
        return view('officer.officers.index', compact('officers'));
    }

    public function create()
    {
        $alreadyOnBoard = OfficerProfile::pluck('user_id');
        $eligible = User::whereIn('role', ['officer', 'admin'])
            ->where('is_active', true)
            ->whereNotIn('id', $alreadyOnBoard)
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'avatar']);

        return view('officer.officers.create', compact('eligible'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $alreadyOnBoard = OfficerProfile::pluck('user_id');

        $users = User::where('is_active', true)
            ->whereNotIn('id', $alreadyOnBoard)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'avatar', 'role']);

        return response()->json($users->map(fn ($u) => [
            'id'     => $u->id,
            'name'   => $u->name,
            'email'  => $u->email,
            'role'   => $u->role,
            'avatar' => $u->avatar ? Storage::url($u->avatar) : null,
        ]));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'position'      => 'nullable|string|max:255',
            'bio'           => 'nullable|string|max:1000',
            'contact_info'  => 'nullable|string|max:255',
            'photo'         => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'display_order' => 'integer|min:0',
        ]);

        $user = User::findOrFail($validated['user_id']);
        if (!in_array($user->role, ['officer', 'admin'])) {
            return back()->withErrors(['user_id' => 'Only officers or admins can be added to the board.']);
        }

        if (OfficerProfile::where('user_id', $validated['user_id'])->exists()) {
            return back()->withErrors(['user_id' => 'This person is already on the board.']);
        }

        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('officer_photos', 'public');
        }

        $profile = OfficerProfile::create([
            'user_id'       => $validated['user_id'],
            'position'      => $validated['position'] ?? null,
            'bio'           => $validated['bio'] ?? null,
            'contact_info'  => $validated['contact_info'] ?? null,
            'photo'         => $photo,
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return redirect()->route('officer.officers.index')->with('success', $profile->user->name . ' has been added to the officer board.');
    }

    public function edit(OfficerProfile $officer)
    {
        return view('officer.officers.edit', compact('officer'));
    }

    public function update(Request $request, OfficerProfile $officer)
    {
        $validated = $request->validate([
            'position'      => 'nullable|string|max:255',
            'bio'           => 'nullable|string|max:1000',
            'contact_info'  => 'nullable|string|max:255',
            'photo'         => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'display_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            if ($officer->photo) {
                Storage::disk('public')->delete($officer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('officer_photos', 'public');
        } else {
            unset($validated['photo']);
        }

        $officer->update($validated);

        return redirect()->route('officer.officers.index')->with('success', 'Board entry updated.');
    }

    public function destroy(OfficerProfile $officer)
    {
        $name = $officer->user->name;
        if ($officer->photo) {
            Storage::disk('public')->delete($officer->photo);
        }
        $officer->delete();
        return back()->with('success', $name . ' has been removed from the board.');
    }
}
