<?php

namespace App\Strategy;

use App\Entity\Lesson;

abstract class AbtractMessage {
    abstract protected function handleMessage(Lesson $lesson, string $message);
}
