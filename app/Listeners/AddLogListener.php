<?php

namespace App\Listeners;

use App\Dto\AddLogDto;
use App\Events\AddContactEvent;
use App\LogsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddLogListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public LogsService $service)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AddContactEvent $event): void
    {
        $this->service->addLog(new AddLogDto(
            $event->action,
            $event->result,
        ));
    }
}
