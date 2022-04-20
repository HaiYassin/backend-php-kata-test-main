<?php

namespace App\Strategy;

use App\Entity\Lesson;
use App\Strategy\Type\RenderInstructorName;

class RenderSubject implements RenderSubjectInterface {
    
    const VALID_DATA_LIST = [
        RenderInstructorName::INSTRUCTOR_NAME
    ];

    const FIRST_KEY = 0;
    const SECOND_KEY = 1;

    public function messageSubject(Lesson $lesson, string &$text): string {

        $message = $text;

        foreach(self::VALID_DATA_LIST as $key => $data) {
            switch($data) {
                case RenderInstructorName::INSTRUCTOR_NAME :
                    $renderStrategy = new RenderInstructorName();
                    break;
                default:
                    throw new \RuntimeException('This strategy is not supported.');
            }

            if($key === self::FIRST_KEY) {
                $renderMessage = new RenderMessage($renderStrategy);
            }

            if($key >= self::SECOND_KEY) {
                $renderMessage->setRenderStrategy($renderStrategy);
            }

            $message = $renderMessage->renderMessage($lesson, $message);
        }

        return $message;
    }
}
