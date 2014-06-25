<?php
namespace Monal\Core;
/**
 * Page.
 *
 * A model of a front-end page. Provides methods  for returning
 * universal properties that every front-end page should have, such
 * as a URL, title, meta description and keywords.
 *
 * @author  Arran Jacques
 */

class Page
{
    /**
     * The page's slug.
     *
     * @var     String
     */
    protected $slug = null;

    /**
     * The page's title.
     *
     * @var     String
     */
    protected $title = null;

    /**
     * The page's description.
     *
     * @var     String
     */
    protected $description = null;

    /**
     * The page's keywords.
     *
     * @var     String
     */
    protected $keywords = null;

    /**
     * The page's URL.
     *
     * @var     String
     */
    protected $url = null;

    /**
     * Constructor.
     *
     * @param   Monal\Core\PageTemplateInterface
     * @return  Void
     */
    public function __construct(PageTemplateInterface $template)
    {
        // Build the page model from a template.
        $this->slug = $template->slug();
        $this->title = $template->title();
        $this->description = $template->description();
        $this->keywords = $template->keywords();
        $this->url = $template->URL();
    }

    /**
     * Return the pages's slug.
     *
     * @return  String
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * Return the pages's title.
     *
     * @return  String
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return the pages's description.
     *
     * @return  String
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Return the pages's keywords.
     *
     * @return  String
     */
    public function keywords()
    {
        return $this->keywords;
    }

    /**
     * Return the pages's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return $this->url;
    }

    /**
     * Return a meta title for the page.
     *
     * @return  String
     */
    public function metaTitle()
    {
        return $this->title();
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