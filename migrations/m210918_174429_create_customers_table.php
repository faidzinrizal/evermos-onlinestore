<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%customers}}`.
 */
class m210918_174429_create_customers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customers}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'address' => Schema::TYPE_TEXT . ' NOT NULL',
            'phone_number' => Schema::TYPE_STRING . ' NOT NULL'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customers}}');
    }
}
