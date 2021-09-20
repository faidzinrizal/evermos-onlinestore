<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m210918_174440_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'merchant_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'stock' => Schema::TYPE_INTEGER . ' NOT NULL',
            'ordered_stock' => Schema::TYPE_INTEGER . ' NOT NULL',
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
