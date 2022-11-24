<?php 

namespace Novanta\AutomaticRelated\Adapter\Install;

class InstallerFactory
{
    /**
     * Function that create installer
     *
     * @return Installer
     */
    public static function create()
    {
        return new Installer();
    }
}