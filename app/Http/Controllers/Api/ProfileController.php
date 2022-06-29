<?php

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function orders()
    {

        $orders = auth()->user()->orders()->with('products')->paginate();

        return response()->json([
            'orders' => $orders,
        ]);
    }
    public function order_details($code_order)
    {

        $order = auth()->user()->orders()->where('code', $code_order)->with('products')->firstOrFail();

        return response()->json([
            'order' => new OrderResource($order),
        ]);
    }
    public function profile_store(Request $request)
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

    public function password_store(Request $request)
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
