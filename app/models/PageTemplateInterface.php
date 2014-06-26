<?php
namespace Monal\Models;
/**
 * Page Template Interfacee.
 *
 * An interface for a front-end page template. Models that want to be
 * used as front-end pages can implement this interface, which will
 * allow them to be used to instantiate the Monal\Models\Page model.
 *
 * @author  Arran Jacques
 */

interface PageTemplateInterface
{
    /**
     * Set the page template's slug.
     *
     * @param   String
     * @return  Void
     */
    public function setSlug($slug);

    /**
     * Set the page template's URI.
     *
     * @param   String
     * @return  Void
     */
    public function setURI($uri);

    /**
     * Set the page template's title.
     *
     * @param   String
     * @return  Void
     */
    public function setTitle($title);

    /**
     * Set the page template's description.
     *
     * @param   String
     * @return  Void
     */
    public function setDescription($description);

    /**
     * Set the page template's keywords.
     *
     * @param   String
     * @return  Void
     */
    public function setKeywords($keywords);

    /**
     * Return the page template's slug.
     *
     * @return  String
     */
    public function slug();

    /**
     * Return the page template's URI.
     *
     * @return  String
     */
    public function URI();

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
}