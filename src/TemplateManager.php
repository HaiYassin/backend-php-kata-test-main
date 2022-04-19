<?php
namespace App;

use App\Context\ApplicationContext;
use App\Entity\Instructor;
use App\Entity\Learner;
use App\Entity\Lesson;
use App\Entity\Template;
use App\Repository\InstructorRepository;
use App\Repository\LessonRepository;
use App\Repository\MeetingPointRepository;

class TemplateManager
{

    
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('There is no Template given.');
        }

        if (empty($data)) {
            throw new \RuntimeException('There is no Data given.');
        }

        $templateClone = clone($tpl);
        $templateClone->subject = $this->computeText($templateClone->subject, $data);
        $templateClone->content = $this->computeText($templateClone->content, $data);

        return $templateClone;
    }

    private function computeText(string $text, array $data)
    {
        if (empty($text)) {
            throw new \RuntimeException('The text given is not valid.');
        }

        if (empty($data)) {
            throw new \RuntimeException('There is no Data given.');
        }

        $lesson = (isset($data['lesson']) and $data['lesson'] instanceof Lesson) ? $data['lesson'] : null;

        if ($lesson)
        {
            $getLessonFromRepository = LessonRepository::getInstance()->getById($lesson->id);
            $meetingPointFromRepository = MeetingPointRepository::getInstance()->getById($lesson->meetingPointId);
            $instructor = InstructorRepository::getInstance()->getById($lesson->instructorId);

            if(strpos($text, '[lesson:instructor_link]') !== false){
                $text = str_replace('[instructor_link]',  'instructors/' . $instructor->id .'-'.urlencode($instructor->firstname), $text);
            }

            $containsSummaryHtml = strpos($text, '[lesson:summary_html]');
            $containsSummary     = strpos($text, '[lesson:summary]');

            if ($containsSummaryHtml !== false || $containsSummary !== false) {
                if ($containsSummaryHtml !== false) {
                    $text = str_replace(
                        '[lesson:summary_html]',
                        Lesson::renderHtml($getLessonFromRepository),
                        $text
                    );
                }
                if ($containsSummary !== false) {
                    $text = str_replace(
                        '[lesson:summary]',
                        Lesson::renderText($getLessonFromRepository),
                        $text
                    );
                }
            }

            (strpos($text, '[lesson:instructor_name]') !== false) and $text = str_replace('[lesson:instructor_name]', $instructor->firstname,$text);
        }

        if ($lesson->meetingPointId) {
            if(strpos($text, '[lesson:meeting_point]') !== false)
                $text = str_replace('[lesson:meeting_point]', $meetingPointFromRepository->name, $text);
        }

        if(strpos($text, '[lesson:start_date]') !== false)
            $text = str_replace('[lesson:start_date]', $lesson->start_time->format('d/m/Y'), $text);

        if(strpos($text, '[lesson:start_time]') !== false)
            $text = str_replace('[lesson:start_time]', $lesson->start_time->format('H:i'), $text);

        if(strpos($text, '[lesson:end_time]') !== false)
            $text = str_replace('[lesson:end_time]', $lesson->end_time->format('H:i'), $text);

        if (isset($data['instructor']) and ($data['instructor']  instanceof Instructor))
            $text = str_replace('[instructor_link]',  'instructors/' . $data['instructor']->id .'-'.urlencode($data['instructor']->firstname), $text);
        else
            $text = str_replace('[instructor_link]', '', $text);

        $learner  = (isset($data['user'])  and ($data['user']  instanceof Learner))  ? $data['user']  : ApplicationContext::getInstance()->getCurrentUser();
        if($learner) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]', ucfirst(strtolower($learner->firstname)), $text);
        }

        return $text;
    }
}
