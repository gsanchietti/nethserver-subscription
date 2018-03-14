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
class Subscription extends \Nethgui\Controller\CompositeController
{

    protected function initializeAttributes(\Nethgui\Module\ModuleAttributesInterface $attributes)
    {
        // currently this module is available only for Community
        if ( ! @file_exists("/etc/e-smith/db/configuration/defaults/nethupdate/type")) {
            return new \NethServer\Tool\CustomModuleAttributesProvider($attributes, array(
                'category' => 'Administration')
            );
        } else {
            return new \NethServer\Tool\CustomModuleAttributesProvider($attributes);
        }
    }

    public function initialize()
    {
        parent::initialize();
        $this->loadChildrenDirectory();
    }

    
    public function readSubscriptionPlan($secret = NULL)
    {
        static $result;
        if(isset($result)) {
            return $result;
        }
        
        $apiUrl = $this->getPlatform()->getDatabase('configuration')->getProp('subscription','ApiUrl');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl."machine/info/");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: token $secret", "Content-type: application/json"));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_code == 200) {
            $result = json_decode($response, true);
        } elseif($http_code == 401) {
            $result = json_decode($response, true);
        } else {
            $this->getLog()->warning(sprintf("%s::%s() http status %s: %s", __CLASS__, __FUNCTION__, $http_code, $response));
            $result = FALSE;
        }
        curl_close($ch);
        return $result;
    }

    public function bind(\Nethgui\Controller\RequestInterface $request)
    {   
        $cdb = $this->getPlatform()->getDatabase('configuration');
        $firstModuleIdentifier = 'Register';
        if($cdb->getProp('subscription', 'SystemId')) {
            $firstModuleIdentifier = 'Properties';
        }
        $this->sortChildren(function ($a, $b) use ($firstModuleIdentifier) {
             if($a->getIdentifier() === $firstModuleIdentifier) {
                 $c = -1;
             } elseif($b->getIdentifier() === $firstModuleIdentifier) {
                 $c = 1;
             } else {
                 $c = 0;
             }
             return $c;
        });
        parent::bind($request);
    }
}
