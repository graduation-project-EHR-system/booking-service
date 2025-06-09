<?php

namespace App\Consumers;

use App\Interfaces\ConsumerHandler;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\ConsumerMessage;

class CreateDoctorAvailabilityConsumer implements ConsumerHandler
{
    public function __invoke(ConsumerMessage $message)
    {
        Log::info('kafka message received in create doctor availability consumer', ['message' => $message]);

        $bodyData = $message->getBody()['data'];

        $doctor = Doctor::find($bodyData['doctor_id']);

        if (! $doctor) {
            Log::error('Doctor not found');

            return;
        }

        $availability = $doctor->availabilities()->create([
            'id' => $bodyData['availability_id'],
            'clinic_name' => $bodyData['clinic_name'],
            'date' => $bodyData['date'],
            'from' => $bodyData['from'],
            'to' => $bodyData['to'],
        ]);

        Log::info('Doctor availability created in create doctor availability consumer', ['availability' => $availability]);
    }
}
