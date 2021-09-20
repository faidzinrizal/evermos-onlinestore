<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m210919_145716_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'customer_id' => Schema::TYPE_INTEGER,
            'date' => Schema::TYPE_DATETIME,
            'status' => Schema::TYPE_TINYINT, // status will be 0 = pending, 1 = checkout, 2 = done, 3 = cancel
            'status_desc' => Schema::TYPE_STRING
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
