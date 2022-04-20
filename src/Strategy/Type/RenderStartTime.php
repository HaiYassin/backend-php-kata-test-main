<?php

namespace App\Strategy\Type;

use App\Entity\Lesson;
use App\Strategy\RenderMessageInterface;

class RenderStartTime implements RenderMessageInterface {
    const START_TIME = '[lesson:start_time]';
    const FORMAT_TIME = 'H:i';

    public function replaceTextByContent(Lesson $lesson, string &$text): string {
        return false !== strpos($text, self::START_TIME) ?
            str_replace(self::START_TIME, $lesson->start_time->format(self::FORMAT_TIME), $text) : $text;
    }
}
