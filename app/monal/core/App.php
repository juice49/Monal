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
     * The template to use for general errors.
     *
     * @var     String
     */
    protected $error_template = 'errors.default';

    /**
     * The template to use for 403 errors.
     *
     * @var     String
     */
    protected $error_template_403 = 'errors.403';

    /**
     * The template to use for 404 errors.
     *
     * @var     String
     */
    protected $error_template_404 = 'errors.404';

    /**
     * The template to use for 500 errors.
     *
     * @var     String
     */
    protected $error_template_500 = 'errors.500';

    /**
     * Return the template to use for general errors.
     *
     * @return  String
     */
    public function errorTemplate()
    {
        return $this->error_template;
    }

    /**
     * Set the template to use for 403 errors.
     *
     * @param   String
     * @return  Void
     */
    public function setErrorTemplate($template)
    {
        $this->error_template = (string) $template;
    }

    /**
     * Return the template to use for 403 errors.
     *
     * @return  String
     */
    public function error403Template()
    {
        return $this->error_template_403;
    }

    /**
     * Set the template to use for 403 errors.
     *
     * @param   String
     * @return  Void
     */
    public function setError403Template($template)
    {
        $this->error_template_403 = (string) $template;
    }

    /**
     * Return the template to use for 404 errors.
     *
     * @return  String
     */
    public function error404Template()
    {
        return $this->error_template_404;
    }

    /**
     * Set the template to use for 404 errors.
     *
     * @param   String
     * @return  Void
     */
    public function setError404Template($template)
    {
        $this->error_template_404 = (string) $template;
    }

    /**
     * Return the template to use for 500 errors.
     *
     * @return  String
     */
    public function error500Template()
    {
        return $this->error_template_500;
    }

    /**
     * Set the template to use for 404 errors.
     *
     * @param   String
     * @return  Void
     */
    public function setError500Template($template)
    {
        $this->error_template_500 = (string) $template;
    }
}