<?php

namespace console\controllers;

use common\models\domain\Content;
use common\models\domain\Customer;
use common\models\domain\Group;
use common\models\domain\Language;
use common\models\domain\User;
use Yii;
use yii\base\Exception;
use yii\console\Controller;

class DataController extends Controller
{

    public function actionUsers()
    {
        $user = User::find()->email('paulo@prsolucoes.com')->one();

        if (!$user) {
            $user = new User();
            $user->name = 'Paulo Coutinho';
            $user->email = 'paulo@prsolucoes.com';
            $user->language_id = 1;
            $user->status = User::STATUS_ACTIVE;
            $user->root = User::ROOT_YES;
            $user->gender = User::GENDER_MALE;
            $user->timezone = 'America/Sao_Paulo';
            $user->logged_at = time();
            $user->created_at = time();

            try {
                $user->setPassword('user@password');
            } catch (Exception $e) {
                // ignore
            }

            $user->save();
        }
    }

    public function actionGroups()
    {
        $group = Group::find()->name('Group.Name.BasicAccess')->one();

        if (!$group) {
            $group = new Group();
            $group->name = 'Group.Name.BasicAccess';
            $group->permissions = [];
            $group->status = Group::STATUS_ACTIVE;
            $group->created_at = time();
            $group->save();
        }
    }

    public function actionCustomers()
    {
        $customer = Customer::find()->email('paulo@prsolucoes.com')->one();

        if (!$customer) {
            $customer = new Customer();
            $customer->name = 'Paulo Coutinho';
            $customer->password = 'customer@password';
            $customer->email = 'paulo@prsolucoes.com';
            $customer->cpf = '98263967538'; // random with cpf generator
            $customer->language_id = 1;
            $customer->status = Customer::STATUS_ACTIVE;
            $customer->mobile_phone = '21999887766';
            $customer->gender = Customer::GENDER_MALE;
            $customer->timezone = 'America/Sao_Paulo';
            $customer->created_at = time();

            try {
                $customer->setPassword('customer@password');
            } catch (Exception $e) {
                // ignore
            }

            $customer->save();
        }
    }

    public function actionLanguages()
    {
        {
            // english
            $language = Language::find()->codeISO('en-US')->one();

            if (!$language) {
                $language = new Language();
                $language->name = 'English';
                $language->native_name = 'English';
                $language->code_iso_639_1 = 'en';
                $language->code_iso_language = 'en-US';
                $language->created_at = time();
                $language->save();
            }
        }

        {
            // portuguese
            $language = Language::find()->codeISO('pt-BR')->one();

            if (!$language) {
                $language = new Language();
                $language->name = 'Portuguese';
                $language->native_name = 'Português';
                $language->code_iso_639_1 = 'pt';
                $language->code_iso_language = 'pt-BR';
                $language->created_at = time();
                $language->save();
            }
        }
    }

    public function actionContents()
    {
        {
            // about content
            $content = Content::find()->tag(Content::TAG_ABOUT_US)->languageId(0)->one();

            if (!$content) {
                $content = new Content();
                $content->tag = Content::TAG_ABOUT_US;
                $content->title = 'About us';
                $content->content = 'Insert content <a href="/admin/content">here</a>.';
                $content->language_id = 0;
                $content->status = Content::STATUS_ACTIVE;
                $content->created_at = time();
                $content->save();
            }
        }

        {
            // privacy content
            $content = Content::find()->tag(Content::TAG_PRIVACY_POLICY)->languageId(0)->one();

            if (!$content) {
                $content = new Content();
                $content->tag = Content::TAG_PRIVACY_POLICY;
                $content->title = 'Privacy policy';
                $content->content = 'Insert content <a href="/admin/content">here</a>.';
                $content->language_id = 0;
                $content->status = Content::STATUS_ACTIVE;
                $content->created_at = time();
                $content->save();
            }
        }

        {
            // terms content
            $content = Content::find()->tag(Content::TAG_TERMS_OF_USE)->languageId(0)->one();

            if (!$content) {
                $content = new Content();
                $content->tag = Content::TAG_TERMS_OF_USE;
                $content->title = 'Terms of use';
                $content->content = 'Insert content <a href="/admin/content">here</a>.';
                $content->language_id = 0;
                $content->status = Content::STATUS_ACTIVE;
                $content->created_at = time();
                $content->save();
            }
        }
    }

    public function actionCacheTable()
    {
        $query = '
        CREATE TABLE IF NOT EXISTS cache (
            id char(128) NOT NULL PRIMARY KEY,
            expire int(11),
            data BLOB
        );';

        $command = Yii::$app->db->createCommand($query);
        $command->execute();
    }

}