<?php

namespace App\Notifications;

use App\Models\AssetRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssetRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $asset_request, $user, $user_to;
    public function __construct(AssetRequest $asset_request, User $user, User $user_to)
    {
        $this->afterCommit();

        $this->asset_request = $asset_request;
        $this->user = $user;
        $this->user_to = $user_to;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if($this->asset_request->status == 'approved' || $this->asset_request->status == 'submit') {
            if($this->user->role == 'presdir') {
                $line ='Email notification asset request has been approved by ' . $this->user->name . '.';
            } else {
                $line = 'Email notification new asset request from ' . $this->user->name . '.';
            }
        } else if ($this->asset_request->status == 'revision') {
            $line ='Email notification asset requests requested to be revised from ' . $this->user->name . '.';
        } else {
            $line ='Email notification asset request has been rejected by ' . $this->user->name . '.';
        }
        return (new MailMessage)
                    ->subject('Notification Subject')
                    ->line($line)
                    ->action('See Detail', url('/asset_request/'.$this->asset_request->id))
                    ->line('Thank you');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_from' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'user_to' => [
                'id' => $this->user_to->id,
                'name' => $this->user_to->name
            ],
            'asset_request' => $this->asset_request
        ];
    }
}
