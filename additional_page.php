<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    // Get the Data we need for this page
    $tcitems = xmlLoadAll("data/xml/carousel-platform.xml", "PLCarouselImage", "Image");
    $ttabs = xmlLoadAll("data/xml/tabs-platform.xml", "PLTab", "Tab");
   
    foreach ($ttabs as $ttab) {
        $ttab->content = file_get_contents("data/html/{$ttab->content_href}");
    }

     $ttabhtml = renderUITabs($ttabs, "club-content");
   
    $overview = jsonLoadOneOverview(1);

   

    // Build the UI Components
    $tcarouselhtml = renderUICarousel($tcitems, "img/carousel");
    
    $overviewhtml = renderConsoleOverview($overview);
    
    // Build UI Components with External HTML Loading
    
    $timgref = "img/carousel/ps5_comp.jpg";
    $timg = file_exists($timgref) ? $timgref : "img/game/blank.png";

    // Construct the Page
    $tcontent = <<<PAGE
        {$tcarouselhtml}
      
          
    
    <div class="panel">
          <div class="panel-heading">
             
          </div>
          <div class="panel-body">
           </div>
            
           <section> {$ttabhtml}</section>
            <h2><iframe width="786" height="393" src="https://www.youtube.com/embed/2kmXp5-sXbE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></h2>
           
        </div>
    PAGE;

    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

// Build up our Dynamic Content Items.
$tpagetitle = "Platform Comparison";
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