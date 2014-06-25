<?php
namespace Monal\Core;
/**
 * Page Template Interfacee.
 *
 * An interface for a front-end page template. Models that want to be
 * used as front-end pages can implement this interface, which will
 * then allow them to be used to instantiate the Monal\Core\Page
 * model.
 *
 * @author  Arran Jacques
 */

interface PageTemplateInterface
{
    /**
     * Return the page template's slug.
     *
     * @return  String
     */
    public function slug();

    /**
     * Return the page template's title.
     *
     * @return  String
     */
    public function title();

    /**
     * Return the page template's description.
     *
     * @return  String
     */
    public function description();

    /**
     * Return the page template's keywords.
     *
     * @return  String
     */
    public function keywords();

    /**
     * Return the page template's URL.
     *
     * @return  String
     */
    public function URL();
}