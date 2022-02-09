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
        $this->execute(/* @lang MySQL */ <<<SQLCOMMAND
CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
SQLCOMMAND
        );
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
