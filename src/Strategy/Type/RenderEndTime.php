<?php

namespace App\Strategy\Type;

use App\Entity\Lesson;
use App\Strategy\RenderMessageInterface;

class RenderEndTime implements RenderMessageInterface {

    const END_TIME = '[lesson:end_time]';
    const FORMAT_TIME = 'H:i';

    public function replaceTextByContent(Lesson $lesson, string &$text): string {
        return false !== strpos($text, self::END_TIME) ?
            str_replace(self::END_TIME, $lesson->end_time->format(self::FORMAT_TIME), $text) : $text;
    }
}
