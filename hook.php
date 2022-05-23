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

include_once (PLUGIN_TAIGACONNECTOR_DIR. "/inc/installer.class.php");


/**
 * Sends log message.
 * @param string $message
 * @return void
 */
function log_taigaconnector_error(string $message): void
{
    $migration = new Migration(PLUGIN_TAIGACONNECTOR_VERSION);
    $migration->displayMessage($message);
}


/**
 * Plugin install process
 * @return boolean
 */
function plugin_taigaconnector_install()
{

    $webhook = new PluginTaigaConnectorInstaller();

    if (!$webhook->isInstalled()) {
        try {
            $webhook->applySchema();
        } catch (Throwable $e) {
            log_taigaconnector_error($e->getMessage());
            exit(1);
        }
    }

    return true;
}


/**
 * Plugin install process
 * @return boolean
 */
function plugin_taigaconnector_uninstall()
{

    $webhook = new PluginTaigaConnectorInstaller();

    if ($webhook->isInstalled()) {
        try {
            $webhook->purgeSchema();
        } catch (Throwable $e) {
            log_taigaconnector_error($e->getMessage());
            exit(1);
        }
    }

    return true;
}