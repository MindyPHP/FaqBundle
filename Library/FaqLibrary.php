<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Library;

use Mindy\Bundle\FaqBundle\Model\Question;
use Mindy\Template\Library;

class FaqLibrary extends Library
{
    /**
     * @return array
     */
    public function getHelpers()
    {
        return [
            'get_questions' => function ($categoryId) {
                return Question::objects()->filter(['category_id' => $categoryId])->all();
            }
        ];
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return [];
    }
}
