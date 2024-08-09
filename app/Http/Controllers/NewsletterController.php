<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class NewsletterController extends Controller
{
    public function newsletter(Request $request)
    {
        sleep(3);
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        return Redirect::back()->with('success', 'Suscripción completada con exito');
    }
}
