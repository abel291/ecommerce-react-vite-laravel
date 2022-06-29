<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class AuthenticationController extends Controller
{
    //this method adds new users
    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email'],
            'phone' => $attr['phone'],
            'country' => $attr['country'],
            'city' => $attr['city']

        ]);

        return [
            'token' => $user->createToken('tokens')->plainTextToken,
            'user' => $user->only(['name', 'email', 'phone', 'city', 'country'])
        ];
    }

    //use this method to signin users
    public function login(Request $request)
    {
        //dd('asda');
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return response()->json([
                'error' => 'Las credenciales no coinciden',                
            ],422);
            //return $this->error('Las credenciales no coinciden ', 401);
        }
        auth()->user()->tokens()->delete();

        return [
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'user' => auth()->user()->only(['name', 'email', 'phone', 'city', 'country'])
        ];
        // return $this->success([
        //     'token' => auth()->user()->createToken('API Token')->plainTextToken
        // ]);
    }

    // this method signs out users by removing tokens
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function profile_information(Request $request)
    {
        $user = auth()->user();
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
        ]);

        if (
            $request->email !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $request);
        } else {
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'city' => $request->city,
            ])->save();
        }
        return [
            'message' => 'UPDATED USER'
        ];
    }

    public function update_user_password(Request $request)
    {
        $user = auth()->user();

        Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ])->after(function ($validator) use ($user, $request) {
            if (!isset($request->current_password) || !Hash::check($request->current_password, $user->password)) {
                $validator->errors()->add('current_password', __('La contraseña proporcionada no coincide con su contraseña actual. '));
            }
        })->validateWithBag('updatePassword');
        
        
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return [
            'message' => 'updated password'
        ];
    }
}
