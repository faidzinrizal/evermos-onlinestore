<?php

use Faker\Provider\Lorem;
use yii\db\Migration;

/**
 * Class m210920_070829_create_faker_data
 */
class m210920_070829_create_faker_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create('id_ID');

        for ($i=0; $i < 5; $i++) { 
            $this->insert('merchants', ['name' => $faker->company()]);
        }

        for ($i=0; $i < 10; $i++) { 
            $this->insert('customers', [
                'name' => $faker->name(),
                'address' => $faker->address(),
                'phone_number' => $faker->phoneNumber()
            ]);
        }

        for ($i=0; $i < 50; $i++) { 
            $this->insert('products', [
                'merchant_id' => rand(1, 5),
                'name' => 'product-' . $i,
                'description' => $faker->words(5, true),
                'price' => 5000,
                'stock' => rand (0, 100),
                'ordered_stock' => 0
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('merchants');
        $this->truncateTable('customers');
        $this->truncateTable('products');
        echo "truncated";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210920_070829_create_faker_data cannot be reverted.\n";

        return false;
    }
    */
}
