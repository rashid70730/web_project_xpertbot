<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Film;

class FilmApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $film;

    public function __construct(Film $film)
    {
        $this->film = $film;
    }

    public function via($notifiable)
    {
        return ['database', 'log']; // safe for testing
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Film Accepted: ' . $this->film->title)
            ->line('Your film "' . $this->film->title . '" has been accepted!')
            ->action('View Film', url('/films/' . $this->film->id))
            ->line('Thank you for using Zigzack!');
    }

    public function toArray($notifiable)
    {
        return [
            'film_id' => $this->film->id,
            'title' => $this->film->title,
            'message' => 'Your film has been accepted!'
        ];
    }
}