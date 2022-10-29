<?php

class BLLUser
{

    public $name;

    public $fav_game;
}

class BLLGame
{

    // -------CLASS FIELDS------------------
    public $id = null;

    public $game_name;

    public $genre;

    public $age_rating;

    public $release_date;
    
    public $score;
    
    public $ranking;

    public $editorial_review;
    
    public $average_user_score;

    public function fromArray(stdClass $passoc)
    {
        foreach ($passoc as $tkey => $tvalue) {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLUserReview
{

    // class fields
    public $reviewID;

    public $gameID;

    public $heading;

    public $rating;

    public $review;

    public $reviewerName;

    public function fromArray(stdClass $passoc)
    {
        foreach ($passoc as $tkey => $tvalue) {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLNewsItem
{

    // -------CLASS FIELDS------------------
    public $id = null;

    public $heading;

    public $tagline;

    public $thumb_href;

    public $img_href;

    public $item_href;

    public $summary;

    public $content;

    public function fromArray(stdClass $passoc)
    {
        foreach ($passoc as $tkey => $tvalue) {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLPlatform
{
    public $paragraph;    
}

class BLLOverview
{
    public $console_name;
    
    public $manufacturer;
    
    public $storage_capacity;
    
    public $paragragh1;
    
    public $paragraph2;
 
    public function fromArray(stdClass $passoc)
    {
        foreach ($passoc as $tkey => $tvalue) {
            $this->{$tkey} = $tvalue;
        }
    }
}

?>