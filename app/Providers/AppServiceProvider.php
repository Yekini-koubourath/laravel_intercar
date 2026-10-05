<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // E-mail de réinitialisation du mot de passe en français
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe - INTERCAR')
                ->greeting('Bonjour ' . $notifiable->name . ',')
                ->line('Une demande de réinitialisation de mot de passe a été faite pour votre compte INTERCAR.')
                ->action('Réinitialiser mon mot de passe', $url)
                ->line('Ce lien expirera dans 60 minutes.')
                ->line("Si vous n'êtes pas à l'origine de cette demande, aucune action n'est nécessaire.")
                ->salutation("L'équipe INTERCAR");
        });
    }
}