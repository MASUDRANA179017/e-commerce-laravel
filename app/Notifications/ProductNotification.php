<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $product;
    public $title;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($product, $title, $message)
    {
        $this->product = $product;
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title)
            ->line($this->message)
            ->action('View Product', route('product.show', $this->product->slug))
            ->line('Thank you for shopping with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'title' => $this->title,
            'message' => $this->message,
            'image' => $this->product->coverImage ? asset('storage/' . $this->product->coverImage->path) : null,
            'url' => route('product.show', $this->product->slug),
        ];
    }
}
