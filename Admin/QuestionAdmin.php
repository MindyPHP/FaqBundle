<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Admin;

use Mindy\Bundle\AdminBundle\Admin\AbstractModelAdmin;
use Mindy\Bundle\AdminBundle\Admin\Event\AdminEvent;
use Mindy\Bundle\FaqBundle\EventListener\AnswerEvent;
use Mindy\Bundle\FaqBundle\Form\Admin\QuestionForm;
use Mindy\Bundle\FaqBundle\Model\Question;

/**
 * Class QuestionAdmin
 */
class QuestionAdmin extends AbstractModelAdmin
{
    public $defaultOrder = ['-id'];

    public $columns = ['question', 'name', 'phone', 'email', 'is_published', 'created_at'];

    public function __construct()
    {
        parent::__construct();

//        $event = function (AdminEvent $event) {
//            /** @var Question $instance */
//            $instance = $event->getInstance();
//            if (false === empty($instance->answer) && false === empty($instance->email)) {
//                $this->get('event_dispatcher')->dispatch(
//                    AnswerEvent::EVENT_NAME,
//                    new AnswerEvent($instance)
//                );
//            }
//        };
//        $this->getEventDispatcher()->addListener(self::EVENT_AFTER_CREATE, $event);
//        $this->getEventDispatcher()->addListener(self::EVENT_AFTER_UPDATE, $event);
    }

    public function getFormType()
    {
        return QuestionForm::class;
    }

    public function getModelClass()
    {
        return Question::class;
    }
}
