<?php 
    /**
    
    OSMTrainRouteAnalysis Copyright © 2014 sb12 osm.mapper999@gmail.com
    
    This file is part of OSMTrainRouteAnalysis.
    
    OSMTrainRouteAnalysis is free software: you can redistribute it 
    and/or modify it under the terms of the GNU General Public License 
    as published by the Free Software Foundation, either version 3 of 
    the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
    */
?>
<?php
//turn off error_reports
//error_reporting(0);
include "functions/train_details.php";
include "functions/getData.php";
include "functions/lang.php";
include "functions/start.php";
include "functions/train.php";
include "functions/search.php";
include "po_parser/src/Sepia/PoParser.php";
//FIXME: add possibility to change language

// define path to home directory 
define("PATH", "");

// load language
Lang::defineLanguage();
?>
<!DOCTYPE html>
<html>
<head>

<meta charset='utf-8'> 
<meta name="description" content="<?php echo Lang::l_('Analysis of Train Routes Based on OpenStreetMap Data');?>">

<!-- include leaflet -->
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>

<!-- include bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
 
<!-- load jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- load javascript functions -->
<script type="text/javascript" src="javascript/functions.js"></script>


<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />

<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="alternate" type="application/rss+xml" href="changelog.php" title="Changelog">

<?php
//route id is defined -> get route 
if(isset($_GET["id"])) 
{
	$route = new Route();
	
	// get data
	$route -> getData();
	$route -> train =  new Train();
	$route -> loadXml();
	$route -> loadRelationWays();
	$route -> calculateSpeed();
	$route -> output();
	showAbout();
}
// route is not defined -> possibility to show route
else 
{
	start();
	Search::showSearchResult();
	showAbout();
}
	?>
</body>
</html>