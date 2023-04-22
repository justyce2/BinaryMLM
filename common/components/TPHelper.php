<?php

namespace common\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Activity;
use frontend\models\Options;
use frontend\models\Etrans;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\Package;
use frontend\models\UserPackage;
use frontend\models\Ewallet;
use frontend\models\Messages;
use frontend\models\State;
/**
 * TPHelper for main and reusable functions
 */
class TPHelper {

    public static $uplineUsers = [];
    
    public static function getOption($optionName) {
        $option = Options::findOne(['option_name' => $optionName]);
        if ($option) {
            return $option->option_value;
        } else {
            return false;
        }
    }
    
    public static function saveOption($optionName, $optionValue) {
        $option = Options::findOne(['option_name' => $optionName]);
        if ($option) {
            $option->option_value = $optionValue;
            if ($option->save()) {
                return true;
            }
            return false;
        } else {
            $newOption = new Options();
            $newOption->option_name = $optionName;
            $newOption->option_value = $optionValue;
            if ($newOption->save()) {
                return true;
            }
            return false;
        }
    }
    
    public static function newActivity($activity, $user_id = null) {
        $act = new Activity();
        $act->user_id = !empty($user_id) ? $user_id : Yii::$app->user->identity->id;
        $act->text = $activity;
        if ($act->save(false)) {
            return true;
        } else {
            return false;
        }
    }

    public static function updateUserWallet($user_id, $amount, $type = 'credit') {
        $eWal = Ewallet::findOne(['user_id' => $user_id]);
        if ($eWal) {
            $curBal = $eWal->current_balance;
            if ($type === 'credit') {
                $curBal = bcadd($curBal, $amount, 2);
            } else {
                $curBal = bcsub($curBal, $amount, 2);
            }
            $eWal->current_balance = $curBal;
            return $eWal->save(false);
        } else {
            $nWal = new Ewallet();
            $nWal->user_id = $user_id;
            if ($nWal->save(false)) {
                self::updateUserWallet($user_id, $amount, $type);
            }
        }
        return false;
    }

    public static function curBalance($user_id) {
        $ewallet = Ewallet::findOne(['user_id' => $user_id]);
        return ($ewallet) ? $ewallet->current_balance : '0.00';
    }

    public static function waitingtoDeduct($user_id) {
        $etrans = Etrans::find()->where(['trans_to' => $user_id, 'reason' => 'Payout Release', 'status' => 'Pending', 'type' => 'debit'])->sum('amount');
        return ($etrans) ? $etrans : '0.00';
    }

    /**
     * Returns first user of the website
     */
    public static function firstUser() {
        $tpUsr = Profile::find()->one();
        if ($tpUsr) {
           return $tpUsr->referrer;
          //  return $tpUsr->placement;
        } else {
            $usr = User::find()->one();
            return $usr->id;
        }
    }

    /**
     * Returns Tooltip of the user
     */
    public static function tooltip($userId) {
        $userInfo = Profile::findOne(['user_id' => $userId]);
        if ($userInfo) {
            $joined_at = Yii::$app->formatter->asDate($userInfo->created_at);
            $disp = '<span><div class="flyout">';
            $disp .= '<table width="100%" border="0" cellspacing="1" cellpadding="1"><tbody>';
            $disp .= "<tr><td align='left'>Fullname :</td><td align='left'>" . ucwords($userInfo->first_name . ' ' . $userInfo->last_name) . "</td></tr>";
            $disp .= "<tr><td align='left'>Point Volume :</td><td align='left'>$userInfo->cur_pv PV</td></tr>";
            $disp .= "<tr><td align='left'>Carry Left :</td><td align='left'>$userInfo->cf_left PV</td></tr>";
            $disp .= "<tr><td align='left'>Carry Right :</td><td align='left'>$userInfo->cf_right PV</td></tr>";
            $disp .= "<tr><td align='left'>Joined at :</td><td align='left'>$joined_at</td></tr>";
            $disp .= "</tbody></table></div></span>";
            echo $disp;
        }
    }

    /**
     * Returns Downline Users of a Specified User
     */
    public static function downlineUsers($userId) {
        $resp = [];
        $dnLns = Profile::find()->select('user_id')->where(['placement' => $userId])->orderBy(['place_position' => SORT_ASC])->all();
        foreach ($dnLns as $dnLn) {
            array_push($resp, $dnLn->user_id);
        }
        return implode(',', $resp);
    }

    /**
     * Displays Genealogy Tree
     */
    public static function dispTree($userId, $level = 0) {
        if (empty($userId) || $level > self::getOption('depth_ceiling')) {
            return false;
        }
        $level++;
       
        $userIds = explode(',', $userId);
        echo "<ul>";
        foreach ($userIds as $curUser) {
            $uInfo = User::findOne($curUser);
           $lvn ='NA';
           $pos ='';
            if ($uInfo) {
            	 $pInf = Profile::findOne(['user_id'=>$uInfo->id]);
            	 if($pInf){
            	 	if($pInf->place_position =='Left'){
            	 		$pos= '(L)';
            	 	}else{
            	 		$pos= '(R)';
            	 	}
            	 	$pk = Package::findOne($pInf->pack_id);
            	 		$upk = UserPackage::findOne(['user_id'=>$uInfo->id, 'payment_status'=>'Paid']);
            	 	
            	 	$lvn=$pk->name;
				}
                $dispImg = Html::img(['img/icon_usr.png'], ['alt' => $uInfo->username]);
                $url = Url::to(['organization/genealogy', 'startFrom' => $curUser]);
                echo "<li>";
                echo "<a href='$url' class='tooltip1'>" . $dispImg;
               echo "<p class='details'>$uInfo->username($uInfo->id)$pos</p><br>($lvn)</br>";
                  
                self::tooltip($curUser);
                echo "</a>";
                
                
                
                $downLine = self::downlineUsers($curUser);
                self::dispTree($downLine, $level);
                echo "</li>";
                
            }
        }
        echo "</ul>";
    }

    /**
     * Displays Sponsor Tree
     */
    public static function sponsorTree() {
        $lgUser = Yii::$app->user->identity->id;
        $userId = self::downlineUsers($lgUser);
        $userIds = explode(',', $userId);
        echo "<ul>";
        foreach ($userIds as $curUser) {
            $uInfo = User::findOne($curUser);
            if ($uInfo) {
                $dispImg = Html::img(['img/icon_usr.png'], ['alt' => $uInfo->username]);
                echo "<li>";
                echo "<a href='javascript:;' class='tooltip1'>" . $dispImg;
                echo "<p class='details'>$uInfo->username</p>";
              
                self::tooltip($curUser);
                echo "</a>";
                echo "</li>";
            }
        }
        echo "</ul>";
    }

    /**
     * Returns child nodes
     */
    public static function userNodes($userId) {
        $nodes = [];
        $downlineUsers = Profile::find()->joinWith('user')->select(['user_id', 'user.username'])->where(['placement' => $userId])->orderBy(['place_position' => SORT_ASC])->all();
        if (!empty($downlineUsers)) {
            foreach ($downlineUsers as $dnLn) {
                $nodes[] = [
                    'text' => $dnLn->user->username,
                    'nodes' => self::userNodes($dnLn->user_id)
                ];
            }
        }
        return $nodes;
    }

    /**
     * Returns tabular data
     */
    public static function tabularData() {
        $firstUser = (Yii::$app->user->identity->user_role === 2) ? self::firstUser() : Yii::$app->user->identity->id;
        $userInfo = self::userInfo($firstUser, ['username']);
        $nodes = self::userNodes($firstUser);
        $data = [
            'text' => $userInfo->username,
            'nodes' => $nodes
        ];
        return [$data];
    }

    /**
     * Returns user info
     */
    public static function userInfo($userId, $select = null) {
        if ($select == null) {
            $userInfo = User::findOne($userId);
        } else {
            $userInfo = User::find()->select($select)->where(['id' => $userId])->one();
        }
        return $userInfo;
    }

    public static function setActiveMenu($menu, $sub = false) {
        $curMain = Yii::$app->session->get('curMain');
        $curSub = Yii::$app->session->get('curSub');
        if ($sub && $menu == $curSub) {
            return 'class="current-page"';
        } else if (!$sub && $menu == $curMain) {
            return 'class="active selected"';
        }
    }

    public static function userPack($user_id, $withoutLimit = false) {
        $upackInfo = UserPackage::find()->where(['user_id' => $user_id, 'payment_status'=>'Paid'])->orderBy(['id' => SORT_DESC])->one();
        if($upackInfo){
        if ($withoutLimit) {
            return $upackInfo;
        }
        if ($upackInfo && $upackInfo->payment_status == 'Paid') {
            return $upackInfo;
        }
        
        }else{
           $upackInfo = UserPackage::find()->where(['user_id' => $user_id, 'payment_status'=>'Pending'])->orderBy(['id' => SORT_DESC])->one(); 
           if($upackInfo){
        if ($withoutLimit) {
            return $upackInfo;
        }
        if ($upackInfo && $upackInfo->payment_status !== 'Paid') {
            return $upackInfo;
        }
            
        }
        
        }
        return false;
    }

    public static function unreadBadge() {
        $unread = Messages::find()->where(['msg_to' => Yii::$app->user->identity->id, 'status' => 0])->count();
        if ($unread > 0) {
            return '<span class="badge badge-danger pull-right">' . $unread . '</span>';
        }
    }

    public static function columnTotal($provider, $fieldName) {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }
        return Yii::$app->formatter->format($total, 'currency');
    }

    public static function uProfile($userId) {
        $profile = Profile::findOne(['user_id' => $userId]);
        return $profile;
    }

}
