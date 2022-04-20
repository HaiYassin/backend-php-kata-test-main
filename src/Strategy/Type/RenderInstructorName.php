<?php

namespace App\Strategy\Type;

use App\Entity\Lesson;
use App\Repository\InstructorRepository;
use App\Strategy\RenderMessageInterface;

class RenderInstructorName implements RenderMessageInterface {

    const INSTRUCTOR_NAME = '[lesson:instructor_name]';

    public function replaceTextByContent(Lesson $lesson, string &$text): string {
        // @TODO ADD A CHECK INSTRUCTOR EXIST
        $instructor = InstructorRepository::getInstance()->getById($lesson->instructorId);

        $message = $instructor->firstname;

        return false !== strpos($text, self::INSTRUCTOR_NAME ) ? 
            str_replace(self::INSTRUCTOR_NAME, $message, $text) : $text;
    }
}
