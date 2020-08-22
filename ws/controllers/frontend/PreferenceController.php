<?php

namespace ws\controllers\frontend;

use common\models\domain\Preference;
use common\models\web\Response;
use Yii;

/**
 * Preference controller
 */
class PreferenceController extends BaseController
{

    protected $accessControlExceptActions = [
        'index'
    ];

    public function actionIndex()
    {
        $preferenceKey = Yii::$app->request->get('key');
        $canSearch = false;

        $query = Preference::find();

        if (!empty($preferenceKey)) {
            $query->andWhere(['key' => $preferenceKey]);
            $canSearch = true;
        }

        if (!$canSearch) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        $preference = $query->one();

        if ($preference == null) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setMessage('found');
        $response->addData('preference', $preference);

        return $response;
    }

}
