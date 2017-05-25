<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Form\Admin;

use Mindy\Bundle\AdminBundle\Form\Type\ButtonsType;
use Mindy\Bundle\FaqBundle\Model\Category;
use Mindy\Bundle\FaqBundle\Model\Question;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class QuestionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', ChoiceType::class, [
                'label' => 'Направление',
                'choices' => Category::objects()->all(),
                'choice_value' => 'id',
                'choice_label' => 'name',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
                'constraints' => [
                    new PhoneNumber(),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Электронная почта',
                'constraints' => [
                    new Assert\Email(),
                ],
            ])
            ->add('question', TextareaType::class, [
                'label' => 'Вопрос',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('answer', TextareaType::class, [
                'label' => 'Ответ',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('is_published', CheckboxType::class, [
                'label' => 'Опубликовано',
                'required' => false,
            ])
            ->add('buttons', ButtonsType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
