<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password Akun Sapu Jagat')
            ->greeting('Halo!')
            ->line('Kami menerima permintaan untuk mereset password akun Anda.')
            ->line('Klik tombol di bawah ini untuk mengganti password Anda:')
            ->action('Reset Password', $url)
            ->line('Link ini hanya berlaku selama 60 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Terima kasih, tim Sapu Jagat');
    }
}
