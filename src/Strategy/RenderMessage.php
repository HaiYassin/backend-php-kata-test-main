<?php

namespace App\Strategy;

use App\Entity\Lesson;
use App\Strategy\RenderMessageInterface;

/**
 * RenderMessage is the context of our strategy pattern.
 * 
 * RenderMessage
 */
class RenderMessage {

    private RenderMessageInterface $renderStrategy;

    public function __construct(RenderMessageInterface $render)
    {
        $this->renderStrategy = $render;
    }

    public function setRenderStrategy(RenderMessageInterface $render): void {
        $this->renderStrategy = $render;
    }

    public function renderMessage(Lesson $lesson, string &$text): string {
        return $this->renderStrategy->replaceTextByContent($lesson, $text);
    }
}
