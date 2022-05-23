
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


/**
 * Installer class
 */
class PluginTaigaConnectorInstaller {

    private const DISPLAY_PREFERENCES_IDS = [2, 3, 4, 5];
    private const PROFILES_HAVING_ACCESS = ['Super-Admin', 'Admin'];

    /**
     * Verifies if the plugin is already installed
     *
     * @return bool Returns true if plugin is already installed
     */
    public function isInstalled(): bool
    {
        global $DB;

        return
            $DB->tableExists('glpi_plugin_taigaconnector_messages', false) &&
            $DB->tableExists('glpi_plugin_taigaconnector_contents', false) &&
            $DB->tableExists('glpi_plugin_taigaconnector_subscriptions', false) &&
            $DB->tableExists('glpi_plugin_taigaconnector_eventtypes', false) &&
            $DB->tableExists('glpi_plugin_taigaconnector_queue', false);

    }

    /**
     * Initiates plugin tables
     *
     * @param string $version Version of database to update to
     * @return void
     *
     * @throws RuntimeException in case schema installation fails
     */
    public function applySchema(string $version = ''): void
    {
        global $DB;

        $schemaName = PLUGIN_TAIGACONNECTOR_DIR . '/install/mysql/install.sql';

        if (!$DB->runFile($schemaName)) {
            throw new RuntimeException(
                'Error occurred during Taiga Connector setup - unable to run schema.'
            );
        }
    }

    /**
     * Initiates plugin tables
     *
     * @param string $version Version of database to update to
     * @return void
     *
     * @throws RuntimeException in case schema installation fails
     */
    public function purgeSchema(): void
    {
        global $DB;

        $schemaName = PLUGIN_TAIGACONNECTOR_DIR . '/install/mysql/uninstall.sql';

        if (!$DB->runFile($schemaName)) {
            throw new RuntimeException(
                'Error occurred while removing Taiga Connector - unable to purge database.'
            );
        }
    }
}