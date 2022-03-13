<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_categories}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m220309_105527_create_product_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_categories}}', [
            'category_id' => $this->primaryKey(),
            'title' => $this->string(128)->notNull(),
            'isActive' => $this->integer(2)->notNull(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-product_categories-created_by}}',
            '{{%product_categories}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product_categories-created_by}}',
            '{{%product_categories}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-product_categories-updated_by}}',
            '{{%product_categories}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product_categories-updated_by}}',
            '{{%product_categories}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product_categories-created_by}}',
            '{{%product_categories}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-product_categories-created_by}}',
            '{{%product_categories}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product_categories-updated_by}}',
            '{{%product_categories}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-product_categories-updated_by}}',
            '{{%product_categories}}'
        );

        $this->dropTable('{{%product_categories}}');
    }
}
