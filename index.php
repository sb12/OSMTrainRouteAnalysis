<?php 
    /**
    
    OSMTrainRouteAnalyzer Copyright © 2014 sb12 osm.mapper999@gmail.com
    
    This file is part of OSMTrainRouteAnalyzer.
    
    OSMTrainRouteAnalyzer is free software: you can redistribute it 
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
<html>
<head>

<meta charset='utf-8'> 

<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<link rel="alternate" type="application/rss+xml" href="changelog.rss" title="Changelog">

<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
 
<!-- load jquery -->
<script type="text/javascript" src="flot/jquery.js"></script>

<!-- load javascript functions -->
<script type="text/javascript" src="javascript/functions.js"></script>
<?php
//turn off error_reports
error_reporting(0);
include "functions/train_details.php";
include "functions/getData.php";
include "functions/lang.php";
include "functions/start.php";
include "functions/train.php";
include "po_parser/src/Sepia/PoParser.php";
//include "lang/lang_de.php"; //FIXME: add possibility to change language

// define path to home directory 
define("PATH", "../../../");

Lang::defineLanguage();
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
	showAbout();
}
	?>
</body>
</html>