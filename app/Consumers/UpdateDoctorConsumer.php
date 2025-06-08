<?php
namespace App\Consumers;

use App\Interfaces\ConsumerHandler;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\ConsumerMessage;

class UpdateDoctorConsumer implements ConsumerHandler
{
    public function __invoke(ConsumerMessage $message): void
    {
        Log::info('kafka message received in update doctor consumer', ['message' => $message]);

        $body = $message->getBody();

        Log::info('kafka message body in update doctor consumer', ['body' => $body]);

        if ($body['data']['role'] !== 'DOCTOR') {
            return;
        }

        $doctor = Doctor::find($body['data']['id']);

        if (! $doctor) {
            Log::warning('Doctor not found for update', ['id' => $body['data']['id']]);
            return;
        }

        $doctor->update([
            'name'           => $body['data']['firstName'] . ' ' . $body['data']['lastName'],
            'specialization' => $body['data']['specialization'],
        ]);

        Log::info('Doctor updated in update doctor consumer', ['doctor' => $doctor]);
    }
}
