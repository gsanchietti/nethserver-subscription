<?php

echo $view->header()->setAttribute('template', $T('Subscription_header'));

$printPlanInfo = function ($label, $value) use ($T, $view) {
    echo "<div><span class='label'>" . htmlspecialchars($T($label)) . ": </span>";
    echo $view->textLabel($value)->setAttribute('class', 'strong');
    echo "</div>\n";
};

echo "<div class='subscriptionInfo'>";
$printPlanInfo('SystemId_label', 'SystemId');
$printPlanInfo('Created_label', 'Created');
$printPlanInfo('PublicIp_label', 'PublicIp');
echo "<div style='height: 20px'></div>";
$printPlanInfo('PlanName_label', 'PlanName');
$printPlanInfo('Validity_label', 'Validity');
echo "</div>";

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
        font-size: 140%;
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
        margin-right: 10px;
    }

");
