<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        if (! $notifiable) {
            Log::error('Notifiable is null when generating verification URL.');

            return '';
        }

        Log::info('Generating verification URL', ['notifiable_id' => $notifiable->getKey()]);

        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addDay(1),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info($notifiable);
        $verificationUrl = $this->verificationUrl($notifiable);
        $dayWithTime = Carbon::now()->addDay(1)->format('d F Y H:i:s');
        // $link = '<a href="'.$verificationUrl.'">'.$verificationUrl.'</a>';
        //get name from notifiable
        $name = $notifiable->name;

        return (new MailMessage)
            ->greeting('Hai '.$name)
            ->subject('Aktivasi Akun SISE')
            ->line('Terima kasih sudah mendaftar Akun SISE.')
            ->line('Silakan klik tombol di bawah ini sebelum '.$dayWithTime.' untuk mengaktifkan Akun SISE Anda:')
            ->action('Aktivasi', $verificationUrl)
                    // ->line('Jika tombol di atas tidak berfungsi, silakan copy dan paste alamat '. $link .' ke dalam browser Anda.')
            ->line('Jika Anda mengalami kesulitan atau pertanyaan, silakan hubungi Kami melalui email sekretariat@komisiinformasi.go.id atau melalui WhatsApp di nomor 0853-4532-3343.')
            ->salutation('Komisi Informasi');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
