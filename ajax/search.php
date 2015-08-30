<?php 
    /**
    
    OSMTrainRouteAnalysis Copyright © 2014-2015 sb12 osm.mapper999@gmail.com
    
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

// load settings
include "../functions/settings.php";

// load needed functions
include "../functions/overpass.php";
include "../functions/search.php";
include "../functions/start.php";
include "../functions/getData.php";
include "../functions/lang.php";
include "../po_parser/src/Sepia/PoParser.php";
//FIXME: add possibility to change language

// define path to home directory 
define("PATH", "../");

Lang::defineLanguage();

$search = new Search();

if( $search->getData() )
{
	$search->loadXML();
	$search->sortResult("ref");
}
$search->showResult();
?>