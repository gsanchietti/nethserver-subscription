<?php

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

namespace NethServer\Module\Subscription;


class Register extends \Nethgui\Controller\AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->declareParameter('RegistrationKey', $this->createValidator()->maxLength(64)->minLength(64), array('configuration', 'subscription', 'Secret'));
    }

    public function validate(\Nethgui\Controller\ValidationReportInterface $report)
    {
        parent::validate($report);
        if( ! $report->hasValidationErrors() ) {
            $plan = $this->getParent()->readSubscriptionPlan($this->parameters['RegistrationKey']);
            if($plan === FALSE) {
                $report->addValidationErrorMessage($this, 'RegistrationKey', 'error_network_registration_key');
            } elseif( ! is_string($plan['uuid'])) {
                $report->addValidationErrorMessage($this, 'RegistrationKey', 'error_invalid_registration_key', array($plan['message']));
            }
        }
    }

    public function process()
    {
        parent::process();
        if($this->getRequest()->isMutation()) {
            $plan = $this->getParent()->readSubscriptionPlan($this->parameters['RegistrationKey']);
            $this->getPlatform()->getDatabase('configuration')->setProp('subscription', array('SystemId' => $plan['uuid']));
            $this->getPlatform()->signalEvent('nethserver-subscription-save &');
        }
    }

    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        parent::prepareView($view);
        $view['PricingUrl'] = $this->getPlatform()->getDatabase('configuration')->getProp('subscription','PricingUrl');
        if($this->getRequest()->isMutation()) {
            $this->getPlatform()->setDetachedProcessCondition('success', array(
                'location' => array(
                    'url' => $view->getModuleUrl('/Subscription/Properties?registerSuccess'),
                    'freeze' => TRUE,
            )));
        }
    }

}
