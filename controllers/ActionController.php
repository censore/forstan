<?php

namespace app\controllers;

use app\models\Accounts;
use app\models\Transactions;
use app\models\User;
use app\models\Users;
use yii\helpers\Json;

class ActionController extends \yii\web\Controller
{
    public $params;
    public $activeId;
    public $enableCsrfValidation = false;

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        $this->params  = $_REQUEST;
        if( (strtolower($this->params['format']) !== 'json')) die('No allow method');
        if(isset($this->params['hash'])){
            $user = new Users();
            $auth = $user->find([
                'hash'=>$this->params['hash']
            ])->one();

            if($auth['id']==0 || empty($auth['id']) || !isset($auth['id'])){
                $this->noAuth();
            }
        }else{
            $this->noAuth();
        }
        $this->activeId = $auth['id'];
        return parent::beforeAction($action);
    }
    public function noAuth(){
        die(Json::encode(['error'=>'no authorize to do this action']));
    }
    public function actionIndex()
    {
        die(Json::encode(['error'=>'Maybe you lost some action?']));
    }
    public function actionSendto(){

        $transaction = new Transactions();

        $transaction->operation_id=3;
        $transaction->from_account_id=$this->params['from'];
        $transaction->to_account_id=$this->params['touser'];
        $transaction->currency_id=$this->params['currency'];
        $transaction->amount=$this->params['amount'];
        $transaction->date=date('Y-m-d H:i:s');
        $transaction->save();

        echo Json::encode(['info'=>'work', 'id'=>$this->activeId]);
    }
    public function actionGetusers(){

        $user = Users::find();
        $u = $user->leftJoin(Accounts::tableName(),  Accounts::tableName(). '.user_id = ' . Users::tableName().'.id')->all();

        die(Json::encode($u));

    }
    public function actionAccept(){
        $trans = Transactions::find([
            'id'=>$this->params['id']
        ])->one();

    }

}
