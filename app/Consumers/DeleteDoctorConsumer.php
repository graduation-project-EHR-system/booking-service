<?php
namespace App\Consumers;

use App\Interfaces\ConsumerHandler;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\ConsumerMessage;

class DeleteDoctorConsumer implements ConsumerHandler
{
    public function __invoke(ConsumerMessage $message): void
    {
        Log::info('kafka message received in delete doctor consumer', ['message' => $message]);

        $body = $message->getBody();

        Log::info('kafka message body in delete doctor consumer', ['body' => $body]);

        if ($body['data']['role'] !== 'DOCTOR') {
            return;
        }

        $doctor = Doctor::find($body['data']['id']);

        if (! $doctor) {
            Log::info('Doctor not found in delete doctor consumer', ['doctor' => $body['data']['id']]);
            return;
        }

        $doctor->delete();
        
        Log::info('Doctor deleted in delete doctor consumer', ['doctor' => $body['data']['id']]);
    }
}
