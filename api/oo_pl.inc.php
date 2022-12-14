<?php
class PLQuote extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $quote;
    public $person;
    public $pub;
    public $source;
    public $quote_href;
}

class PLHomeArticle extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $heading;
    public $tagline;   
    public $content;
    public $external_review;
    public $summary;
    public $storyimg_href;
    public $article_href;
    public $link;
    public $linktitle;
}

class PLCarouselImage extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $img_href;
    public $title;
    public $lead;
    
    //-------CONSTRUCTOR--------------------
}

class PLTab extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $tabid;
    public $tabname;
    public $content;  
    public $content_href;
}
?>