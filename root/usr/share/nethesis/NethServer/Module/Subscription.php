<?php
namespace NethServer\Module;

/*
 * Copyright (C) 2018 Nethesis S.r.l.
 * 
 * This script is part of NethServer.
 * 
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

use Nethgui\System\PlatformInterface as Validate;

/**
 * Mange NethServer Enterprise subscription
 * 
 */
class Subscription extends \Nethgui\Controller\AbstractController
{

    protected function initializeAttributes(\Nethgui\Module\ModuleAttributesInterface $base)
    {
        return \Nethgui\Module\SimpleModuleAttributesProvider::extendModuleAttributes($base, 'Management');
    }

    public function initialize()
    {
        parent::initialize();
        $this->declareParameter('RegistrationKey', $this->createValidator()->maxLength(64)->minLength(64), array('configuration', 'subscription', 'Secret'));
    }

    private function readSystemId()
    {
        if (!$this->systemId) {
            $this->systemId = $this->getPlatform()->getDatabase('configuration')->getProp('subscription', 'SystemId');
        }
        return $this->systemId;
    }

    private function readSubscriptionPlan()
    {
        if (!$this->subscriptionPlan) {
            $secret = $this->getPlatform()->getDatabase('configuration')->getProp('subscription','Secret');
            $apiUrl = $this->getPlatform()->getDatabase('configuration')->getProp('subscription','ApiUrl');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl."machine/info/");
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: token $secret", "Content-type: application/json"));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
            $result = curl_exec($ch); 
            curl_close($ch);

            $this->subscriptionPlan = json_decode($result, true);
        }
        return $this->subscriptionPlan;
    }

    protected function onParametersSaved($changedParameters)
    {
        parent::onParametersSaved($changedParameters);
        $this->getPlatform()->signalEvent('nethserver-subscription-save');
    }

    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        $view['PricingUrl'] = $this->getPlatform()->getDatabase('configuration')->getProp('subscription','PricingUrl');
        $view['SubscriptionPlan'] = $this->readSubscriptionPlan();
        $view['SystemId'] = $this->readSystemId();
    }

    public function nextPath()
    {
        if($this->getRequest()->isMutation()) {
            return "Subscription";
        }
        return FALSE;
    }

}
