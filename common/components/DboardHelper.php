<?php
namespace common\components;

use Yii;
use frontend\models\Etrans;
use frontend\models\Ewallet;
use frontend\models\Profile;
use frontend\models\UserPackage;
use frontend\models\Messages;
use frontend\models\Package;
use frontend\models\Activity;

/**
* DboardHelper for dashboard data
*/
class DboardHelper {
    
    public static function earningsData() {
        $earningsData=UserPackage::find()
            ->select('YEAR(FROM_UNIXTIME(purchased_at)) AS year, DATE(FROM_UNIXTIME(purchased_at)) AS date, SUM(amount) AS earned_amount')
            ->joinWith('pack')
            ->where(['payment_status' => 'Paid'])
            ->groupBy('year, date')->createCommand()->queryAll();
        
        $response[]=['Date', 'Earnings'];
        if(empty($earningsData)) {
            return;
        }
        foreach($earningsData as $k => $data) {
            $date=date('d M, Y', strtotime($data['date']));
            $earned_amount=(int)$data['earned_amount'];
            $response[]=[$date, $earned_amount];
        }
        return $response;
    }
    
    public static function userEarnings() {
        $earningsData=Etrans::find()
            ->select('YEAR(FROM_UNIXTIME(date)) AS year, DATE(FROM_UNIXTIME(date)) AS dt, SUM(amount) AS earned_amount')
            ->where(['trans_to' => Yii::$app->user->identity->id, 'type' => 'credit', 'status' => 'Approved'])
            ->groupBy('year, dt')->createCommand()->queryAll();
        
        $response[]=['Date', 'Earnings'];
        if(empty($earningsData)) {
            return;
        }
        foreach($earningsData as $data) {
            $date=date('d M, Y', strtotime($data['dt']));
            $earned_amount=(int)$data['earned_amount'];
            $response[]=[$date, $earned_amount];
        }
        return $response;
    }
    
    public static function piechartData() {
        $packages=Package::findAll(['status' => 'Active']);
        $response[]=['Package', 'Users'];
        $counter=0;
        foreach($packages as $pack) {
            $where=(Yii::$app->user->identity->user_role===2) ? ['pack_id' => $pack->id] : ['referrer' => Yii::$app->user->identity->id, 'pack_id' => $pack->id] ;
            $usersCount=Profile::find()->where($where)->count();
            if($usersCount>0) {
                $counter++;
                $response[]=[$pack->name, (int)$usersCount];
            }
        }
        if($counter===0) {
            return;
        }
        return $response;
    }
    
    public static function userschartData() {
        $packages=Package::findAll(['status' => 'Active']);
        $response[]=['Package', 'Users'];
        $counter=0;
        foreach($packages as $pack) {
            $where=(Yii::$app->user->identity->user_role===2) ? ['pack_id' => $pack->id, 'MONTH(FROM_UNIXTIME(created_at))' => date('m')] : ['referrer' => Yii::$app->user->identity->id, 'pack_id' => $pack->id, 'MONTH(FROM_UNIXTIME(created_at))' => date('m')] ;
            $usersCount=Profile::find()->where($where)->count();
            if($usersCount>0) {
                $counter++;
                $response[]=[$pack->name, (int)$usersCount];
            }
        }
        if($counter===0) {
            return;
        }
        return $response;
    }

    public static function ewallet() {
        $que=Ewallet::find();
        if(Yii::$app->user->identity->user_role===1) {
            $que->where(['user_id' => Yii::$app->user->identity->id]);
        }
        $tot_bal=(float)$que->sum('current_balance');
        return Yii::$app->formatter->format($tot_bal, 'currency');
    }
    
    public static function sales() {
        $que=UserPackage::find()->joinWith('pack')->where(['payment_status' => 'Paid']);
        if(Yii::$app->user->identity->user_role===1) {
            $que->andWhere(['user_id' => Yii::$app->user->identity->id]);
              $sales=(float)$que->sum('amount');
        }
        
      
        
        if(Yii::$app->user->identity->user_role===2){
        	$pac=Package::findOne(['id' => 1]);
        	$quec=UserPackage::findAll(['payment_status' => 'Paid']);
        	$sales = (float)count($quec) *$pac->amount;
        	//die;
        }
         
        return Yii::$app->formatter->format($sales, 'currency');
    }
    
    public static function payout() {
        $que=Etrans::find()->where(['reason' => 'Payout Release', 'status' => 'Approved']);
        if(Yii::$app->user->identity->user_role===1) {
            $que->andWhere(['trans_to' => Yii::$app->user->identity->id]);
        }
        $payout=(float)$que->sum('amount');
        return Yii::$app->formatter->format($payout, 'currency');
    }
    
        public static function levelget() {
            $level =  Profile::findOne([user_id=>Yii::$app->user->identity->id]);
            
            $levelname = 'NON';
            if($level->pack_id > 0){
                $levelname = Package::findOne($level->pack_id);
                ;
                return $levelname->name;
            }
            
           return  $levelname;
          
             
        
    }
    public static function levelgetid() {
            $level =  Profile::findOne([user_id=>Yii::$app->user->identity->id]);
            
           
            
           return  $level->pack_id;
          
             
        
    }
    

    public static function messages() {
        $que=Messages::find();
        if(Yii::$app->user->identity->user_role===1) {
            $que->where(['msg_from' => Yii::$app->user->identity->id]);
            $que->orWhere(['msg_to' => Yii::$app->user->identity->id]);
        }
        $messageCount=$que->count();
        return $messageCount;
    }
    
    public static function latestActivities() {
        $user_id=(Yii::$app->user->identity->user_role===1) ? Yii::$app->user->identity->id : '';
        $que=Activity::find();
        $que->filterWhere(['user_id' => $user_id])->limit(3);
        $response=$que->all();
        return $response;
    }
    
    public static function displayName() {
        $user_id=Yii::$app->user->identity->id;
        if($user_id) {
            $pInfo=Profile::findOne(['user_id' => $user_id]);
            $dName=($pInfo) ? ucwords($pInfo->first_name.' '.$pInfo->last_name) : Yii::$app->user->identity->username;
            return $dName;
        }
    }
    
}