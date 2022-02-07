<?php

use yii\db\Migration;

/**
 * Class m220204_111801_users
 */
class m220204_111801_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ENGINE=InnoDB ROW_FORMAT=COMPACT';
        }
        $this->createTable('users', [
            'id' => $this->primaryKey()->notNull(),
            'first_name' => $this->string(300)->notNull(),//->append('CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci'),
            'last_name' => $this->string(300)->notNull(),//->append('CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci'),
        ], $tableOptions);
        //       $this->createIndex('id', 'users', 'id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220204_111801_users cannot be reverted.\n";

        return false;
    }
}
