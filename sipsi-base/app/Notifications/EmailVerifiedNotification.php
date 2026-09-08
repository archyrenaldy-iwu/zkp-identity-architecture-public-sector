<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerifiedNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Halo, '.$notifiable->name.'!')
            ->subject('Berhasil Aktivasi Akun SISE')
            ->line('Email anda berhasil diverifikasi. Silahkan login untuk melanjutkan.')
            ->action('Masuk', route('login'))
            ->line('Jika Anda mengalami kesulitan atau pertanyaan, silakan hubungi Kami melalui email sekretariat@komisiinformasi.go.id atau melalui WhatsApp di nomor 0853-4532-3343.')
            ->salutation('Komisi Informasi');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
