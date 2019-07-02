<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use TelegramNotifications\Messages\TelegramMessage;
use TelegramNotifications\TelegramChannel;

class TelegramNotification extends Notification
{
    use Queueable;


    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via()
    {
        return [TelegramChannel::class];
    }

    public function toTelegram()
    {
      //  return (new TelegramMessage())->text( $this->details['text'],$this->parse_mode(true));
        return (new TelegramMessage())
        ->text($this->details['text'])
        ->parse_mode('HTML');
    }



}
