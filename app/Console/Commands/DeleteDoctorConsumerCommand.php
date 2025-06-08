<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Interfaces\EventConsumer;
use App\Enums\Topic;
use App\Consumers\DeleteDoctorConsumer;

class DeleteDoctorConsumerCommand extends Command
{
    protected $signature = 'kafka:delete-doctor-consumer';

    protected $description = 'Delete a doctor consumer';

    public function handle()
    {
        $this->info('Start consuming doctor deleted events');

        app(EventConsumer::class)
            ->onTopic(Topic::USER_CREATED)
            ->withHandler(new DeleteDoctorConsumer())
            ->consume();

    }
}
