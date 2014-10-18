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
/**
 * loads parts of overview index page
 */
function start()
{
	loadHeader();
	enterID();
	showRoutes();
	loadFooter();
}

/**
 * loads the header for the index page
 */
function loadHeader()
{
	?>
<title><?php echo Lang::l_('Choose Route');?> - <?php echo Lang::l_('Train Analysis');?></title>
</head>
<body>
<div id="header">
<div>
<h1><?php echo Lang::l_('Train Analysis');?></h1>
<p> <?php echo Lang::l_('Analysis of Train Routes Based on OpenStreetMap Data');?></p>
</div>
</div>
<div id="main">
	<?php
}

/**
 * generates form to choose route id and train
 */
function enterID()
{
	$train = new Train();
	?>
<h2 class="factsheet_heading"><?php echo Lang::l_('Choose Route');?>:</h2>
<div class="choose_route">
	<form action="index.php" method="get">
	
	<label for="id">OSM-ID:</label> <input type="text" name="id">
	
	<?php echo Lang::l_('Train');?>: <?php echo $train->changeTrain();?><input type="submit"/>
	</form>
</div>
	<?php 
	
}

/**
 * generates overview over routes
 */
function showRoutes($amount = 50)
{
	//get page number
	$page = 1;
	if ( isset($_GET["page"]) )
	{
		$page = round($_GET["page"]);
	}
	
	//connect to database
	$con = connectToDB();
	
	//get number of entries
	$query = "SELECT COUNT(id) FROM osm_train_details";
	$result = mysqli_query($con, $query) or return_error("mysql", "message", $con);
	$row = $result->fetch_row();
	$count = $row[0];
	
	$lastpage = ceil( $count / $amount );
	$start = $amount * ( $page - 1 );

	//get order by and check if valid
	if ( isset($_GET["order_by"]) )
	{
		$order_by = $_GET["order_by"];
	}
	if ( !isset($order_by) || ( $order_by != "ref" && $order_by != "from" && $order_by != "to" && $order_by != "operator" && $order_by != "length" && $order_by != "time" && $order_by != "ave_speed" && $order_by != "max_speed" && $order_by != "train" ) )
	{
		$order_by = "ref";
	}
	//get order by and check if valid
	if ( isset($_GET["dir"]) )
	{
		$dir = $_GET["dir"];
	}
	if ( !isset($dir) || ( $dir!="ASC" && $dir!="DESC" ) )
	{
		$dir = "ASC";
	}
	
	$order_array = Array("ref", "from", "to", "operator", "length", "time", "ave_speed", "max_speed", "train");
	foreach ( $order_array as $order )
	{
		if ( $order_by == $order )
		{
			if ( $dir == "ASC" )
			{
				$img_order_by[$order] = '<object type="image/svg+xml" data="img/arrow_desc.svg"></object>';
				$dir_order_by[$order] = "DESC";
			}
			else
			{
				$img_order_by[$order] = '<object type="image/svg+xml" data="img/arrow_asc.svg"></object>';
				$dir_order_by[$order] = "ASC";
			}
		}
		else
		{
			$img_order_by[$order] = "";
			$dir_order_by[$order] = "ASC";
		}
	}
	?>
<h2 class="factsheet_heading"><?php echo Lang::l_('Route Overview');?></h2>
<table class="route_overview">
		<tr>
			<th><a href="?order_by=ref&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["ref"];?>"><?php echo $img_order_by["ref"].Lang::l_('Line');?></a></th>
			<th><a href="?order_by=from&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["from"];?>"><?php echo $img_order_by["from"].Lang::l_('Origin');?></a></th>
			<th><a href="?order_by=to&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["to"];?>"><?php echo $img_order_by["to"].Lang::l_('Destination');?></a></th>
			<th><a href="?order_by=operator&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["operator"];?>"><?php echo $img_order_by["operator"].Lang::l_('Operator');?></a></th>
			<th><a href="?order_by=length&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["length"];?>"><?php echo $img_order_by["length"].Lang::l_('Route Length');?></a></th>
			<th><a href="?order_by=time&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["time"];?>"><?php echo $img_order_by["time"].Lang::l_('Duration');?></a></th>
			<th><a href="?order_by=ave_speed&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["ave_speed"];?>"><?php echo $img_order_by["ave_speed"];?>v<sub>&#x2300;</sub></a></th>
			<th><a href="?order_by=max_speed&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["max_speed"];?>"><?php echo $img_order_by["max_speed"];?>v<sub>max</sub></a></th>
			<th><a href="?order_by=train&page=<?php echo $page;?>&dir=<?php echo $dir_order_by["train"];?>"><?php echo $img_order_by["train"].Lang::l_('Train');?></a></th>
		</tr>
		<tr>
			<td colspan="9" class="pagination"><?php pagination($page, $lastpage, $order_by, $dir);?></td>
		</tr>
	<?php 

	//generate and execute query
	$query = "SELECT * FROM osm_train_details ORDER BY `".@mysqli_real_escape_string($con, $order_by)."` ".mysqli_real_escape_string($con, $dir)." LIMIT ".$start.",".$amount;
	$result = mysqli_query($con, $query) or return_error("mysql", "message", $con);
	
	//show routes 
	while ( $row = @mysqli_fetch_array($result) )
	{
		$mysql_id = $row["id"];
		//get Train
		unset($train);
		$train = new Train($row["train"]);
		?>
		<tr>
			<td><a href="?id=<?php echo $row["id"];?>&train=<?php echo $train->ref;?>" title="<?php echo Lang::l_('Show Route');?>"><?php echo $row["ref"];?></a></td>
			<td><?php echo $row["from"];?></td>
			<td><?php echo $row["to"];?></td>
			<td><?php echo $row["operator"];?></td>
			<td><?php echo round($row["length"], 1);?> km</td>
			<td><?php echo round($row["time"], 0);?> min</td>
			<td><?php echo round($row["ave_speed"]);?> km/h</td>
			<td><?php echo round($row["max_speed"]);?> km/h</td>
			<td style="width:150px"><div style="height:50px;width:150px;display:inline-block;background-image:url('img/trains/<?php echo $train->image;?>');background-repeat:no-repeat;background-position:right;background-size:auto 50px" title="<?php echo $train->name;?>"></div></td>
		</tr>
		<?php 
	}
	?>
		<tr>
			<td colspan="9" class="pagination"><?php pagination($page, $lastpage, $order_by, $dir);?></td>
		</tr>
	</table>
	<?php 
}

/**
 * generates footer
 */
function loadFooter()
{
	?>
</div>
<div id="footer">
<div>
<small><?php echo Lang::l_('Route Data');?> © <a href="http://www.openstreetmap.org/copyright" title="OpenStreetMap Lizenz">OpenStreetMap</a><?php echo Lang::l_(' contributors');?></small>
</div>
</div>
	<?php 
}

/**
 * function to show the pagination
 * @param number $page current page
 * @param number $lastpage last available page
 */
function pagination($page = 1, $lastpage = 1, $order_by = "" , $dir = "" )
{
	$previouspage = $page - 1;
	$nextpage = $page + 1;
	if ( $page > 1 )
	{
		?>
	<a href="?order_by=<?php echo $order_by;?>&page=1&dir=<?php echo $dir;?>" title="<?php echo Lang::l_("First");?>">&lt;&lt;</a><a href="?order_by=<?php echo $order_by;?>&page=<?php echo $previouspage;?>&dir=<?php echo $dir;?>" title="<?php echo Lang::l_("Previous");?>">&lt;</a><?php 
	}
	else
	{
		?>
	<span class="disabled" title="<?php echo Lang::l_("First");?>">&lt;&lt;</span><span class="disabled" title="<?php echo Lang::l_("Previous");?>">&lt;</span><?php
	}
	?><strong><?php echo $page.Lang::l_(" of ").$lastpage;?></strong><?php 
	if ( $page < $lastpage )
	{
		?><a href="?order_by=<?php echo $order_by;?>&page=<?php echo $nextpage;?>&dir=<?php echo $dir;?>" title="<?php echo Lang::l_("Next");?>">&gt;</a><a href="?order_by=<?php echo $order_by;?>&page=<?php echo $lastpage;?>&dir=<?php echo $dir;?>" title="<?php echo Lang::l_("Last");?>">&gt;&gt;</a>
		<?php
	}
	else
	{
		?><span class="disabled" title="<?php echo Lang::l_("Next");?>">&gt;</span><span class="disabled" title="<?php echo Lang::l_("Last");?>">&gt;&gt;</span>
		<?php
	}
}

/**
 * opens connection to database
 * @return database connection
 */
function connectToDB()
{
	//load settings
	require_once 'functions/mysql_settings.php';
	
	//open connection
	$con = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or return_error("mysql", "message", $con);
	
	//return connection
	return $con;
}


/**
 * show an error message
 * @param String $value
 * @param databse connection
 */
function return_error($value, $type = "message", $dbcon = "")
{
	global $route;
	//set error message
	$errormsg["no_id"] = Lang::l_("error_noid");
	$errormsg["invalid_id"] = Lang::l_("error_invalidid");
	$errormsg["no_xml_file"] = Lang::l_("error_noxmlfile");
	$errormsg["invalid_xml_file"] = Lang::l_("error_invalidxmlfile");
	$errormsg["no_route"] = Lang::l_("error_noroute");
	$errormsg["mysql"] = Lang::l_("error_mysql");

	if ( $value == "mysql" ) // add mysql error message (only working when dbcon is set)
	{
		$errormsg["mysql"] .= mysqli_error($dbcon);
	}
	//unknown error message
	if ( !isset($errormsg[$value]) )
	{
		log_error("Unknown error message:" . $value);
	}
	
	//output
	
	// do not show header for mesaage
	if ( $type == "full" )
	{
		?>
		<title><?php echo Lang::l_("error_title"); ?></title>
	</head>
	<body>
		<h1><?php echo Lang::l_("error_heading"); ?></h1>
		<?php
	}
	?>
		<p class="error"><?php echo $errormsg[$value]; ?></p>
	<?php 
	if ( $type == "full" || $value == "mysql" )
	{
		?>
		<a href="index.php" title="<?php echo Lang::l_("Back to Overview");?>"><?php echo Lang::l_("Back to Route Overview");?></a>
		<?php
		//show link to update route if necessary
		if ( $value == "invalid_xml_file" )
		{
			?>
		<a href="?id=<?php echo $route->id;?>&train=<?php echo $route->train->ref;?>&rf=1"><?php echo Lang::l_("Update data");?></a>
			<?php 	
		}
		?>
	</body>
</html>
		<?php
	}
}

/**
 * Write error message to log
 */
function log_error($msg)
{
	$fp = fopen("errors.log", "a");
	fwrite($fp, "\n".date(YYYY-MM-DD)." ".$msg);
	fclose($fp);
}

function showAbout()
{
	?>
	<a id="about_link" href="#about"><?php echo Lang::l_("About This Service");?></a>
	<div class="about" id="about">
	<a class="close" href="#">X</a>
		<h2><?php echo Lang::l_("What is this?"); ?></h2>
		<p><?php echo Lang::l_("What is this? text"); ?></p>
		<h2><?php echo Lang::l_("How do I choose a route?"); ?></h2>
		<p><?php echo Lang::l_("How do I choose a route? text"); ?></p>
		<h2><?php echo Lang::l_("Where does the data come from and is it up to date?"); ?></h2>
		<p><?php echo Lang::l_("Where does the data come from and is it up to date? text"); ?></p>
		<h2><?php echo Lang::l_("Which data is used?"); ?></h2>
		<p><?php echo Lang::l_("used_data_relations"); ?></p>
		<ul>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">ref</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">operator</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">route=rail|train|light_rail|tram|subway</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">service=high_speed|long_distance|night|car|car_shuttle|regional|commuter</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">color|colour</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">text_color|text_colour|colour:text</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">from</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Train_Route">to</a></li>
		</ul>
		<p><?php echo Lang::l_("used_data_ways"); ?></p>
		<ul>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">railway=rail|light_rail|tram|narrow_gauge|subway</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">maxspeed</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">maxspeed:forward</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">maxspeed:backward</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">operator</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">railway:traffic_mode</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">electrified</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">voltage</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">frequency</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">bridge</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">tunnel</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">embankment</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">cutting</a></li>
		</ul>
		<p><?php echo Lang::l_("used_data_maxspeed"); ?></p>
		<ul>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">service</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">railway:pzb</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">railway:lzb</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">railway:imu</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">railway:ects</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">railway:selcab</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">highspeed</a></li>
			<li><a href="http://wiki.openstreetmap.org/wiki/OpenRailwayMap/Tagging#Tracks">usage=main|branch</a></li>
		</ul>
		<p><?php echo Lang::l_("used_data_stops"); ?></p>
		<ul>
			<li>name</li>
			<li>description</li>
		</ul>
		<h2><?php echo Lang::l_("I have a suggestion. / I found an error"); ?></h2>
		<p><?php echo Lang::l_("suggestion_error_text"); ?></p>
		<h2><?php echo Lang::l_("Changelog"); ?></h2>
		<h3>v0.1 October 5, 2014</h3>
		<ul>
			<li>Initial version as preview for railway mappers</li>
		</ul>
		<h3>v0.2 October 18, 2014</h3>
		<ul>
			<li>Better error handling</li>
			<li>Additional trains and generic trains</li>
			<li>Support of maxspeed in mph</li>
			<li>New About page</li>
            <li>Minor tweaks and bugfixes</li>
		</ul>
		<a type="application/rss+xml" href="changelog.rss">Complete Changelog</a>
	</div>
	<?php
}
?>