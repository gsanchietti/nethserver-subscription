<?php

echo "<div class='dashboard-item'>";
echo $view->header()->setAttribute('template',$T('subscription_title'));
if (!$view['SystemId']) {
   echo "<div>".$T('buy_subscription_label')."</div>";
   echo "<div class='pull-right'>";
   echo $view->button('Register', $view::BUTTON_LINK)->setAttribute('value', $view->getModuleUrl('/Subscription'));
   echo "</div>";
} else {
   echo "<dl>";
   echo "<dt>".$T('systemid_label')."</dt><dd>"; echo $view->textLabel('SystemId'); echo "</dd>";
   echo "<dt>".$T('subscriptionplan_label')."</dt><dd>"; echo $view->textLabel('SubscriptionPlan'); echo "</dd>";
   echo "</dl>";
}
echo "</div>";

$view->includeCSS("
    .dashboard-item .pull-right {
       float: right
    }
");

