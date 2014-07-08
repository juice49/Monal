<?php
namespace Monal\Models;
/**
 * Page.
 *
 * A model of a front-end page. Provides methods for returning
 * universal properties that every front-end page should have, such
 * as a URL, title, meta description and keywords.
 *
 * @author  Arran Jacques
 */

class Page
{
    /**
     * The page's details.
     *
     * @var     array
     */
    protected $details = array();

    /**
     * Constructor.
     *
     * @param   Monal\Models\PageTemplateInterface
     * @return  Void
     */
    public function __construct(PageTemplateInterface $template)
    {
        // Build the page model from a template.
        $this->details['id'] = $template->ID();
        $this->details['slug'] = $template->slug();
        $this->details['uri'] = $template->URI();
        $this->details['title'] = $template->title();
        $this->details['description'] = $template->description();
        $this->details['keywords'] = $template->keywords();
    }

    /**
     * Return the pages's ID.
     *
     * @return  Integer
     */
    public function ID()
    {
        return $this->details['id'];
    }

    /**
     * Return the pages's slug.
     *
     * @return  String
     */
    public function slug()
    {
        return $this->details['slug'];
    }

    /**
     * Return the pages's title.
     *
     * @return  String
     */
    public function title()
    {
        return $this->details['title'];
    }

    /**
     * Return the pages's description.
     *
     * @return  String
     */
    public function description()
    {
        return $this->details['description'];
    }

    /**
     * Return the pages's keywords.
     *
     * @return  String
     */
    public function keywords()
    {
        return $this->details['keywords'];
    }

    /**
     * Return the pages's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return \URL::to($this->details['uri']);
    }

    /**
     * Return a meta title for the page.
     *
     * @return  String
     */
    public function metaTitle()
    {
        return $this->details['title'];
    }

    /**
     * Return a meta tag for the page’s description.
     *
     * @return  String
     */
    public function metaDescriptionTag()
    {
        return '<meta name="description" content="' . $this->description() . '" />';
    }

    /**
     * Return a meta tag for the page’s keywords.
     *
     * @return  String
     */
    public function metaKeywordsTag()
    {
        return '<meta name="keywords" content="' . $this->keywords() . '" />';
    }

    /**
     * Return a canonical link for the page.
     *
     * @return  String
     */
    public function canonicalLink()
    {
        return $this->URL();
    }

    /**
     * Return a canonical tag for the page.
     *
     * @return  String
     */
    public function canonicalTag()
    {
        return '<link rel="canonical" href="' . $this->canonicalLink() . '" />';
    }
}