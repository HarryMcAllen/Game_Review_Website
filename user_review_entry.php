``<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createFormPage()
{
    
    $tmethod = appFormMethod();
    $taction = appFormActionSelf();

    $tcontent = <<<PAGE
        <form class="form-horizontal" method="{$tmethod}" action="{$taction}">
    	<fieldset>
    		<!-- Form Name -->
    		<legend>Enter Your Review</legend>
            
                <!-- Select Basic -->
    		<div class="form-group">
    			<label class="col-md-4 control-label" for="choose_game">Choose Game</label>
    			<div class="col-md-4">
    				<select id="choose_game" name="choose_game" class="form-control">
    					<option value="1">Gran Turismo 7</option>
    					<option value="2">Fifa 22</option>
    					<option value="3">Fortnite</option>
    					<option value="4">NBA 2K22</option>
    					<option value="5">Assetto Coursa Competizione</option>
                        <option value="6">F1 2021</option>
    					<option value="7">Apex Legends</option>
    					<option value="8">Among Us</option>
    					<option value="9">Sackboy: A Big Adventure</option>
    					<option value="10">Farming Simulator 22</option>
    				</select>
                    <span class="help-block">Choose a game to Review</span>
    			</div>
    		</div>
    
    		<!-- Text input-->
    		<div class="form-group">
    			<label class="col-md-4 control-label" for="heading">Heading</label>
    			<div class="col-md-4">
    				<input id="heading" name="heading" type="text" placeholder="" 
    					class="form-control input-md" required=""> <span class="help-block">Enter
    					the heading for your review</span>
    			</div>
    		</div>
    
                <!-- Select Basic -->
    		<div class="form-group">
    			<label class="col-md-4 control-label" for="rating">Rating</label>
    			<div class="col-md-4">
    				<select id="rating" name="rating" class="form-control">
    					<option value="1">1</option>
    					<option value="2">2</option>
    					<option value="3">3</option>
    					<option value="4">4</option>
    					<option value="5">5</option>
                       
    				</select>
                    <span class="help-block">Choose a score to give</span>
    			</div>
    		</div>
            
    		<!-- Text input-->
    		<div class="form-group">
    			<label class="col-md-4 control-label" for="review">Review</label>
    			<div class="col-md-4">
    				<input id="review" name="review" type="text" placeholder="" 
    					class="form-control input-md" required=""> <span class="help-block">Enter
    					your review</span>
    			</div>
    		</div>
            
    <!--Button-->
    <div class="form-group">
        <label class = "col-md-4 control-label" for="form-sub">Submit Form</label>
        <div class="col-md-4">
            <button id ="form-sub" name="form-sub" type="submit" class="btn btn-danger">Enter Review</button>
        </div
    </div>
        </fieldset>
        </form>
    PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
session_start(); 

    $errorUrl = "app_review_error.php";
    if(!empty($_SESSION["myuser"]))
    {
        
    }else{
        header("Location: $errorUrl");
    }

   
    
$tpagecontent = "";

if (appFormMethodIsPost()) {
    // Capture the Bio Data
    $tbio = appFormProcessData($_REQUEST["bio"] ?? "");
    // Map the Form Data

    $review = new BLLUserReview();
    $review->reviewerName = $_SESSION["myuser"];
    //$review->gameID = $_REQUEST["id"] ?? - 1;
    $review->gameID = appFormProcessData($_REQUEST["choose_game"] ?? "");
    $review->heading = appFormProcessData($_REQUEST["heading"] ?? "");
    $review->rating = appFormProcessData($_REQUEST["rating"] ?? "");
    $review->review = appFormProcessData($_REQUEST["review"] ?? "");

    $tvalid = true;
    // TODO: PUT SERVER-SIDE VALIDATION HERE
    
    if ($tvalid) {
        $tid = jsonNextUserreviewID($review->gameID);
        $review->reviewID = $tid;

        // convert the review to JSON
        $tsavedata = json_encode($review) . PHP_EOL;

        // Get the existing contents and Append the data
        $tfilecontent = file_get_contents("data/json/{$review->gameID}user_review.json");
        $tfilecontent .= $tsavedata;
        // save the file
        file_put_contents("data/json/{$review->gameID}user_review.json", $tfilecontent);
        $tpagecontent = <<<ITEMADDED
                "<h1>Review with ID = {$review->reviewID} has been saved</h1>
                   <a class="btn btn-info" href="user_review_entry.php">Enter New Review</a>
                   </form>
        ITEMADDED;
    } else {

        $tdest = appFormActionSelf();
        $tpagecontent = <<<ERROR
                                 <div class="well">
                                    <h1>Form was Invalid</h1>
                                    <a class="btn btn-warning" href="{$tdest}">Try Again</a>
                                 </div>
        ERROR;
    }
} else {
   
    $tpagecontent = createFormPage();
}
//$tformdata = processForm($pformdata) ?? array();
$tpagetitle = "Review Entry Page";
$tpagelead = "";
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