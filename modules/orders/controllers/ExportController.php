<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\forms\ExportForm;
use yii\web\Controller;
use yii\web\RangeNotSatisfiableHttpException;
use yii\web\Response;

class ExportController extends Controller {

    /**
     * Экспорт товаров в csv файл
     * @throws RangeNotSatisfiableHttpException
     */
    public function actionIndex(): Response
    {
        $data = ExportForm::exportCsv();
        return \Yii::$app->response->sendContentAsFile($data, 'orders.csv', [
            'mimeType' => 'application/csv',
            'inline'   => false
        ]);
    }
}