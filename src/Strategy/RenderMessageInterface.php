<?php

namespace App\Strategy;

use App\Entity\Lesson;

interface RenderMessageInterface {
    public function replaceTextByContent(Lesson $lesson ,string &$text): string;
}
