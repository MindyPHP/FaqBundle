<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\EventListener;

use Mindy\Bundle\FaqBundle\Model\Question;
use Symfony\Component\EventDispatcher\Event;

class AnswerEvent extends Event
{
    const EVENT_NAME = 'faq.question_answer';

    /**
     * @var Question
     */
    protected $question;

    /**
     * QuestionEvent constructor.
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
