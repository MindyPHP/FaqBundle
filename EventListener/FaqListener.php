<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\EventListener;

use Mindy\Bundle\MailBundle\Helper\Mail;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FaqListener
{
    /**
     * @var Mail
     */
    protected $mail;
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    public function __construct(array $managers = [], Mail $mail, UrlGeneratorInterface $urlGenerator)
    {
        $this->managers = $managers;
        $this->mail = $mail;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param QuestionEvent $event
     */
    public function onQuestion(QuestionEvent $event)
    {
        if (empty($this->managers)) {
            return;
        }

        foreach ($this->managers as $manager) {
            $this->mail->send('Новый вопрос', $manager, 'faq/mail/question', [
                'question' => $event->getQuestion(),
            ]);
        }
    }

    /**
     * @param AnswerEvent $event
     */
    public function onAnswer(AnswerEvent $event)
    {
        $question = $event->getQuestion();
        if (empty($question->email)) {
            return;
        }

        $this->mail->send('Поступил ответ по вашему вопросу', $question->email, 'faq/mail/answer', [
            'question' => $event->getQuestion(),
        ]);
    }
}
