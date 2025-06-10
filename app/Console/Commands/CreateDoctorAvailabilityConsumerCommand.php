<?php

namespace App\Console\Commands;

use App\Consumers\CreateDoctorAvailabilityConsumer;
use App\Interfaces\EventConsumer;
use Illuminate\Console\Command;

class CreateDoctorAvailabilityConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:create-doctor-availability-consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start consuming doctor availability created events');

        app(EventConsumer::class)
            ->onTopic(\App\Enums\Topic::DOCTOR_AVAILABILITY_CREATED)
            ->withHandler(new CreateDoctorAvailabilityConsumer)
            ->consume();

    }
}
