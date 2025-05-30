<?php
namespace App\Consumers;

use App\Interfaces\ConsumerHandler;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\ConsumerMessage;

class CreateDoctorConsumer implements ConsumerHandler
{
    public function __invoke(ConsumerMessage $message): void
    {
        Log::info('Kafka message received', [
            'topic' => $message->getTopicName(),
        ]);
    }
}
