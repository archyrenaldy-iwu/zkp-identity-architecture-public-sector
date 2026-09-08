<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPasswordBase
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Password SISE')
            ->greeting('Halo '.$notifiable->name.'!')
            ->line('Kamu menerima email ini karena kami menerima permintaan reset password untuk akun kamu.')
            ->action('Reset Password', url(config('app.url').route('ganti_sandi', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
            ->line('Jika kamu tidak merasa melakukan permintaan reset password, abaikan email ini.')
            ->salutation('Komisi Informasi');
    }
}
