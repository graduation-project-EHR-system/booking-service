<?php
namespace App\Services;

use App\Enums\Topic;
use App\Interfaces\ConsumerHandler;
use App\Interfaces\EventConsumer;
use Junges\Kafka\Facades\Kafka;

class KafkaEventConsumer implements EventConsumer
{
    protected Topic $topic;

    protected ConsumerHandler $handler;

    public static function make(): self
    {
        return new self();
    }

    public function onTopic(Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function withHandler(ConsumerHandler $handler): self
    {
        $this->handler = $handler;

        return $this;
    }

    public function consume(): void
    {
        Kafka::consumer([$this->topic->value])
            ->withHandler($this->handler)
            ->build()
            ->consume();
    }
}
