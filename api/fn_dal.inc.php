<?php
// Include the Other Layers Class Definitions
require_once ("oo_bll.inc.php");
require_once ("oo_pl.inc.php");

// ---------JSON HELPER FUNCTIONS-------------------------------------------------------
function jsonOne($pfile, $pid)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek($pid - 1);
    $tdata = json_decode($tsplfile->current());
    return $tdata;
}

function jsonAll($pfile)
{
    $tentries = file($pfile);
    $tarray = [];
    foreach ($tentries as $tentry) {
        $tarray[] = json_decode($tentry);
    }
    return $tarray;
}

function jsonNextID($pfile)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek(PHP_INT_MAX);
    return $tsplfile->key() + 1;
}

function jsonNextUserReviewID($tid)
{
    return jsonNextID("data/json/{$tid}user_review.json");
}



// ---------JSON-DRIVEN OBJECT CREATION FUNCTIONS-----------------------------------------

function jsonLoadOneGame($pid): BLLGame
{
    $game = new BLLGame();
    $game->fromArray(jsonOne("data/json/games.json", $pid));
    return $game;
}

function jsonLoadOneReview($pid, $i): BLLUserReview
{
    $review = new BLLUserReview();
    $review->fromArray(jsonOne("data/json/{$pid}user_review.json", $i));
    return $review;
}

function jsonLoadOnePlatform($i): BLLPlatform
{
    $overview = new BLLPlatform();
    $overview->fromArray(jsonOne("data/json/platform.json", $i));
    return $overview;
}

function jsonLoadOneOverview($i): BLLOverview
{
    $overview = new BLLOverview();
    $overview->fromArray(jsonOne("data/json/ps5_overview.json", $i));
    return $overview;
}

function jsonLoadOneNewsItem($pid): BLLNewsItem
{
    // $tni = new BLLNewsItem();
    // $tni->fromArray(jsonOne("data/json/newsitems.json", $pid));
    // return $tni;
    $tni = new BLLNewsItem();
    $tni->fromArray(jsonOne("data/json/nesitems.json", $pid));
    $tnidata = file_get_contents("data/html/{$tni->item_href}");
    $tdoc = new DOMDocument();
    $tdoc->loadHTML($tnidata);
    $tsel = new DOMXPath($tdoc);
    $tres = $tsel->query('//div[@class="n-tag"]');
    $tni->tagline = $tres->item(0)->nodeValue;
    $tres = $tsel->query('//div[@class="n-summ"]');
    $tni->summary = $tres->item(0)->nodeValue;
    $tres = $tsel->query('//div[@class="n-main"]');
    $tni->content = $tres->item(0)->nodeValue;
}

// --------------MANY OBJECT IMPLEMENTATION--------------------------------------------------------

function jsonLoadAllGames(): array
{
    $tarray = jsonAll("data/json/games.json");
    return array_map(function ($a) {
        $tc = new BLLGame();
        $tc->fromArray($a);
        return $tc;
    }, $tarray);
}

function jsonLoadAllReviews($tid): array
{
    $tarray = jsonAll("data/json/{$tid}user_review.json");
    return array_map(function ($a) {
        $tc = new BLLUserReview();
        $tc->fromArray($a);
        return $tc;
    }, $tarray);
}

function jsonLoadAllNewsItems(): array
{
    $tarray = jsonAll("data/json/newsitems.json");
    return array_map(function ($a) {
        $tc = new BLLNewsItem();
        $tc->fromArray($a);
        // $tni = file_get_contents("data/html{$tc->item_href}");
        // $tdoc = new DOMDocument();
        // $tdoc->loadHTML($tni);
        // $tsel = new DOMXPath($tdoc);
        // $tres = $tsel->query('//div[@class="n-tag"]');
        // $tc->tagline = $tres->item(0)->nodeValue;
        // $tres = $tsel->query('//div[@class"n-summ"]');
        // $tc->summary = $tres->item(0)->nodeValue;

        return $tc;
    }, $tarray);
}

//-------LOAD OVERIEW CONTENT-------
function jsonLoadAllOverview()
{
    $tarray = jsonAll("data/json/ps5_overview.json");
    return array_map(function ($a) {
        $tc = new BLLOverview();
        $tc->fromArray($a);
        return $tc;
    }, $tarray);
}

// ---------XML HELPER FUNCTIONS--------------------------------------------------------
function xmlLoadAll($pxmlfile, $pclassname, $parrayname)
{
    $txmldata = simplexml_load_file($pxmlfile, $pclassname);
    $tarray = [];
    foreach ($txmldata->{$parrayname} as $telement) {
        $tarray[] = $telement;
    }
    return $tarray;
}

function xmlLoadOne($pxmlfile, $pclassname)
{
    $txmldata = simplexml_load_file($pxmlfile, $pclassname);
    return $txmldata;
}

?>