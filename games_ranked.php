<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    // Get the Data we need for this page
    
    $games = jsonLoadAllGames();

    usort($games, function($a, $b)
    {
        return strcmp($a->score, $b->score);
    });
    $games = array_reverse($games);
   
    $games_html = renderRankingTable($games);
           

    // Construct the Page
    $tcontent = <<<PAGE
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Games Ranked</h3>
            </div>
            <div class="panel-body">
            {$games_html}
            </div>
        </div>
        </div>
    </section>
    PAGE;

    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

// Build up our Dynamic Content Items.
$tpagetitle = "Games Rank";
$tpagelead = "";
$tpagecontent = createPage();
$tpagefooter = "";

// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of our Page class
$tpage = new MasterPage($tpagetitle);
// Set the Three Dynamic Areas (1 and 3 have defaults)
if (! empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
$tpage->setDynamic2($tpagecontent);
if (! empty($tpagefooter))
    $tpage->setDynamic3($tpagefooter);
// Return the Dynamic Page to the user.
$tpage->renderPage();
?>