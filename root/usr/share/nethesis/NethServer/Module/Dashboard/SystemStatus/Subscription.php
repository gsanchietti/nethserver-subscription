<?php
namespace NethServer\Module\Dashboard\SystemStatus;

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

/**
 * Retrieve NethServer Enterprise subscription status
 *
 * @author Giacomo Sanchietti
 */
class Subscription extends \Nethgui\Controller\AbstractController
{

    public $sortId = 90;

    private $systemId; 
    private $subscriptionPlan;
 
    private function readSystemId()
    {
        if (!$this->systemId) {
            $this->systemId = $this->getPlatform()->getDatabase('configuration')->getProp('subscription', 'SystemId');
        }
        return $this->systemId;
    }

    private function readSubscriptionPlan()
    {
        if (!$this->subscriptionPlan && $this->systemId) {
            // TODO: call remote API
            $this->subscriptionPlan = "";
        }
        return $this->subscriptionPlan;
    }


    public function process()
    {
        $this->readSystemId();
        $this->readSubscriptionPlan();
    }
 
    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        $view['SystemId'] = $this->readSystemId();
        $view['SubscriptionPlan'] = $this->readSubscriptionPlan();
    }
}
