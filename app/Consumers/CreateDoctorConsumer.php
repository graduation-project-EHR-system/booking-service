<?php
namespace App\Consumers;

use App\Interfaces\ConsumerHandler;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\ConsumerMessage;

class CreateDoctorConsumer implements ConsumerHandler
{
    public function __invoke(ConsumerMessage $message): void
    {
        Log::info('kafka message received in create doctor consumer', ['message' => $message]);

        $body = $message->getBody();

        Log::info('kafka message body in create doctor consumer', ['body' => $body]);
        
        if ($body['data']['role'] !== 'DOCTOR') {
            return;
        }

        $doctor = Doctor::create([
            'id' => $body['data']['id'],
            'name' => $body['data']['firstName'] . ' ' . $body['data']['lastName'],
            'specialization' => $body['data']['specialization'],
        ]);

        Log::info('Doctor created in create doctor consumer', ['doctor' => $doctor]);
    }
}
