<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\TPHelper;
?>
<!-- BEGIN .app-side -->
<aside class="app-side" id="app-side">
    <!-- BEGIN .side-content -->
    <div class="side-content ">
        <!-- BEGIN .logo -->
        <a href="<?= Url::to() ?>" class="logo">
            <?= Html::img(['img/logo_inverse.png'], ['alt' => 'Techplait']) ?>
        </a>
        <!-- END .logo -->
        <!-- BEGIN .side-nav -->
        <nav class="side-nav">
            <!-- BEGIN: side-nav-content -->
            <ul class="unifyMenu" id="unifyMenu">

                <li <?= TPHelper::setActiveMenu('dashboard'); ?>>
                    <a href="<?= Url::to(['/']); ?>">
                        <span class="has-icon"><i class="icon-laptop_windows"></i></span>
                        <span class="nav-title">Dashboard</span>
                    </a>
                </li>
                <li <?= TPHelper::setActiveMenu('organization'); ?>>
                    <a href="#" class="has-arrow" aria-expanded="false">
                        <span class="has-icon"><i class="icon-flow-tree"></i></span>
                        <span class="nav-title">Organization</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a <?= TPHelper::setActiveMenu('genealogy', true); ?> href="<?= Url::to(['organization/genealogy']); ?>">Genealogy</a></li>
                        <li><a <?= TPHelper::setActiveMenu('tabular', true); ?> href="<?= Url::to(['organization/tabular']); ?>">Tabular</a></li>
                        <li><a <?= TPHelper::setActiveMenu('sponsor', true); ?> href='<?= Url::to(['organization/sponsor']); ?>'>Sponsor</a></li>
                         <?php if(Yii::$app->user->identity->user_role===1) { ?>
                         <li><a <?= TPHelper::setActiveMenu('sponsor', true); ?> href='<?= Url::to(['users/mylist']); ?>'>Downlines</a></li> <?php } ?>
                    </ul>
                </li>
                <li <?= TPHelper::setActiveMenu('newuser'); ?>>
                    <a href="<?= Url::to(['users/create']); ?>">
                        <span class="has-icon"><i class="icon-user-plus"></i></span>
                        <span class="nav-title">New User</span>
                    </a>
                </li>
                
                <?php if(Yii::$app->user->identity->user_role===2) { // 2 => Administrator ?>
                
                    <li <?= TPHelper::setActiveMenu('usermanage'); ?>>
                        <a href="<?= Url::to(['users/index']); ?>">
                            <span class="has-icon"><i class="icon-user-tie"></i></span>
                            <span class="nav-title">User Management</span>
                        </a>
                    </li>
                    <li <?= TPHelper::setActiveMenu('sadmin'); ?>>
                        <a href="<?= Url::to(['superadmin/index']); ?>">
                            <span class="has-icon"><i class="icon-user3"></i></span>
                            <span class="nav-title">Super Admin</span>
                        </a>
                    </li>
                    <li <?= TPHelper::setActiveMenu('payout'); ?>>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <span class="has-icon"><i class="icon-credit-card"></i></span>
                            <span class="nav-title">Payout</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a <?= TPHelper::setActiveMenu('release', true); ?> href="<?= Url::to(['payout/release']); ?>">Release</a></li>
                            <li><a <?= TPHelper::setActiveMenu('confirmtrans', true); ?> href="<?= Url::to(['payout/confirmtrans']); ?>">Confirm Transfer</a></li>
                        </ul>
                    </li>
                    <li <?= TPHelper::setActiveMenu('settings'); ?>>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <span class="has-icon"><i class="icon-cog3"></i></span>
                            <span class="nav-title">Settings</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a <?= TPHelper::setActiveMenu('system_settings', true); ?> href="<?= Url::to(['settings/system']); ?>">System Settings</a></li>
                            <li><a <?= TPHelper::setActiveMenu('company_profile', true); ?> href="<?= Url::to(['settings/company']); ?>">Company Profile</a></li>
<!--                            <li><a <?= TPHelper::setActiveMenu('content_manage', true); ?> href="<?= Url::to(['settings/content']); ?>">Content Management</a></li>-->
                        </ul>
                    </li>
                    <li <?= TPHelper::setActiveMenu('packages'); ?>>
                        <a href="<?= Url::to(['package/index']); ?>">
                            <span class="has-icon"><i class="icon-barcode"></i></span>
                            <span class="nav-title">Packages/Levels</span>
                        </a>
                    </li>
                    <li <?= TPHelper::setActiveMenu('ewallet'); ?>>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <span class="has-icon"><i class="icon-wallet"></i></span>
                            <span class="nav-title">Ewallet</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a <?= TPHelper::setActiveMenu('credit_debit', true); ?> href="<?= Url::to(['wallet/creditdebit']); ?>">Credit/Debit</a></li>
                            <li><a <?= TPHelper::setActiveMenu('fund_transfer', true); ?> href="<?= Url::to(['wallet/fundtransfer']); ?>">Fund Transfer</a></li>
                            <li><a <?= TPHelper::setActiveMenu('transfer_history', true); ?> href="<?= Url::to(['wallet/transferhistory']); ?>">Transfer History</a></li>
                        </ul>
                    </li>
                    <li <?= TPHelper::setActiveMenu('transpass'); ?>>
                        <a href="<?= Url::to(['users/transpass']); ?>">
                            <span class="has-icon"><i class="icon-key4"></i></span>
                            <span class="nav-title">Transaction Password</span>
                        </a>
                    </li>
                    <li <?= TPHelper::setActiveMenu('reports'); ?>>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <span class="has-icon"><i class="icon-document3"></i></span>
                            <span class="nav-title">Reports</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a <?= TPHelper::setActiveMenu('creport', true); ?> href="<?= Url::to(['report/commission']); ?>">Commission Report</a></li>
                            <li><a <?= TPHelper::setActiveMenu('poutreport', true); ?> href="<?= Url::to(['report/payout']); ?>">Payout Report</a></li>
                            <li><a <?= TPHelper::setActiveMenu('topearners', true); ?> href="<?= Url::to(['report/topearners']); ?>">Top Earners</a></li>
                        </ul>
                    </li>
                    
                <?php } else { ?>
                    
                    <li <?= TPHelper::setActiveMenu('incomedetails'); ?>>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <span class="has-icon"><i class="icon-credit-card"></i></span>
                            <span class="nav-title">Income Details</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a <?= TPHelper::setActiveMenu('earned', true); ?> href="<?= Url::to(['payout/earned']); ?>">Earned Income</a></li>
                            <li><a <?= TPHelper::setActiveMenu('released', true); ?> href="<?= Url::to(['payout/released']); ?>">Released Income</a></li>
                        </ul>
                    </li>
                    
                    <li <?= TPHelper::setActiveMenu('ewallet'); ?>>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <span class="has-icon"><i class="icon-wallet"></i></span>
                            <span class="nav-title">Ewallet</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a <?= TPHelper::setActiveMenu('history', true); ?> href="<?= Url::to(['wallet/history']); ?>">Ewallet Details</a></li>
                            <li><a <?= TPHelper::setActiveMenu('fund_transfer', true); ?> href="<?= Url::to(['wallet/fundtransfer']); ?>">Fund Transfer</a></li>
                            <li><a <?= TPHelper::setActiveMenu('transfer_history', true); ?> href="<?= Url::to(['wallet/transferhistory']); ?>">Transfer History</a></li>
                        </ul>
                    </li>
                    
                    <li <?= TPHelper::setActiveMenu('transpass'); ?>>
                        <a href="<?= Url::to(['users/transpass']); ?>">
                            <span class="has-icon"><i class="icon-key4"></i></span>
                            <span class="nav-title">Transaction Password</span>
                        </a>
                    </li>
                    
                    <li <?= TPHelper::setActiveMenu('reports'); ?>>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <span class="has-icon"><i class="icon-document3"></i></span>
                            <span class="nav-title">Reports</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a <?= TPHelper::setActiveMenu('creport', true); ?> href="<?= Url::to(['report/commission']); ?>">Commission Report</a></li>
                        </ul>
                    </li>
                    
                    <li <?= TPHelper::setActiveMenu('usermanage'); ?>>
                        <a href="<?= Url::to(['users/profile']); ?>">
                            <span class="has-icon"><i class="icon-user-tie"></i></span>
                            <span class="nav-title">Profile Management</span>
                        </a>
                    </li>
                    
                <?php } ?>
                
                <li <?= TPHelper::setActiveMenu('messages'); ?>>
                    <a href="<?= Url::to(['messages/index']); ?>">
                        <span class="has-icon"><i class="icon-messages"></i></span>
                        <span class="nav-title">Messages</span>
                    </a>
                </li>
                <li <?= TPHelper::setActiveMenu('activity'); ?>>
                    <a href="<?= Url::to(['activity/index']); ?>">
                        <span class="has-icon"><i class="icon-receipt"></i></span>
                        <span class="nav-title">Activity History</span>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['site/logout']) ?>" data-method="POST">
                        <span class="has-icon"><i class="icon-power_settings_new"></i></span>
                        <span class="nav-title">Logout</span>
                    </a>
                </li>

            </ul>
            <!-- END: side-nav-content -->
        </nav>
        <!-- END: .side-nav -->
    </div>
    <!-- END: .side-content -->
</aside>
<!-- END: .app-side -->