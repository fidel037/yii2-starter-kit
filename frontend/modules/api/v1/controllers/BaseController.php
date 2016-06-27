<?php
namespace frontend\modules\api\v1\controllers;

use filsh\yii2\oauth2server\filters\auth\CompositeAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use frontend\modules\api\v1\resources\Article;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

/**
 * Class ArticleController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class BaseController extends ActiveController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator'   => [
                'class'       => CompositeAuth::className(),
                'authMethods' => [
                    ['class' => HttpBearerAuth::className()],
                    ['class' => QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
                ],
            ],
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className(),
            ],
        ]);
    }
}
