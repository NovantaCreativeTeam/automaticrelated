<?php 
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/
namespace Novanta\AutomaticRelated\Adapter\Install;

use PrestaShop\PrestaShop\Adapter\Entity\Configuration;

class Installer
{
    /**
     * Funzione che effettia l'istallazione del modulo
     *
     * @param \Module $module
     *
     * @return bool
     */
    public function install(\Module $module)
    {
        return $this->installDatabase()
            && $this->registerHooks($module)
            && $this->initializeConfiguration();
    }

    /**
     * Funzione che effettua la disistallazione del modulo
     *
     * @return bool
     */
    public function uninstall()
    {
        return $this->uninstallDatabase()
            && $this->destroyConfiguration();
    }

    /**
     * Funzione che crea le tabelle del modulo
     *
     * @return bool
     */
    protected function installDatabase()
    {
        // No Table to install
        return true;
    }

    /**
     * Funzione che elimina le tabelle del modulo
     *
     * @return bool
     */
    protected function uninstallDatabase()
    {
        // No Table to uninstall
        return true;
    }

    /**
     * Funzione che registra gli hook del modulo
     *
     * @param \Module $module
     *
     * @return bool
     */
    protected function registerHooks(\Module $module)
    {
        $hooks = [
            'displayFooterProduct'
        ];

        return (bool) $module->registerHook($hooks);
    }

    /**
     * Funzione che inizializza la configurazione del modulo
     *
     * @return bool
     */
    protected function initializeConfiguration()
    {
        return Configuration::updateValue('AUTOMATICRELATED_CS_ENABLED', true)
            && Configuration::updateValue('AUTOMATICRELATED_CS_FEATURE', null)
            && Configuration::updateValue('AUTOMATICRELATED_CS_CATEGORY', true)
            && Configuration::updateValue('AUTOMATICRELATED_CS_MANUFACTURER', false)
            && Configuration::updateValue('AUTOMATICRELATED_CS_LIMIT', 4)

            && Configuration::updateValue('AUTOMATICRELATED_US_ENABLED', true)
            && Configuration::updateValue('AUTOMATICRELATED_US_FEATURE', null)
            && Configuration::updateValue('AUTOMATICRELATED_US_CATEGORY', true)
            && Configuration::updateValue('AUTOMATICRELATED_US_MANUFACTURER', false)
            && Configuration::updateValue('AUTOMATICRELATED_US_LIMIT', 4);
    }

    /**
     * Funzione che cancella la configurazione del modulo
     *
     * @return bool
     */
    protected function destroyConfiguration()
    {
        return Configuration::deleteByName('AUTOMATICRELATED_CS_ENABLED')
            && Configuration::deleteByName('AUTOMATICRELATED_CS_FEATURE')
            && Configuration::deleteByName('AUTOMATICRELATED_CS_CATEGORY')
            && Configuration::deleteByName('AUTOMATICRELATED_CS_MANUFACTURER')
            && Configuration::deleteByName('AUTOMATICRELATED_CS_LIMIT')

            && Configuration::deleteByName('AUTOMATICRELATED_US_ENABLED')
            && Configuration::deleteByName('AUTOMATICRELATED_US_FEATURE')
            && Configuration::deleteByName('AUTOMATICRELATED_US_CATEGORY')
            && Configuration::deleteByName('AUTOMATICRELATED_US_MANUFACTURER')
            && Configuration::deleteByName('AUTOMATICRELATED_US_LIMIT');
    }

    /**
     * Funzione che si occupa di eseguire le query
     * per l'istallazione e la disistallazione del modulo
     *
     * @param array $queries
     *
     * @return bool
     */
    private function executeQueries($queries)
    {
        foreach ($queries as $query) {
            if (!\Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }
}