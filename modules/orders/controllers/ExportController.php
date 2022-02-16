<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\forms\ExportForm;
use yii\web\Controller;
use yii\web\RangeNotSatisfiableHttpException;
use yii\web\Response;

class ExportController extends Controller {

    public function actionIndex()
    {
        return ExportForm::exportCsv();
    }
}