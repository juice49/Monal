<?php
/**
 * Resource.
 *
 * Helper functions for working with system resources.
 *
 * @author  Arran Jacques
 */

class Resource
{
    /**
     * Clone a directory and it’s contents to a new location.
     *
     * @param   String
     * @param   String
     * @return  Void
     */
    public static function cloneDirecotry($source, $destination)
    {
        $source = rtrim($source, '/');
        $destination = rtrim($destination, '/');
        $destination = rtrim($destination);
        foreach (scandir($source) as $file) {
            if (is_readable($source . '/' . $file)) {
                if (is_dir($source . '/' . $file)) {
                    if ($file != '.' AND $file != '..') {
                        mkdir($destination . '/' . $file);
                        self::cloneDirecotry($source . '/' . $file, $destination . '/' . $file);
                    }
                } else {
                    copy($source . '/' . $file, $destination . '/' . $file);
                }
            }
        }
    }
}
