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
        $this->execute(/* @lang MySQL */ <<<SQLCOMMAND
CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `link` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci NOT NULL,
  `quantity` int NOT NULL,
  `service_id` int NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail',
  `created_at` int NOT NULL,
  `mode` tinyint(1) NOT NULL COMMENT '0 - Manual, 1 - Auto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;
SQLCOMMAND
        );
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
