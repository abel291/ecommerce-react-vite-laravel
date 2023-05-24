<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

	public function index(): Response
	{
		return Inertia::render('Profile/Dashboard');
	}

	public function orders(): Response
	{
		return Inertia::render('Profile/Orders', [
			'orders' => OrderResource::collection(auth()->user()->orders()->orderBy('id', 'desc')->paginate(10))
		]);
	}


	public function account_details(): Response
	{
		return Inertia::render('Profile/AccountDetails');
	}
	/**
	 * Update the user's profile information.
	 */
	public function update(ProfileUpdateRequest $request): RedirectResponse
	{
		$request->user()->fill($request->validated());

		if ($request->user()->isDirty('email')) {
			$request->user()->email_verified_at = null;
		}

		$request->user()->save();

		return Redirect::route('profile-details')->with('success', 'Datos actualizados con exito');
	}

	public function change_password(): Response
	{
		return Inertia::render('Profile/ChangePassword');
	}
	public function password_update(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'current_password' => ['required', 'current_password'],
			'password' => ['required', Password::defaults(), 'confirmed'],
		]);

		$request->user()->update([
			'password' => Hash::make($validated['password']),
		]);
		return Redirect::route('profile-password')->with('success', 'Datos actualizados con exito');
	}

	public function order($code)
	{
		$order = auth()->user()->orders()->with('order_products')->where('code', $code)->first();
		return Inertia::render('Profile/Order', [
			'order' => new OrderResource($order),
		]);
	}
}
