<?php
namespace Monal\Core;
/**
 * App.
 *
 * Monal's application library for retrieving and setting core
 * application settings.
 *
 * @author  Arran Jacques
 */

class App
{
    /**
     * The template to use for 404 errors.
     *
     * @var     String
     */
    protected $missing_page_template = 'errors.missing';

    /**
     * Return the template to use for 404 errors.
     *
     * @return  String
     */
    public function missingTemplate()
    {
        return $this->missing_page_template;
    }

    /**
     * Set the template to use for 404 errors.
     *
     * @param   String
     * @return  Void
     */
    public function setMissingTemplate($template)
    {
        $this->missing_page_template = (string) $template;
    }
}