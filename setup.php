<?php

/*
   ------------------------------------------------------------------------
   Taiga Connector - Plugin with implementation of taiga connections on GLPI
   Copyright (C) 2022 by Maykon Facincani
   ------------------------------------------------------------------------

   LICENSE

   This file is part of Maykon Facincani - Taiga Connector Plugin project.

   FPWebhook Plugin is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   FPWebhook is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with the FPWebhook source code. If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------

   @package   TaigaConnector
   @author    Maykon Facincani
   @co-author
   @copyright Copyright (c) 2022 by Maykon Facincani
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @since     2022

   ------------------------------------------------------------------------
*/


use Glpi\Plugin\Hooks;

define('PLUGIN_TAIGACONNECTOR_VERSION', '0.0.1');

// Minimal GLPI version, inclusive
define('PLUGIN_EXAMPLE_MIN_GLPI', '10.0.0');
// Maximum GLPI version, exclusive
define('PLUGIN_EXAMPLE_MAX_GLPI', '10.0.99');

if (!defined("PLUGIN_TAIGACONNECTOR_DIR")) {
    define("PLUGIN_TAIGACONNECTOR_DIR", Plugin::getPhpDir("taigaconnector"));
 }
 


/**
 * Init hooks of the plugin.
 * REQUIRED
 *
 * @return void
 */
function plugin_init_taigaconnector() {
    global $PLUGIN_HOOKS,$CFG_GLPI;

    $PLUGIN_HOOKS['csrf_compliant']['taigaconnector'] = true;
 
    // Plugin::registerClass('PluginTaigaConnectorTicket', ['addtabon' => 'Ticket']);
 
}

/**
 * Get the name and the version of the plugin
 * REQUIRED
 *
 * @return array
 */
function plugin_version_taigaconnector()
{
    return [
        'name' => 'Taiga Connector',
        'version' => PLUGIN_TAIGACONNECTOR_VERSION,
        'author' => '<a href="https://github.com/kaneymhf" target=”_blank”>KaneyMHF</a>',
        'license' => 'AGPLv3+',
        'homepage' => 'https://github.com/kaneymhf/glpi-plugin-taigaconnector',
        'requirements' => [
            'glpi' => [
                'min' => PLUGIN_EXAMPLE_MIN_GLPI,
                'max' => PLUGIN_EXAMPLE_MAX_GLPI,
            ],
            'php' => [
            'exts' => ['snmp'],
            ]
    
        ]
    ];
}

/**
 * Check pre-requisites before install
 * OPTIONNAL, but recommanded
 *
 * @return boolean
 */
function plugin_taigaconnector_check_prerequisites() {
    if (!is_readable(__DIR__ . '/vendor/autoload.php') || !is_file(__DIR__ . '/vendor/autoload.php')) {
        echo "Run composer install --no-dev in the plugin directory<br>";
        return false;
     }
    return true;
 }
 
 /**
  * Check configuration process
  *
  * @param boolean $verbose Whether to display message on failure. Defaults to false
  *
  * @return boolean
  */
 function plugin_taigaconnector_check_config($verbose = false) {
    if (true) { // Your configuration check
       return true;
    }
 
    if ($verbose) {
       echo __('Installed / not configured', 'taigaconnector');
    }
    return false;
 }
