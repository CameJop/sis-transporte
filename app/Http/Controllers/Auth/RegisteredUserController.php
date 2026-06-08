<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'documento_identidad'  => 'required|string|max:50|exists:cliente,documento_identidad',
            'email'                => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password'             => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'documento_identidad.exists' => 'El CI ingresado no está registrado como pasajero. Contacta a Trans. Copacabana S.A.',
        ]);

        $user = User::create([
            'name'                => $request->name,
            'documento_identidad' => $request->documento_identidad,
            'email'               => $request->email,
            'password'            => Hash::make($request->password),
        ]);

        // Asignar rol cliente automáticamente
        $user->assignRole('cliente');

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}