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

    protected function initializeAttributes(\Nethgui\Module\ModuleAttributesInterface $attributes)
    {
        $url = $this->getPlatform()->getDatabase('configuration')->getProp('subscription','PricingUrl');
        if (strpos($url, 'nethesis') !== false) {
            $languageCatalog = "NethServer_Module_Register";
        } else {
            $languageCatalog = "NethServer_Module_Dashboard_SystemStatus_Subscription";
        }
        return new \NethServer\Tool\CustomModuleAttributesProvider($attributes, array(
            'languageCatalog' => $languageCatalog)
        );
    }

    private function readSystemId()
    {
        if (!$this->systemId) {
            $this->systemId = $this->getPlatform()->getDatabase('configuration')->getProp('subscription', 'SystemId');
        }
        return $this->systemId;
    }

    public function process()
    {
        $this->readSystemId();
    }

    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        $url = $this->getPlatform()->getDatabase('configuration')->getProp('subscription','PricingUrl');
        $view['SystemId'] = $this->readSystemId();
        $view['enterprise'] = strpos($url, 'nethesis');
    }
}
