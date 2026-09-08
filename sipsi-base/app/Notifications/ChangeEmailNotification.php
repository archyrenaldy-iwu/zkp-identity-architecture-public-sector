<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeEmailNotification extends Notification
{
    use Queueable;

    public $token;

    public $newEmail;

    public function __construct($token, $newEmail)
    {
        $this->token = $token;
        $this->newEmail = $newEmail;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Halo, '.$notifiable->name.'!')
            ->subject('Konfirmasi Perubahan Alamat Email Akun Anda')
            ->line('Kami telah menerima permintaan Anda untuk mengubah alamat email yang terdaftar di akun Anda menjadi **'.$this->newEmail.'**. Untuk melanjutkan proses ini, kami memerlukan konfirmasi dari Anda.')
            ->line('Silakan klik tautan di bawah ini untuk mengonfirmasi perubahan alamat email Anda:')
            ->action('Konfirmasi', url(config('app.url').route('auth.confirm-change-email', ['token' => $this->token, 'new_email' => $this->newEmail], false)))
            ->line('Jika Anda tidak meminta perubahan ini, harap abaikan email ini. Akun Anda akan tetap menggunakan alamat email saat ini dan tidak ada perubahan yang akan dilakukan.')
            ->salutation('Komisi Informasi');
    }
}
