<?php

namespace App;

use App\Entity\Lesson;
use App\Entity\Template;
use App\Strategy\RenderContent;
use App\Strategy\RenderSubject;

class TemplateManager implements TemplateManagerInterface
{
    public function getTemplateComputed(Template $tpl, array $data): Template
    {
        if (!$tpl) {
            throw new \RuntimeException('There is no Template given.');
        }

        if (empty($data)) {
            throw new \RuntimeException('There is no Data given.');
        }

        $templateClone = clone($tpl);
        $templateClone->subject = $this->computeTextSubject($templateClone->subject, $data);
        $templateClone->content = $this->computeTextContent($templateClone->content, $data);

        return $templateClone;
    }

    public function computeTextSubject(string $text, array $data): string
    {
        $this->checkText($text);
        $lesson = $this->getLesson($data);

        $render = new RenderSubject();

        return $render->messageSubject($lesson, $text);
    }

    public function computeTextContent(string $text, array $data): string
    {
        $this->checkText($text);
        $lesson = $this->getLesson($data);

        $render = new RenderContent();

        return $render->messageContent($lesson, $text);
    }

    private function checkText(string $text) {
        if (empty($text)) {
            throw new \RuntimeException('The text given is not valid.');
        }
    }

    private function getLesson(array $data): ?Lesson {
        $lesson = (isset($data['lesson']) and $data['lesson'] instanceof Lesson) ? $data['lesson'] : null;

        if (empty($lesson)) {
            throw new \RuntimeException('The value of lesson is null.');
        }

        return $lesson;
    }
}
