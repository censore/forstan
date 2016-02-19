<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\HttpException;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    private $packages = [
        'machour/yii2-notifications',
        'machour/yii2-swagger-api',
        'machour/yii2-swagger-ui',
        'machour/yii2-google-apiclient',
        'machour/yii2-sparkline',
    ];

    public function actionYii()
    {
        $packages = [];
        foreach ($this->packages as $name) {
            $packages[] = new Package(['package' => $name]);
        }
        return $this->render('yii2', [
            'packages' => $packages,
        ]);
    }

    public function actionYiiPackage($vendor, $repository, $page = null)
    {
        $package = $this->getPackage($vendor, $repository);
        if ($page === null) {
            $contents = $package->getReadme();
        } else {
            if (!preg_match('!^[A-Za-z]+\.md$!', $page)) {
                 throw new HttpException(400, 'Wrong page');
            }
            $contents = $package->getPage($page);
        }
        return $this->render('yii2-package', [
            'package' => $package,
            'contents' => $contents,
        ]);
    }

    private function getPackage($vendor, $repository) {
        $package = $vendor . '/' . $repository;
        if (!in_array($package, $this->packages)) {
            throw new HttpException(404, "Package not found");
        }
        return new Package(['package' => $package]);
    }

}
