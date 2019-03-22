<?php

namespace App\Listeners;

use App\Events\likeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LikeEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  likeEvent  $event
     * @return void
     */
    public function handle(likeEvent $event)
    {
        //
    }
}
