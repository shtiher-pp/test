<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\forms\ExportForm;
use yii\web\Controller;

class ExportController extends Controller {

    public function actionIndex()
    {
        return ExportForm::exportCsv();
    }
}