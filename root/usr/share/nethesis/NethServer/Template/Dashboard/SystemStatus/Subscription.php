<?php

$subUrl = $view->getModuleUrl('/Subscription');

echo "<div class='dashboard-item'>";
echo $view->header()->setAttribute('template',$T('community_title'));
   echo "<div>";
   echo "<p class='support-description'>".$T('community_support_label')."</p>";
   echo "<div class='support-links pull-right'>";
   echo "<a href='https://community.nethserver.org/' target='_blank'>".$T('forum_label')."</a>";
   echo "<a href='http://docs.nethserver.org/' target='_blank'>".$T('manual_label')."</a>";
   echo "<a href='https://wiki.nethserver.org/' target='_blank'>".$T('wiki_label')."</a>";
   echo "</div>";
   echo "<div class='pull-right'></div>";
   echo "</div>";
echo "</div>";

echo "<div class='dashboard-item'>";
echo $view->header()->setAttribute('template',$T('subscription_title'));
if (!$view['SystemId']) {
   echo "<p class='support-description'>".$T('buy_subscription_label')."</p>";
   echo "<div class='pull-right'>";
   echo '<span id="regNowBtn">'.$T('subscribe_label').'</span>';
   echo "</div>";
} else {
   echo "<dl>";
   echo "<dt>".$T('systemid_label')."</dt><dd>"; echo $view->textLabel('SystemId'); echo "</dd>";
   if ($view['SubscriptionPlan']) {
       echo "<dt>".$T('subscriptionplan_label')."</dt><dd>"; echo $view->textLabel('SubscriptionPlan'); echo "</dd>";
   }
   echo "</dl>";
}
echo "</div>";


$view->includeCSS("
    .dashboard-item .pull-right {
       float: right
    }
    #regNowBtn {
        color: white;
        border: 1px solid #00425b;
        text-transform: uppercase;
        background: #00719a;
        margin-top: 5px;
    }
    .support-description {
        padding: 5px;
    }
    .support-links a {
       padding: 10px;
       margin-top: 30px;
       font-size: 120%;
       font-weight: bold;
       color: #00A1DE;
   }

");
$view->includeJavascript("
    $('#regNowBtn').button();
    $('#regNowBtn').on('click', function() { window.location.href = '$subUrl' });
");

