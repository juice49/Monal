<?php
namespace Monal\API;
/**
 * Dashboad API.
 *
 * This providers a static interface to the systems Packages API.
 *
 * @author  Arran Jacques
 */

use Monal\API;

class Packages extends API
{
    /**
     * Return a collection of all Monal system packages, wether installed
     * or not.
     *
     * @return  Illuminate\Support\Collection
     */
    public static function monalPackages()
    {
        return self::systemInstance()->packages->monalPackages();
    }

    /**
     * Return a collection of all uninstalled Monal system packages.
     *
     * @return  Illuminate\Support\Collection
     */
    public static function uninstalledPackages()
    {
        return self::systemInstance()->packages->uninstalledPackages();
    }

    /**
     * Return a collection of all installed Monal system packages.
     *
     * @return  Illuminate\Support\Collection
     */
    public static function installedPackages()
    {
        return self::systemInstance()->packages->installedPackages();
    }

    /**
     * Check if a Monal system package is installed.
     *
     * @param   String
     * @return  Boolean
     */
    public static function isInstalled($package_namespace)
    {
        return self::systemInstance()->packages->isInstalled($package_namespace);
    }

    /**
     * Install a Monal system package.
     *
     * @param   String
     * @return  Boolean
     */
    public static function install($package_namespace)
    {
        return self::systemInstance()->packages->install($package_namespace);
    }

    /**
     * Publish a Monal system package’s assets.
     *
     * @param   String
     * @param   String
     * @param   String
     */
    public static function publishAssets($vendor, $package, $assets_dir)
    {
        return self::systemInstance()->packages->install($vendor, $package, $assets_dir);
    }
}