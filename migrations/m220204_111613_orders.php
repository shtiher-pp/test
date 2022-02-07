<?php

use yii\db\Migration;

/**
 * Class m220204_111613_orders
 */
class m220204_111613_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci ENGINE=InnoDB ROW_FORMAT=COMPACT';
        }
        $this->createTable('orders', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'link' => $this->string(300)->notNull(),//->append('CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci'),
            'quantity' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->notNull() . ' COMMENT "0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail"',
            'created_at' => $this->integer()->notNull(),
            'mode' => $this->tinyInteger(1)->notNull() . ' COMMENT "0 - Manual, 1 - Auto"',
        ], $tableOptions);
 //       $this->createIndex('id', 'orders', 'id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220204_111613_orders cannot be reverted.\n";

        return false;
    }
}
