<?php 

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