<?php

namespace App\Strategy\Type;

use App\Entity\Lesson;
use App\Strategy\RenderMessageInterface;

class RenderStartDate implements RenderMessageInterface {
    const START_DATE = '[lesson:start_date]';
    const FORMAT_DATE = 'd/m/Y';
    
    public function replaceTextByContent(Lesson $lesson, string &$text): string {
        return false !== strpos($text, self::START_DATE) ? 
            str_replace(self::START_DATE, $lesson->start_time->format(self::FORMAT_DATE), $text) : $text;
    }
}
