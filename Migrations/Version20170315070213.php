<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\FaqBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Mindy\Bundle\FaqBundle\Model\Category;
use Mindy\Bundle\FaqBundle\Model\Question;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170315070213 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $questionTable = $schema->createTable(Question::tableName());
        $questionTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $questionTable->addColumn('question', 'text');
        $questionTable->addColumn('answer', 'text', ['notnull' => false]);
        $questionTable->addColumn('name', 'string', ['length' => 255, 'notnull' => false]);
        $questionTable->addColumn('phone', 'string', ['length' => 255, 'notnull' => false]);
        $questionTable->addColumn('email', 'string', ['length' => 255, 'notnull' => false]);
        $questionTable->addColumn('category_id', 'integer', ['length' => 11]);
        $questionTable->addColumn('is_published', 'smallint', ['length' => 1, 'default' => 0]);
        $questionTable->addColumn('created_at', 'datetime');
        $questionTable->setPrimaryKey(['id']);

        $categoryTable = $schema->createTable(Category::tableName());
        $categoryTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $categoryTable->addColumn('name', 'string', ['length' => 255]);
        $categoryTable->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable(Question::tableName());
        $schema->dropTable(Category::tableName());
    }
}
