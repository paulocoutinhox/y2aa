<?php

namespace common\helpers;

use Yii;
use yii\web\Cookie;

class LanguageHelper
{

    public static function setLanguageCookie($language)
    {
        $cookie = new Cookie();
        $cookie->name = 'customer-language';
        $cookie->value = $language;

        Yii::$app->response->getCookies()->add($cookie);
    }

    public static function getPreferredLanguage($supportedLanguages)
    {
        // get preferred language from cookie
        $preferredLanguage = isset(Yii::$app->request->cookies['customer-language']) ? (string)Yii::$app->request->cookies['customer-language']->value : null;

        // check for language existence
        $found = self::hasSupportedLanguage($supportedLanguages, $preferredLanguage);

        if (!$found) {
            $preferredLanguage = null;
        }

        // get preferred language from browser
        if (empty($preferredLanguage)) {
            $preferredLanguage = Yii::$app->request->getPreferredLanguage($supportedLanguages);

            // check for language existence
            $found = self::hasSupportedLanguage($supportedLanguages, $preferredLanguage);

            if (!$found) {
                $preferredLanguage = null;
            }
        }

        // get preferred language from profile
        if (empty($preferredLanguage)) {
            if (!Yii::$app->user->isGuest) {
                $language = Yii::$app->user->language;

                if ($language) {
                    // try with code iso language
                    $preferredLanguage = $language->code_iso_language;

                    // check for language existence
                    $found = self::hasSupportedLanguage($supportedLanguages, $preferredLanguage);

                    if (!$found) {
                        $preferredLanguage = null;
                    }

                    // try with code iso 639 1
                    $preferredLanguage = $language->code_iso_639_1;

                    // check for language existence
                    $found = self::hasSupportedLanguage($supportedLanguages, $preferredLanguage);

                    if (!$found) {
                        $preferredLanguage = null;
                    }
                }
            }
        }

        if (empty($preferredLanguage)) {
            if (count($supportedLanguages) > 0) {
                $preferredLanguage = $supportedLanguages[0];
            }
        }

        return $preferredLanguage;
    }

    private static function hasSupportedLanguage($supportedLanguages, $language)
    {
        $found = false;

        foreach ($supportedLanguages as $supportedLanguage) {
            if ($supportedLanguage == $language) {
                $found = true;
                break;
            }
        }

        return $found;
    }

}