<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_images}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%products}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m220225_152202_create_product_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_images}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->string(16)->notNull(),
            'img_url' => $this->string(255),
            'rank' => $this->integer(11),
            'isActive' => $this->integer(2)->notNull(),
            'isCover' => $this->integer(2)->notNull(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-product_images-product_id}}',
            '{{%product_images}}',
            'product_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-product_images-product_id}}',
            '{{%product_images}}',
            'product_id',
            '{{%products}}',
            'product_id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-product_images-created_by}}',
            '{{%product_images}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product_images-created_by}}',
            '{{%product_images}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-product_images-updated_by}}',
            '{{%product_images}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product_images-updated_by}}',
            '{{%product_images}}',
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
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-product_images-product_id}}',
            '{{%product_images}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-product_images-product_id}}',
            '{{%product_images}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product_images-created_by}}',
            '{{%product_images}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-product_images-created_by}}',
            '{{%product_images}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product_images-updated_by}}',
            '{{%product_images}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-product_images-updated_by}}',
            '{{%product_images}}'
        );

        $this->dropTable('{{%product_images}}');
    }
}
