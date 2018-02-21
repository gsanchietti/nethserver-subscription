<?php

echo $view->header()->setAttribute('template', $T('subscription_header'));


$idSystemId = $view->getUniqueId('SystemId');

echo "<div id='regForm'>";
echo "<div class='instructions'>";
echo "<h1>".$T('registration_instructions_title')."</h1>";
echo "<p>".$T('registration_instructions_body')."</p>";
echo "</div";
echo $view->panel('123')->insert($view->textInput('SystemId', $view['SystemId'] ? $view::STATE_READONLY : ''));
if (!$view['SystemId']) {
    echo $view->buttonList()->insert($view->button('register_now', $view::BUTTON_SUBMIT));
}
echo "</div>";

if ($view['SystemId']) {
   echo "<div class='subscriptionInfo'>";
   if ($view['SubscriptionPlan']) {
       echo "<span class='label''>".$T('subscriptionplan_label').": </span><span>"; echo $view->textLabel('SubscriptionPlan'); echo "</span>";
   }
   echo "</div>";
} else {
   echo "<div id='subscriptionPlans'>";
   echo "<h1>TODO: describe subscription plans here</h1>";
   echo '<div class="Buttonlist"><a target="_blank" title="'.$T('subscriptions_plans').' role="button" aria-disabled="false">';
   echo '<span id="regNowBtn">'.$T('subscriptions_plans').'</span>';
   echo '</div>';
   echo "</div>";
}

$view->includeJavascript("
    if ($('#$idSystemId').val() == '') {
        $('#subscriptionPlans').show();
        $('#regForm').hide();
    } else {
        $('#subscriptionPlans').hide();
    }
    $('#regNowBtn').button();
    $('#regNowBtn').on('click', function() { 
        window.open('http://www.nethserver.org?action=register', '_blank');
        $('#regForm').show();
        $('#subscriptionPlans').hide();
    });
");

$view->includeCss("
    #subscriptionPlans  h1 {
        margin: 20px;
        color: red;
        font-weight: bold;
        font-size: 200%;
    }

    #regForm .instructions {
        margin-bottom: 10px;
        padding: 10px;
    } 

    #regForm h1 {
        padding: 5px;
        font-weight: bold;
    }

    #regForm p {
        padding: 10px;
        margin-bottom: 30px;
    }

    .subscriptionInfo {
        margin: 5px;
        padding: 5px;
        font-size: 120%;
    }
    .subscriptionInfo .strong {
        font-weight: bold;
    }
    #regNowBtn {
        color: white;
        border: 1px solid #00425b;
        text-transform: uppercase;
        background: #00719a;
    }

    div.register_spacer {
        height: 20px;
    }

    .subscriptionInfo .label {
        font-weight: bold;
        margin-right: 10px;
        font-size: 120%;
    }

");
