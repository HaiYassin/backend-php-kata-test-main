<?php

namespace App\Strategy;

use App\Entity\Lesson;

interface RenderContentInterface {
    public function messageContent(Lesson $lesson ,string &$text): string;
}