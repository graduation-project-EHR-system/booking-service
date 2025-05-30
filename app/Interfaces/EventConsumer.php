<?php
namespace App\Interfaces;

use App\Enums\Topic;

interface EventConsumer
{
    public static function make(): self;

    public function onTopic(Topic $topic): self;

    public function withHandler(ConsumerHandler $handler): self;

    public function consume(): void;
}
