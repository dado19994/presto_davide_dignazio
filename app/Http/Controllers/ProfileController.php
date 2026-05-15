<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'bio' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:120'],
            'avatar' => ['nullable', 'image', 'max:1024'],
        ], [
            'bio.max' => 'La bio può contenere al massimo 500 caratteri.',
            'city.max' => 'La città/zona può contenere al massimo 120 caratteri.',
            'avatar.image' => 'Il file deve essere un’immagine.',
            'avatar.max' => 'L’avatar può pesare al massimo 1MB.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        unset($validated['avatar']);

        $user->update([
            'bio' => $validated['bio'] ?: null,
            'city' => $validated['city'] ?: null,
            'avatar_path' => $validated['avatar_path'] ?? $user->avatar_path,
        ]);

        return back()->with('success', 'Profilo aggiornato con successo.');
    }
}
