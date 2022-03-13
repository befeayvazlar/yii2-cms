<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m220309_225337_add_category_id_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'category_id', $this->integer(11)->null()->after('description'));

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-products-category_id}}',
            '{{%products}}',
            'category_id'
        );

        // add foreign key for table `{{%product_categories}}`
        $this->addForeignKey(
            '{{%fk-products-category_id}}',
            '{{%products}}',
            'category_id',
            '{{%product_categories}}',
            'category_id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%product_categories}}`
        $this->dropForeignKey(
            '{{%fk-products-category_id}}',
            '{{%products}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-products-category_id}}',
            '{{%products}}'
        );

        $this->dropColumn('{{%products}}', 'category_id');
    }
}
