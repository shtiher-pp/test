<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\ExportForm;
use yii\web\Controller;


class ExportController extends Controller {

    /**
     * Экспорт товаров в csv файл
     * @throws \yii\web\RangeNotSatisfiableHttpException
     */

    public function actionIndex()
    {
        $data=ExportForm::exportCsv();
        return \Yii::$app->response->sendContentAsFile($data, 'orders.csv', [
            'mimeType' => 'application/csv',
            'inline'   => false
        ]);
    }
}
