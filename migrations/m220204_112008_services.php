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
        $this->execute(/* @lang MySQL */ <<<SQLCOMMAND
CREATE TABLE `services` (
  `id` int NOT NULL,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
SQLCOMMAND
        );
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
