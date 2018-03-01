<?php

echo $view->header()->setAttribute('template', $T('subscription_header'));

$idSystemId = $view->getUniqueId('SystemId');

function printPlanInfo($label, $value) {
    echo "<div><span class='label'>$label: </span><span>$value</span></div>\n";
}

if ($view['SystemId']) {
   echo "<div class='subscriptionInfo'>";
   if ($view['SubscriptionPlan']) {
       printPlanInfo($T('SystemId_label'), $view['SystemId']);
       $created = new DateTime($view['SubscriptionPlan']['created']);
       printPlanInfo($T('Created_label'), $created->format('Y-m-d H:i:s'));
       printPlanInfo($T('PublicIp_label'), $view['SubscriptionPlan']['public_ip']);
       echo "<div style='height: 20px'></div>";
       printPlanInfo($T('SubscriptionPlan_label'), $view['SubscriptionPlan']['subscription']['subscription_plan']['name']);
       $from = new DateTime($view['SubscriptionPlan']['subscription']['valid_from']);
       $until = new DateTime($view['SubscriptionPlan']['subscription']['valid_until']);
       printPlanInfo($T('Validity_label'), $from->format('Y-m-d'). " - " .$until->format('Y-m-d'));
   }
   echo "</div>";
} else {
   echo "<div id='subscriptionPlans'>";
   echo "<p>".$T("subscriptions_info")."</p>";
   echo '<div class="Buttonlist"><a id="regNowBtn" href="'.$view['PricingUrl'].'?action=newServer" target="_blank" title="'.$T('subscriptions_plans').'" role="button" aria-disabled="false">'.$T('subscriptions_plans').'</a>';
    echo "<div class='paste'>".$T('paste_label')."</div>";
   echo '</div>';
   echo "</div>";
}

if (!$view['SystemId']) {
    echo "<div id='regForm'>";
    echo $view->panel('')->insert($view->textInput('RegistrationKey', $view['SystemId'] ? $view::STATE_READONLY : ''));
    echo $view->buttonList()->insert($view->button('register_now', $view::BUTTON_SUBMIT));
    echo "</div>";
}


$view->includeJavascript("
     $('#regNowBtn').button();
");

$view->includeCss("
    #regForm {
        font-size: 120%;
    }

    #regForm h1 {
        padding: 5px;
        font-weight: bold;
    }

    #regForm p {
        padding: 10px;
        margin-bottom: 30px;
    }

    #regForm input {
        width: 64ch;
    }

    .subscriptionInfo {
        margin: 5px;
        padding: 5px;
        font-size: 120%;
    }

    #subscriptionPlans p {
        margin: 5px;
        padding: 20px;
        font-size: 120%;
        line-height: 1.5;
        text-align: justify;
        text-justify: inter-word;
    }

    #subscriptionPlans {
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 50px;
        width: 80em;
        padding: 20px;
        background: linear-gradient(to right, #eee, white);
        border-left: 8px solid #00719a;
    }

    .paste {
        margin-left: auto;
        margin-right: auto;
        font-size: 120%;
        line-height: 1.5;
        padding: 10px;
        margin-bottom: 20px;
    }


    .subscriptionInfo .strong {
        font-weight: bold;
    }

    #regNowBtn {
        color: white;
        border: 1px solid #00425b;
        text-transform: uppercase;
        background: #00719a;
        float: right;
        margin-right: 50px;
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
