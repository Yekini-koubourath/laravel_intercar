<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /** Page "Mot de passe oublié" (saisie de l'e-mail) */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /** Envoie l'e-mail contenant le lien de réinitialisation */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => "L'adresse e-mail est obligatoire.",
            'email.email'    => "L'adresse e-mail n'est pas valide.",
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_THROTTLED) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Veuillez patienter une minute avant de refaire une demande.']);
        }

        // Même message que le compte existe ou non (évite de révéler quels e-mails sont inscrits)
        return back()->with('status',
            "Si cette adresse e-mail correspond à un compte, un lien de réinitialisation vient de lui être envoyé.");
    }

    /** Page de choix du nouveau mot de passe (lien reçu par e-mail) */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /** Enregistre le nouveau mot de passe */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required'     => "L'adresse e-mail est obligatoire.",
            'email.email'        => "L'adresse e-mail n'est pas valide.",
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                // Le cast "hashed" du modèle User hashe le mot de passe automatiquement
                $user->forceFill([
                    'password'       => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('status', 'Mot de passe modifié avec succès. Vous pouvez vous connecter.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Ce lien est invalide ou a expiré. Veuillez refaire une demande.']);
    }
}