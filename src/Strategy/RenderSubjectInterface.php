<?php

namespace App\Strategy;

use App\Entity\Lesson;

interface RenderSubjectInterface {
    public function messageSubject(Lesson $lesson ,string &$text): string;
}