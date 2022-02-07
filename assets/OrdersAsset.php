<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>a
 * @since 2.0
 */
class OrdersAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/test/views/default';
 //   public $cssOptions = ['condition' => 'lte IE9'];
    public $css = [
        'css/bootstrap.custom.css',
        'css/bootstrap.min.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
