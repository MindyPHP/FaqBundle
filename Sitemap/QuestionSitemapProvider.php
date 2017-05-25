<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Sitemap;

use Mindy\Bundle\FaqBundle\Model\Question;
use Mindy\Sitemap\AbstractSitemapProvider;
use Mindy\Sitemap\Entity\LocationEntity;

class QuestionSitemapProvider extends AbstractSitemapProvider
{
    /**
     * @param string $scheme
     * @param string $host
     *
     * @return \Generator
     */
    public function build($scheme, $host)
    {
        foreach (Question::objects()->asArray()->batch(100) as $chunk) {
            foreach ($chunk as $object) {
                yield (new LocationEntity())
                    ->setLastmod(new \DateTime($object['created_at']))
                    ->setLocation($this->generateLoc($scheme, $host, 'faq_question_view', [
                        'id' => $object['id'],
                    ]));
            }
        }
    }
}
