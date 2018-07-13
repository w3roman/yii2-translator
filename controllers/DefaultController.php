<?php

namespace w3lifer\yii2\translator\controllers;

use w3lifer\responseInterface\ResponseInterface;
use w3lifer\yii2\translator\logic\Logic;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!empty($post['phrases'])) {
                /** @var $module \app\modules\translator\Module */
                $module = $this->module;
                Yii::$app->response->format = Response::FORMAT_JSON;
                return
                    Logic::sendEmail($module->email, $post)
                        ? ResponseInterface::getTrueResponse()
                        : ResponseInterface::getFalseResponse();
            }
        }
        $arrayOfPhrases = Logic::getArrayPhrases();
        $this->view->registerAssetBundle(
            'w3lifer\yii2\translator\assets\MainAsset'
        );
        return $this->render('index', compact('arrayOfPhrases'));
    }
}
