<?php

namespace App;

use App\Entity\Template;

interface TemplateManagerInterface {
    public function getTemplateComputed(Template $tpl, array $data): Template;

    public function computeTextSubject(string $text, array $data): string;

    public function computeTextContent(string $text, array $data): string;
}
