<?php
namespace App\Console\Commands;

use App\Consumers\CreateDoctorConsumer;
use App\Enums\Topic;
use App\Interfaces\EventConsumer;
use Illuminate\Console\Command;

class CreateDoctorConsumerCommand extends Command
{
    protected $signature   = 'kafka:create-doctor-consumer';
    protected $description = 'Create a doctor consumer';

    public function handle()
    {
        $this->info('Start consuming doctor created events');

        app(EventConsumer::class)
            ->onTopic(Topic::DOCTOR_CREATED)
            ->withHandler(new CreateDoctorConsumer())
            ->consume();
    }
}
