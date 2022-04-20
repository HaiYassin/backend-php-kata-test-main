<?php

namespace App\Strategy\Type;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use App\Strategy\RenderMessageInterface;

class RenderSummary implements RenderMessageInterface {
    const SUMMARY = '[lesson:summary]';
    const SUMMARY_HTML = '[lesson:summary_html]';

    public function replaceTextByContent (Lesson $lesson, string &$text): string {
        //Add check for lesson
        $lesson = LessonRepository::getInstance()->getById($lesson->id);

        return false !== strpos($text, self::SUMMARY_HTML) ? 
            $this->getRenderHtml($lesson, $text):$this->getRenderText($lesson, $text); 
    }

    private function getRenderHtml(Lesson $lesson, string $text): string {
        return str_replace(
            self::SUMMARY_HTML,
            Lesson::renderHtml($lesson),
            $text
        );
    }

    private function getRenderText(Lesson $lesson, string $text): string {
        return str_replace(
            self::SUMMARY,
            Lesson::renderText($lesson),
            $text
        );
    }
}