<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    
    $tcontent = <<<PAGE
     <article class="row marketing">
                <h2>User Details</h2>
                <div class="media-body">
                    <div class="well">
                        <h2><strong>User Name:</strong> {$_SESSION["myuser"]}</h2>
                       
                    </div>                   
                </div>
           
    PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

// Build up our Dynamic Content Items.
$tpagetitle = "User Profile";
$tpagecontent = createPage();

// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of our Page class
$tpage = new MasterPage($tpagetitle);
$tpage->setDynamic2($tpagecontent);
$tpage->renderPage();
?>