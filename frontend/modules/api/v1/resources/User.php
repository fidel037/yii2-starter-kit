<?php

namespace frontend\modules\api\v1\resources;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class User extends \common\models\User implements \OAuth2\Storage\UserCredentialsInterface
{
    public function fields()
    {
        return ['id', 'username', 'created_at'];
    }

    public function extraFields()
    {
        return ['userProfile'];
    }
    /**
     * Implemented for Oauth2 Interface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $token  = $module->getServer()->getResourceController()->getToken();
        return !empty($token['user_id'])
        ? static::findIdentity($token['user_id'])
        : null;
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsername($username);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function getUserDetails($username)
    {
        $user = static::findByUsername($username);
        return ['user_id' => $user->getId()];
    }
}
