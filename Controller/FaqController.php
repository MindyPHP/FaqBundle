<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Controller;

use Mindy\Bundle\CommentBundle\Form\CommentForm;
use Mindy\Bundle\CommentBundle\Model\Comment;
use Mindy\Bundle\FaqBundle\EventListener\QuestionEvent;
use Mindy\Bundle\FaqBundle\Form\QuestionForm;
use Mindy\Bundle\FaqBundle\Model\Category;
use Mindy\Bundle\FaqBundle\Model\Question;
use Mindy\Bundle\MindyBundle\Controller\Controller;
use Mindy\Orm\ModelInterface;
use Mindy\Orm\QuerySet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FaqController extends Controller
{
    public function listAction(Request $request, $category_id = null)
    {
        $category = null;
        /** @var QuerySet $qs */
        $qs = Question::objects()->published()->order(['-id']);
        if (empty($category_id) === false) {
            $category = Category::objects()->get(['id' => $category_id]);
            if (null === $category) {
                throw new NotFoundHttpException();
            }
            $qs->filter(['category' => $category]);
        }
        $pager = $this->createPagination($qs);

        $question = new Question([
            'category' => $category,
        ]);
        if (empty($category_id)) {
            $action = $this->generateUrl('faq_question_list');
        } else {
            $action = $this->generateUrl('faq_question_list', [
                'category_id' => $category_id,
            ]);
        }

        $form = $this->createForm(QuestionForm::class, $question, [
            'method' => 'POST',
            'action' => $action,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $question = $form->getData();
                if (false === $question->save()) {
                    throw new \RuntimeException('Fail to save question');
                }

                $this->get('event_dispatcher')->dispatch(
                    QuestionEvent::EVENT_NAME,
                    new QuestionEvent($question)
                );

                $this->addFlash('success', 'Ваш вопрос успешно отправлен. В ближайшее время мы ознакомимся и направим вам ответ.');

                return $this->redirect($request->getRequestUri());
            }
            $this->addFlash('error', 'Пожалуйста исправьте ошибки формы.');
        }

        return $this->render('faq/question/list.html', [
            'questions' => $pager->paginate(),
            'pager' => $pager->createView(),
            'form' => $form->createView(),
        ]);
    }

    public function viewAction(Request $request, $id)
    {
        $question = Question::objects()->published()->get([
            'id' => $id,
        ]);
        if (null === $question) {
            throw new NotFoundHttpException();
        }

        $user = $this->getUser();
        if (false === ($user instanceof ModelInterface)) {
            $user = null;
        }

        $comment = new Comment([
            'object_type' => 'faq_question',
            'object_id' => $id,
            'user' => $user,
        ]);
        $commentForm = $this->createForm(CommentForm::class, $comment, [
            'method' => 'POST',
            'action' => $this->generateUrl('faq_question_view', ['id' => $id])
        ]);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted()) {
            if ($commentForm->isValid()) {
                $comment = $commentForm->getData();
                if (false === $comment->save()) {
                    throw new \RuntimeException('Fail to save comment');
                }

                $this->addFlash('success', 'Комментарий добавлен и будет опубликован после проверки модератором.');

                return $this->redirect($request->getRequestUri());
            } else {
                $this->addFlash('error', 'Пожалуйста исправьте ошибки в форме.');
            }
        }

        return $this->render('faq/question/view.html', [
            'question' => $question,
            'commentForm' => $commentForm->createView()
        ]);
    }
}
