<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('main.content.settings.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('assets/images/users');

            if ($user->image && file_exists($destinationPath . '/' . $user->image)) {
                unlink($destinationPath . '/' . $user->image);
            }

            $image->move($destinationPath, $filename);

            $data['image'] = $filename;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')
            ->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update basic "About" info via AJAX from the profile page.
     */
    public function updateAbout(Request $request): JsonResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'description' => ['nullable', 'string', 'max:1000'],
            'date_of_birth' => ['nullable', 'date'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:single,married'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->fill($data);

        // If email changed here, also clear verification like in main update
        if (array_key_exists('email', $data) && $user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'user' => [
                'description' => $user->description,
                'date_of_birth' => $user->date_of_birth,
                'phone_number' => $user->phone_number,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'formatted_dob' => $user->date_of_birth
                    ? $user->date_of_birth
                    : null,
            ],
        ]);
    }
}
