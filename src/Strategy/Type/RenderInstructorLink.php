<?php

namespace App\Strategy\Type;

use App\Entity\Lesson;
use App\Repository\InstructorRepository;
use App\Strategy\RenderMessageInterface;

class RenderInstructorLink implements RenderMessageInterface {
    
    const INSTRUCTOR_LINK = '[lesson:instructor_link]';

    public function replaceTextByContent(Lesson $lesson, string &$text): string
    {
        //  @TODO ADD CHECK INSTRUCTOR EXIST
        $instructor = InstructorRepository::getInstance()->getById($lesson->instructorId);

        $message = 'instructors/' . $instructor->id .'-'.urlencode($instructor->firstname);

        return (false !== strpos($text, self::INSTRUCTOR_LINK)) ? 
            $this->replaceMessage($message, $text)
            : $this->replaceMessage('', $text);
    }

    private function replaceMessage (string $message, string $text): string {
        return str_replace(self::INSTRUCTOR_LINK, $message, $text);
    }
}
