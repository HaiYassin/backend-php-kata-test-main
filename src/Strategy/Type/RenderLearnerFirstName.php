<?php

namespace App\Strategy\Type;

use App\Context\ApplicationContext;
use App\Entity\Lesson;
use App\Strategy\RenderMessageInterface;

class RenderLearnerFirstName implements RenderMessageInterface {
    const USER_FIRST_NAME = '[user:first_name]'; 

    public function replaceTextByContent(Lesson $lesson, string &$text): string {
        // @TODO CHECK LEARNER EXIST
        $learner  = ApplicationContext::getInstance()->getCurrentUser();
        
        return false !== strpos($text, self::USER_FIRST_NAME) ? 
            str_replace(self::USER_FIRST_NAME, ucfirst(strtolower($learner->firstname)), $text)
            : $text;
    }
}
