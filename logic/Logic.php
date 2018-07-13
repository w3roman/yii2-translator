<?php

namespace w3lifer\yii2\translator\logic;

use w3lifer\phpHelper\PhpHelper;
use w3lifer\yii2\I18nJs;
use Yii;

class Logic
{
    public static function getArrayPhrases()
    {
        $phrases = [];
        $language = Yii::$app->language;
        $basePaths = I18nJs::getBasePaths();
        if ($language === Yii::$app->sourceLanguage) {
            $language = self::getSomeOtherLanguage($basePaths);
        }
        foreach ($basePaths as $basePath) {
            $pathToDir = $basePath . '/' . $language;
            if (file_exists($pathToDir)) {
                $pathsToFiles = PhpHelper::get_files_in_directory($pathToDir);
                foreach ($pathsToFiles as $pathsToFile) {
                    /** @noinspection PhpIncludeInspection */
                    $translations = require $pathsToFile;
                    if (Yii::$app->language === Yii::$app->sourceLanguage) {
                        $translations = array_keys($translations);
                    } else {
                        $translations = array_values($translations);
                    }
                    sort($translations);
                    $categoryName =
                        self::getCategoryNameFromPathToFile(
                            $basePath,
                            $pathsToFile
                        );
                    $phrases[$categoryName] = $translations;
                }
            }
        }
        return $phrases ;
    }

    private static function getSomeOtherLanguage($basePaths)
    {
        $someOtherLanguage = '';
        if (!empty($basePaths[0])) {
            $fileNames = scandir($basePaths[0]);
            $fileNames = array_diff($fileNames, ['.', '..']);
            foreach ($fileNames as $fileName) {
                $path = $basePaths[0] . '/' . $fileName;
                if (is_dir($path)) {
                    $someOtherLanguage = $fileName;
                    break;
                }
            }
        }
        return $someOtherLanguage;
    }

    private static function getCategoryNameFromPathToFile(
        $basePath,
        $pathsToFile
    ) {
        $languageAndCategoryAsString =
            str_replace($basePath . DIRECTORY_SEPARATOR, '', $pathsToFile);
        // Delete file extension (.php)
        $languageAndCategoryAsString =
            substr($languageAndCategoryAsString, 0, -4);
        $languageAndCategoryAsArray =
            explode(DIRECTORY_SEPARATOR, $languageAndCategoryAsString, 2);
        return $languageAndCategoryAsArray[1];
    }

    /**
     * @param string $email
     * @param array  $post
     * @return bool
     */
    public static function sendEmail($email, $post)
    {
        $mailer = Yii::$app->mailer;
        /** @var $message \yii\swiftmailer\Message */
        $message = $mailer->compose();
        $message->setTo($email);
        $message->setSubject(
            'New translations (' .
                'from ' . Yii::$app->language . ' ' .
                'to ' . (
                    !empty($post['destinationLanguage'])
                        ? $post['destinationLanguage']
                        : '?'
                ) .
            ')'
        );
        if (!empty($post['contactEmail'])) {
            $message->setFrom($post['contactEmail']);
        }
        $textBody = var_export($post['phrases'], true);
        if (!empty($post['contactEmail'])) {
            $textBody .= "\n\n" . 'Contact email: ' . $post['contactEmail'];
        }
        $message->setTextBody($textBody);
        return $message->send();
    }
}
