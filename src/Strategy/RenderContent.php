<?php

namespace App\Strategy;

use App\Entity\Lesson;
use App\Strategy\Type\RenderEndTime;
use App\Strategy\Type\RenderInstructorName;
use App\Strategy\Type\RenderLearnerFirstName;
use App\Strategy\Type\RenderMeetingPoint;
use App\Strategy\Type\RenderStartDate;
use App\Strategy\Type\RenderStartTime;

class RenderContent implements RenderContentInterface {
    const VALID_DATA_LIST = [
        RenderLearnerFirstName::USER_FIRST_NAME,
        RenderStartDate::START_DATE,
        RenderStartTime::START_TIME,
        RenderEndTime::END_TIME,
        RenderInstructorName::INSTRUCTOR_NAME,
        RenderMeetingPoint::MEETING_POINT
    ];

    const FIRST_KEY = 0;
    const SECOND_KEY = 1;

    public function messageContent(Lesson $lesson, string &$text): string {

        $message = $text;

        foreach(self::VALID_DATA_LIST as $key => $data) {
            switch($data) {
                case RenderLearnerFirstName::USER_FIRST_NAME :
                    $renderStrategy = new RenderLearnerFirstName();
                    break;
                case RenderStartDate::START_DATE :
                    $renderStrategy = new RenderStartDate();
                    break;
                case RenderStartTime::START_TIME :
                    $renderStrategy = new RenderStartTime();
                    break;
                case RenderEndTime::END_TIME :
                    $renderStrategy = new RenderEndTime();
                    break;
                case RenderInstructorName::INSTRUCTOR_NAME :
                    $renderStrategy = new RenderInstructorName();
                    break;
                case RenderMeetingPoint::MEETING_POINT :
                    $renderStrategy = new RenderMeetingPoint();
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
