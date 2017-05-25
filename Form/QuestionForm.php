<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Form;

use Mindy\Bundle\FaqBundle\Model\Category;
use Mindy\Bundle\FaqBundle\Model\Question;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Symfony\Component\Form\AbstractType;
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
                'label' => 'Выберите направление',
                'choices' => Category::objects()->all(),
                'choice_value' => 'id',
                'choice_label' => 'name',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Ваше имя',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Ваш телефон',
                'required' => true,
                'help' => 'Номер телефона в федеральном формате: 79005551122',
                'constraints' => [
                    new Assert\NotBlank(),
                    new PhoneNumber([
                        'defaultRegion' => 'RU'
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Ваша электронная почта',
                'required' => false,
                'constraints' => [
                    new Assert\Email(),
                ],
            ])
            ->add('question', TextareaType::class, [
                'label' => 'Ваш вопрос',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
