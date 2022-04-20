<?php

namespace App\Strategy\Type;

use App\Entity\Lesson;
use App\Repository\MeetingPointRepository;
use App\Strategy\RenderMessageInterface;

class RenderMeetingPoint implements RenderMessageInterface {
    const MEETING_POINT = '[lesson:meeting_point]';

    public function replaceTextByContent(Lesson $lesson, string &$text): string {
        // @TODO ADD A CHECK MEETINGPOINT EXIST 
        $meetingPoint = MeetingPointRepository::getInstance()->getById($lesson->meetingPointId);

        $message = $meetingPoint->name;

        return false !== strpos($text, '[lesson:meeting_point]') ?
            str_replace('[lesson:meeting_point]', $message, $text ) : $text;
    }
}
