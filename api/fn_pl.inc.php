<?php
require_once ("oo_bll.inc.php");
require_once ("oo_pl.inc.php");

// ===========RENDER BUSINESS LOGIC OBJECTS=======================================================================

// ----------NEWS ITEM RENDERING------------------------------------------
function renderNewsItemAsList(BLLNewsItem $pitem)
{
    $titemsrc = ! empty($pitem->thumb_href) ? $pitem->thumb_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
    		    <section class="list-group-item clearfix">
    		        <div class="media-left media-top">
                        <img src="img/news/{$titemsrc}" width="100" />
                    </div>
                    <div class="media-body">
    				<h4 class="list-group-item-heading">{$pitem->heading}</h4>
    				<p class="list-group-item-text">{$pitem->tagline}</p>
    				<a class="btn btn-xs btn-default" href="news.php?storyid={$pitem->id}">Read...</a>
    				</div>
    			</section>
    NI;
    return $tnewsitem;
}

function renderNewsItemAsSummary(BLLNewsItem $pitem)
{
    $titemsrc = ! empty($pitem->thumb_href) ? $pitem->thumb_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
    		    <section class="row details clearfix">
    		    <div class="media-left media-top">
    				<img src="img/news/{$titemsrc}" width="256" />
    			</div>
    			<div class="media-body">
    				<h2>{$pitem->heading}</h2>
    				<div class="ni-summary">
    				<p>{$pitem->summary}</p>
    				</div>
    				<a class="btn btn-xs btn-default" href="news.php?storyid={$pitem->id}">Get the Full Story</a>
    	        </div>
    			</section>
    NI;
    return $tnewsitem;
}

function renderNewsItemFull(BLLNewsItem $pitem)
{
    $titemsrc = ! empty($pitem->img_href) ? $pitem->img_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
    		    <section class="row details">
    		        <div class="well">
    		        <div class="media-left">
    				    <img src="img/news/{$titemsrc}" />
    				</div>
    				<div class="media-body">
    				    <h1>{$pitem->heading}</h1>
    				    <p id="news-tag">{$pitem->tagline}</p>
    				    <p id="news-summ">{$pitem->summary}</p>
    				    <p id="news-main">{$pitem->content}</p>
    				</div>
    				</div>
    			</section>
    NI;
    return $tnewsitem;
}
           
//-----render game table------
function renderGameTable(BLLGame $game)
{
    
}

function renderGameOverview(BLLGame $tg, $avg)
{
//     $tarticles = xmlLoadAll("data/xml/articles-index.xml", "PLHomeArticle", "Article");
    
//     file_get_contents("data/html/{$tg->id}/{$tarticles->content_href}");
    
    $timgref = "img/game/{$tg->id}.png";
    $timg = file_exists($timgref) ? $timgref : "img/game/blank.png";
    $toverview = <<<OV
        <article class="row marketing">
            <h2>Game Details</h2>
            <div class="media-left">
                <img src="$timg" width="255" height="225" />
            </div>
            <div class="media-body">
                <div class="well">
                    <h1>{$tg->game_name}</h1>
                </div>
                <h3><strong>Age Rating:</strong> {$tg->age_rating} &nbsp;&nbsp;&nbsp;&nbsp; <strong>Score:</strong> {$tg->score}</h3>
                <h3><strong>Genre:</strong> {$tg->genre} &nbsp;&nbsp;&nbsp;&nbsp; <strong>User Score:</strong>{$avg}</h3>
                <h3><strong>Review:</strong> {$tg->release_date}</h3>
            </div>               
        </article>
    OV;
    return $toverview;
}

function renderUserReviews(BLLUserReview $tr)
{
    
    $userReviews = <<<PAGE
        
        <div class ="row">
            <h4> {$tr->reviewerName}</h4>
            <div class="panel panel-primary">           
            <div class="panel-body">
                <h2>$tr->heading $tr->rating/5</h2>               
                <div>{$tr->review}</div>
            </div>
            </div>
            </div>
    PAGE;
    return $userReviews;
}
//-----RENDER REVIEW FORM------
function renderReviewForm()
{
    $tmethod = appFormMethod();
    $taction = appFormActionSelf();
    
    $review_form = <<<PAGE
    
        <review_form class="form-horizontal" method="{$tmethod}" action="{$taction}">
    	<fieldset>
    		<!-- Form Name -->
    		<legend>Enter Your Review</legend>
    		
                <!-- Select Basic -->
    		<div class="form-group">
    			<label class="col-md-4 control-label" align="left" for="choose_game">Choose Game</label>
    			<div class="col-md-4">
    				<select id="choose_game" name="choose_game"  class="form-control">
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
    		
            <!-- Text input-->
    		<div class="form-group">
    			<label class="col-md-4 control-label" for="rating">rating</label>
    			<div class="col-md-4">
    				<input id="rating" name="rating" input type="number" step="0.01" min="0" max="10" placeholder=""
    					class="form-control input-md" required=""> <span class="help-block">Enter
    					a score out of 10</span>
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
        </review_form>
    PAGE;
    
    if (appFormMethodIsPost()) {
        // Capture the Bio Data
        $tbio = appFormProcessData($_REQUEST["bio"] ?? "");
        // Map the Form Data
        
        $review = new BLLUserReview();
        $review->reviewerName = $_SESSION["myuser"];
        $review->gameID = $_REQUEST["id"] ?? - 1;
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
    }
    
    
    return $review_form;
}
//-----RECOMENDED GAMES--------
function renderRecomendedGames(BLLGame $tg)
{
    $timgref = "img/game/{$tg->id}.png";
    $timg = file_exists($timgref) ? $timgref : "img/game/blank.png";
    
    $rowdata = <<<PAGE
           <td class="media-left">
                '<a href="game.php?id={$tg->id}"> <img src="$timg" width="255" height="225" /></a>'
                <h3>$tg->game_name</h3>
            </td>
    PAGE;
  	return $rowdata;
    
}
//-----------RANKING PAGE TABLE RENDERING-------------
function renderRankingTable(array $gamelist)
{
    $trowdata ="";
    $i = 1;
    foreach ($gamelist as $game) {
        $tlink = "<a class=\"btn btn-info\" href=\"game.php?id={$game->id}\">More...</a>";
        $trowdata .=<<<ROW
        <tr> <td>{$i}</td>
            <td><h3>{$game->game_name}</h3><div></div></td>
            <td>{$game->age_rating}</td>
            <td>{$game->genre}</td>
            <td>{$game->score}</td>
            <td>{$tlink}</td> 
        ROW;
        $i++;
    }
    $ttable = <<<TABLE
    <table class="table table-striped table-hover">
    					<thead>
    						<tr>
                                <th>Rank</th>
    							<th>Name</th>
                                <th>Age Rating</th>
                                <th>Genre</th>
                                <th>Score</th>
    							<th> </th>
    						</tr>
    					</thead>
    					<tbody>
    					{$trowdata}
                        
    					</tbody>
    </table>
    TABLE;
    					return $ttable;
}

function renderConsoleOverview(BLLOverview $to)
{
    
    $timgref = "img/carousel/ps5_comp.jpg";
    $timg = file_exists($timgref) ? $timgref : "img/game/blank.png";
    
    $tshtml = <<<OVERVIEW
        <div class="well">
            <div class="media-left">
                <img src="$timg" width="350" height="225" />
            </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        Console Name: <strong>{$to->console_name}</strong>
                    </li>
                    <li class="list-group-item">
                        Manufacturer: <strong>{$to->manufacturer}</strong>
                    </li>
                    <li class="list-group-item">
                        Location: <strong>{$to->storage_capacity}</strong>
                    </li>
                </ul>
               
        </div>
    OVERVIEW;
    return $tshtml;

}


// =============RENDER PRESENTATION LOGIC OBJECTS==================================================================
function renderUICarousel(array $pimgs, $pimgdir, $pid = "mycarousel")
{
    $tci = "";
    $count = 0;

    // -------Build the Images---------------------------------------------------------
    foreach ($pimgs as $titem) {
        $tactive = $count === 0 ? " active" : "";
        $thtml = <<<ITEM
                <div class="item{$tactive}">
                    <img class="img-responsive" src="{$pimgdir}/{$titem->img_href}">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>{$titem->title}</h1>
                            <p class="lead">{$titem->lead}</p>
        		        </div>
        			</div>
        	    </div>
        ITEM;
        $tci .= $thtml;
        $count ++;
    }

    // --Build Navigation-------------------------
    $tdot = "";
    $tdotset = "";
    $tarrows = "";

    if ($count > 1) {
        for ($i = 0; $i < count($pimgs); $i ++) {
            if ($i === 0)
                $tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\" class=\"active\"></li>";
            else
                $tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\"></li>";
        }
        $tdotset = <<<INDICATOR
                <ol class="carousel-indicators">
                {$tdot}
                </ol>
        INDICATOR;
    }
    if ($count > 1) {
        $tarrows = <<<ARROWS
        		<a class="left carousel-control" href="#{$pid}" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        		<a class="right carousel-control" href="#{$pid}" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
        ARROWS;
    }

    $tcarousel = <<<CAROUSEL
        <div class="carousel slide" id="{$pid}">
                {$tdotset}
    			<div class="carousel-inner">
    				{$tci}
    			</div>
    		    {$tarrows}
        </div>
    CAROUSEL;
    return $tcarousel;
}

function renderUITabs(array $ptabs, $ptabid)
{
    $count = 0;
    $ttabnav = "";
    $ttabcontent = "";

    foreach ($ptabs as $ttab) {
        $tnavactive = "";
        $ttabactive = "";
        if ($count === 0) {
            $tnavactive = " class=\"active\"";
            $ttabactive = " active in";
        }
        $ttabnav .= "<li{$tnavactive}><a href=\"#{$ttab->tabid}\" data-toggle=\"tab\">{$ttab->tabname}</a></li>";
        $ttabcontent .= "<article class=\"tab-pane fade{$ttabactive}\" id=\"{$ttab->tabid}\">{$ttab->content}</article>";
        $count ++;
    }

    $ttabhtml = <<<HTML
            <ul class="nav nav-tabs">
            {$ttabnav}
            </ul>
        	<div class="tab-content" id="{$ptabid}">
    			  {$ttabcontent}
    		</div>
    HTML;
    return $ttabhtml;
}

function renderUIQuote(PLQuote $pquote)
{
    $tquote = <<<QUOTE
        <blockquote>
        {$pquote->quote}
        <small>{$pquote->person} in <cite title="{$pquote->source}">{$pquote->pub}</cite></small>
    	</blockquote>
    QUOTE;
    return $tquote;
}

function renderUIHomeArticle(PLHomeArticle $phome, $pwidth = 6)
{
    $thome = <<<HOME
        <article class="col-lg-{$pwidth}">
    		
    		<div class="home-thumb">
    			<img src="img/{$phome->storyimg_href}" width="300" height="168" />
    		</div>
            <div>
    		    {$phome->content}
           
            <br>
    			<a class="btn btn-info" href="{$phome->link}">{$phome->linktitle}</a>
           </div>
            <br>
    	</article>
        
    HOME;
    return $thome;
}

function renderExternalReview(PLHomeArticle $phome)
{
    $thome = <<<HOME
    <div><h2>{$phome->heading}</h2></div>
     <div><h2>{$phome->summary}</h2></div>
    <div><h2>{$phome->external_review}</h2></div>
HOME;
    return $thome;
}

function renderUIKeyPlayersList(array $pkeyplayers)
{
    $tkeylist = "";
    foreach ($pkeyplayers as $tkey) {
        $tli = <<<LI
                <section class="list-group-item">
                    <h4 class="list-group-item-heading">
                        <a href="player.php?name={$tkey->key_href}">{$tkey->name}</a>
                    </h4>
                    <p class="list-group-item-text">{$tkey->desc}</p>
                </section>
        LI;
        $tkeylist .= $tli;
    }

    $tpanel = <<<PANEL
        <div class="panel panel-default">
            <div class="panel-heading">Key Players</div>
            <div class="panel-body">
            <div class="list-group">
            {$tkeylist}
            </div>
    PANEL;
    return $tpanel;
}

function renderUIStatistics(array $pstats)
{
    $tstats = "";
    foreach ($pstats as $tstat) {
        $tstats .= <<<STAT
                <li class="list-group-item">
                    <span class="badge">{$tstat->value}</span>
                    <strong>{$tstat->stat}: </strong>
                    <a href="player.php?name={$tstat->ref}">{$tstat->holder}</a>
                </li>
        STAT;
    }

    $tpanel = <<<PANEL
        <div class="well well-lg">
            <ul class="list-group">
                {$tstats}
            </ul>
        </div>
    PANEL;
    return $tpanel;
}

function renderPagination($ppage, $pno, $pcurr)
{
    if ($pno <= 1)
        return "";

    $titems = "";
    $tld = $pcurr == 1 ? " class=\"disabled\"" : "";
    $trd = $pcurr == $pno ? " class=\"disabled\"" : "";

    $tprev = $pcurr - 1;
    $tnext = $pcurr + 1;

    $titems .= "<li$tld><a href=\"{$ppage}?page={$tprev}\">&laquo;</a></li>";
    for ($i = 1; $i <= $pno; $i ++) {
        $ta = $pcurr == $i ? " class=\"active\"" : "";
        $titems .= "<li$ta><a href=\"{$ppage}?page={$i}\">{$i}</a></li>";
    }
    $titems .= "<li$trd><a href=\"${ppage}?page={$tnext}\">&raquo;</a></li>";

    $tmarkup = <<<NAV
        <ul class="pagination pagination-sm">
            {$titems}
        </ul>
    NAV;
    return $tmarkup;
}

function renderUIGoogleMap($plong, $plat)
{
    $tmaphtml = <<<MAP
        <iframe width="100%" height="100%"
                            frameborder="1" scrolling="no" marginheight="0"
                            marginwidth="0"
                            src="http://maps.google.com/maps?f=q&amp;
                            source=s_q&amp;hl=en&amp;
                            geocode=&amp;q={$plong},{$plat}
                            &amp;output=embed"></iframe>
    MAP;
    return $tmaphtml;
}

?>