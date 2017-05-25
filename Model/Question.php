<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Model;

use Mindy\Bundle\CommentBundle\Comment\CommentOwnerInterface;
use Mindy\Bundle\CommentBundle\Comment\CommentOwnerTrait;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

/**
 * Class Question
 *
 * @property string $name
 *
 * @method static \Mindy\Bundle\FaqBundle\Model\QuestionManager objects($instance = null)
 */
class Question extends Model implements CommentOwnerInterface
{
    use CommentOwnerTrait;

    public static function getFields()
    {
        return [
            'category' => [
                'class' => ForeignField::class,
                'modelClass' => Category::class,
            ],
            'name' => [
                'class' => CharField::class,
                'null' => true,
            ],
            'email' => [
                'class' => CharField::class,
                'null' => true,
            ],
            'phone' => [
                'class' => CharField::class,
                'null' => true,
            ],
            'question' => [
                'class' => TextField::class,
            ],
            'answer' => [
                'class' => TextField::class,
                'null' => true,
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'default' => false,
            ],
        ];
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return 'faq_question';
    }

    /**
     * @return int|string
     */
    public function getObjectId()
    {
        return $this->id;
    }
}
