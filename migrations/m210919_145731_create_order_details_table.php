<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_details}}`.
 */
class m210919_145731_create_order_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_details}}', [
            'id' => $this->primaryKey(),
            'order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'quantity' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_details}}');
    }
}
