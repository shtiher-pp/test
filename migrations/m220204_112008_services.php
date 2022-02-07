<?php

use yii\db\Migration;

/**
 * Class m220204_112008_services
 */
class m220204_112008_services extends Migration
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
        $this->createTable('services', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(300)->notNull(),//->append('CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci'),
        ], $tableOptions);
        //       $this->createIndex('id', 'services', 'id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220204_112008_services cannot be reverted.\n";

        return false;
    }
}
