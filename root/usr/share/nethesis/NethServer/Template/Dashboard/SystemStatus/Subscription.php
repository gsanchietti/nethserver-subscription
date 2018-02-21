<?php

$subUrl = $view->getModuleUrl('/Subscription');
echo "<div class='dashboard-item'>";
echo $view->header()->setAttribute('template',$T('subscription_title'));
if (!$view['SystemId']) {
   echo "<div>".$T('buy_subscription_label')."</div>";
   echo "<div class='pull-right'>";
   echo '<span id="regNowBtn">Register now</span>';
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
    }

");
$view->includeJavascript("
    $('#regNowBtn').button();
    $('#regNowBtn').on('click', function() { window.location.href = '$subUrl' });
");

