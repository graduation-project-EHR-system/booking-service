<?php
namespace App\Console\Commands;

use App\Consumers\UpdateDoctorConsumer;
use App\Enums\Topic;
use App\Interfaces\EventConsumer;
use Illuminate\Console\Command;

class UpdateDoctorConsumerCommand extends Command
{
    protected $signature   = 'kafka:update-doctor-consumer';
    protected $description = 'Create an update doctor consumer';

    public function handle()
    {
        $this->info('Start consuming doctor updated events');

        app(EventConsumer::class)
            ->onTopic(Topic::USER_UPDATED)
            ->withHandler(new UpdateDoctorConsumer())
            ->consume();
    }
}
