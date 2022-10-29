<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($games, $reviews, $tid, $no_reviews, $average)
{
    
    $gameprofile = "";
    $userReviewProfile = "";
    $recomenedGames = "";
    
    
    $ttabs = xmlLoadAll("data/xml/tabs-club.xml", "PLTab", "Tab");
    $gamesRecomendation = jsonLoadAllGames();

    foreach ($ttabs as $ttab) {
        $ttab->content = file_get_contents("data/html/{$tid}/{$ttab->content_href}");
    }
    $ttabhtml = renderUITabs($ttabs, "club-content");

    foreach ($games as $tg) {
        $gameprofile .= renderGameOverview($tg, $average);
    }
    
    foreach ($reviews as $tr) {
        $userReviewProfile .= renderUserReviews($tr);
    }
    
    foreach($gamesRecomendation as $tg) {
        $recomenedGames .= renderRecomendedGames($tg);
    }
    
    if(!empty($_SESSION["myuser"]))
    {
        {
            $tlink = "<a class=\"btn btn-info\" href=\"user_review_entry.php\">Leave A Review</a>";
        }
    }else{
        $tlink = "";
    }
   
    $tcontent = <<<PAGE
        {$gameprofile}
        <section class="row details" id="game-overview">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Game Info:</h3>
            </div>
            <div class="panel-body">
            {$ttabhtml}
            </div>
            </div>
        
            <h2>Recomended Games:</h2>  
            <style> 
                .table_wrapper{
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                }
                </style>
            <div class="table_wrapper">
            <table class="table table-striped table-hover"> 					
    					<th>
    					{$recomenedGames}
    					</th>    					
            </table>
            </div>   
            
         <h2>{$tlink}</h2>        
        <h2> User Reviews</h2>
        
        {$no_reviews}
        
        {$userReviewProfile}
    PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();



$games = [];
$tid = $_REQUEST["id"] ?? - 1;

$num = jsonNextUserreviewID($tid);
$reviews = [];
$average = 0;
$x = 0;

$no_reviews = null;
if ($num>1)
{
    for ($i = 1; $i < $num; $i ++) {
        $review = jsonLoadOneReview($tid, $i);
        $average = $average + $review->rating;
        $x++;
        $reviews[] = $review;
    }
}
else {
    $no_reviews = <<<EMPTY
<h3>No User Reviews For This Game</h3>
EMPTY;
}

if($average>1){
$average = $average/$x;
}

$average = number_format((float)$average, 2, '.', '');

// Handle our Requests and Search for Players using different methods
if (is_numeric($tid) && $tid > 0) {
    $game = jsonLoadOneGame($tid);
    
    $games[] = $game;
}



// Page Decision Logic - Have we found a player?
// Doesn't matter the route of finding them
if (count($games) === 0) {
    appGoToError();
} else {
    // We've found our player
    $tpagecontent = createPage($games, $reviews, $tid,$no_reviews, $average);
    $tpagetitle = "Game Page";

    // ----BUILD OUR HTML PAGE----------------------------
    // Create an instance of our Page class
    $tpage = new MasterPage($tpagetitle);
    $tpage->setDynamic2($tpagecontent);
    $tpage->renderPage();
}
?>