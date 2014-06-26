<?php
namespace Monal\Models;
/**
 * Page Template.
 *
 * A basic implementation of the PageTemplateInterface, which can be
 * used to instantiate new instances of the Monal\Models\Page model.
 *
 * @author  Arran Jacques
 */

class PageTemplate implements PageTemplateInterface
{
    /**
     * The page template's ID.
     *
     * @var     Integer
     */
    protected $id = null;

    /**
     * The page template's slug.
     *
     * @var     String
     */
    protected $slug = null;

    /**
     * The page template's URI.
     *
     * @var     String
     */
    protected $uri = null;

    /**
     * The page template's title.
     *
     * @var     String
     */
    protected $title = null;

    /**
     * The page template's description.
     *
     * @var     String
     */
    protected $description = null;

    /**
     * The page template's keywords.
     *
     * @var     String
     */
    protected $keywords = null;

    /**
     * Set the page template's slug.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Set the page template's slug.
     *
     * @param   String
     * @return  Void
     */
    public function setSlug($slug)
    {
        $this->slug = trim($slug, '/');
    }

    /**
     * Set the page template's URI.
     *
     * @param   String
     * @return  Void
     */
    public function setURI($uri)
    {
        $this->uri = trim($uri, '/');
    }

    /**
     * Set the page template's title.
     *
     * @param   String
     * @return  Void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set the page template's description.
     *
     * @param   String
     * @return  Void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set the page template's keywords.
     *
     * @param   String
     * @return  Void
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Return the page template's ID.
     *
     * @return  String
     */
    public function ID()
    {
        return $this->id;
    }

    /**
     * Return the page template's slug.
     *
     * @return  String
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * Return the page template's URI.
     *
     * @return  String
     */
    public function URI()
    {
        return $this->uri;
    }

    /**
     * Return the page template's title.
     *
     * @return  String
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return the page template's description.
     *
     * @return  String
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Return the page template's keywords.
     *
     * @return  String
     */
    public function keywords()
    {
        return $this->keywords;
    }
}