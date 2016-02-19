<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\Transactions;
use app\models\Balances;
use yii\helpers\Json;
use yii\web\Request;

class ApiController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        $params  = $_REQUEST;

        if( (strtolower($params['format']) !== 'json')) die('No allow method');

        $auth = Users::findOne([
            'password'=>md5($params['password']),
            'login'=>$params['login']
        ]);

        $return = [];

        if($auth['id']>0 ){

            $auth->hash = md5(time() . sha1(time()));
            $auth->id = $auth['id'];
            $auth->save();


            $return['user'] = $auth;


            $transactions = new Transactions();
            $toMeTransactions = $transactions->find([
                'to_account_id'=>$auth['id'],
            ])
                ->joinWith(['operation'])
                ->joinWith('currency')
                ->joinWith('operation.subcategory')
                ->all();

            $return['transactions']['to_me'] = $this->getTransactionRelatives($toMeTransactions);

            $fromMeTransaction = $transactions->find([
                'from_account_id'=>$auth['id'],
            ])->all();

            $return['transactions']['from_me'] = $this->getTransactionRelatives($fromMeTransaction);

            $balances = new Balances();

            $myBalance = $balances->find([
                'account_id'=>$auth['id']
            ]);
            $return['balances'] = $myBalance->all();
        }else{
            die(Json::encode(['error'=>'User not found', $params, $_POST]));
        }

        echo Json::encode($return);
    }
    public function getTransactionRelatives(array $transactions){
        $array = [];

        foreach($transactions as $transaction){
            //print_r($transaction);
            $array[$transaction->id] = [
                'id'=>$transaction->id,
                'from_account'=>$transaction->from_account_id,
                'to_account'=>$transaction->to_account_id,
                'amount'=>$transaction->amount,
                'date'=>$transaction->date,
            ];
        }
    }
}
