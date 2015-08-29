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
 * Class for Routes
 * 
 * This class has all functions and variables that are needed for analysing train routes
 * 
 * @author steffen
 *
 */
Class Route 
{

	/**
	 * id of the route relation
	 * @var int
	 */
	public $id;

	/**
	 * route is a custom route (uploaded by a user)
	 * @var String
	 */
	protected $custom;

	/**
	 * id of a custom route (uploaded by a user)
	 * @var String
	 */
	protected $custom_id;
	
	/**
	 * name of xml file
	 * @var String
	 */
	protected $filexml;
	
	/**
	 * time of last update of file
	 * @var double
	 */
	protected $filemtime;
	
	/**
	 * train that is used on the route
	 * @var Train
	 */
	public $train;
	
	/**
	 * VMZ (maxspeed of the train route - independent of chosen vehicles)
	 * @var int
	 */
	public $vmz;

	/**
	 * length of the whole relation
	 * @var double
	 */
	protected $relation_distance=0;

	/**
	 * real average speed (with acceleration and braking)
	 * @var double
	 */
	protected $real_average_speed=0;

	/**
	 * Array that contains all tags of nodes (key=lat and key=lon for position)
	 * @var array[node_id][key]
	 */
	protected $node;
	
	/**
	 * Array that contains the way a node is part of.
	 * @var array[node_id]
	 * FIXME: what happens with nodes that are in more than one way?
	 */
	protected $node_way;

	/**
	 * Array that contains all tags of ways
	 * @var array[way_id][key]
	 */
	protected $way_tags;

	/**
	 * Array that contains all nodes in a way
	 * @var array[way_id][position]
	 */
	protected $way_nodes;

	/**
	 * Array that contains length of ways
	 * @var array[way_id]
	 */
	protected $way_length;

	/**
	 * Array that contains the id of the first node of a way
	 * @var array[way_id]
	 */
	protected $first_node;

	/**
	 * Array that contains the id of the last node of a way
	 * @var array[way_id]
	 */
	protected $last_node;

	/**
	 * Array that contains all tags of the relation
	 * @var array[key]
	 */
	protected $relation_tags;

	/**
	 * Array that contains all ways of the relation
	 * @var array[position]
	 */
	protected $relation_ways;

	/**
	 * Array that contains all stops of the route
	 * @var array[position]
	 */
	protected $relation_stops;

	/**
	 * Array that contains the type (way or node) of all stops of the route
	 * @var array[position]
	 */
	protected $relation_stops_type;
	
	/**
	 * name of stop
	 * @var array[node id]
	 */
	protected $stop_name;
	
	/**
	 * counts holes in relation
	 * @var int
	 */
	protected $count_holes;

	/**
	 * counts distance that is covered by trafficmode values
	 * @var double
	 */
	protected $trafficmode_distance;
	
	/**
	 * counts distance that is covered by operator values
	 * @var double
	 */
	protected $operator_distance;

	/**
	 * counts distance that is covered by tunnel values
	 * @var double
	 */
	protected $tunnel_distance;	
	
	/**
	 * counts distance that is covered by bridge values
	 * @var double
	 */
	protected $bridge_distance;

	/**
	 * counts distance that is covered by cutting values
	 * @var double
	 */
	protected $cutting_distance;

	/**
	 * counts distance that is covered by embankment values
	 * @var double
	 */
	protected $embankment_distance;
	
	/**
	 * counts distance that is covered by all building (embankment, bridge etc.) values
	 * @var double
	 */
	protected $building_distance;
	
	/**
	 * distance from beginning of relation to beginning of way
	 * @var double
	 */ 
	protected $way_start_distance;

	/**
	 * distance of node from first point of way
	 * @var double
	 */
	protected $node_distance;
	
	/**
	 * distance of node from beginning of relation
	 * @var double
	 */
	protected $stop_node_distance;

	/**
	 * min latitude for map bounds
	 * @var double
	 */
	protected $min_lat_bounds;
	
	/**
	 * max latitude for map bounds
	 * @var double
	 */
	protected $max_lat_bounds;
	/**
	 * min longitude for map bounds
	 * @var double
	 */
	protected $min_lon_bounds;
	/**
	 * max longitude for map bounds
	 * @var double
	 */
	protected $max_lon_bounds;
	
	/**
	 * position of node for map (0 if there's a gap in the route)
	 * @var array[id][lat=lat,lon=lon];
	 */
	protected $map_node;
	
	/**
	 * array that contain all maxspeed areas, last value defines if maxspeed was tagged or guessed
	 * @var array[position][distance,maxspeed,exact]
	 */
	protected $maxspeed_array;
	
	/**
	 * array to save all info about a stop
	 * @var array[pos][lat=lat,lon=lon,dis=distance from beginning,ref=node id]
	 */
	protected $stop_position;
	
	/**
	 * array that contains all point where braking or acceleration starts and ends
	 * @var array[pos][distance from beginning][maxspeed]
	 */
	protected $maxspeed_point_array;
	
	/**
	 * array that contains all signals that are passed by the train
	 * @var array[pos][tags[key][value]]
	 */
	protected $signals_array;
	
	/**
	 * variable that contains information about successful update from Overpass API
	 * @var boolean
	 */
	protected $refresh_success;
	
	/**
	 * Load data of route
	 * 
	 * Loads route data from overpass api, when not available yet.
	 */
	public function getData() 
	{

		if( isset($_POST["id"]) ) // post is used when file is uploaded
		{
			$_GET["id"] = $_POST["id"];
			if(isset($_POST["train"]))
			{
				$_GET["train"] = $_POST["train"];
			}
		}
		
		// no id set
		if ( !isset($_GET["id"]) ) 
		{
			// show error
			return_error("no_id", "full");
			die();
		}
		
		// get route id
		$get_id = $_GET["id"];
		
		
		// id is not a valid number
		if ( !is_numeric($get_id) || round($get_id) != $get_id )
		{
			// exception for user routes of the scheme 12345_0
			if( preg_match( "/^[0-9]+[_][0-9]+$/", $get_id ) )
			{
				$file = "./osmdata/user" . $get_id . ".osm";
				if(file_exists($file))
				{
					$spl = preg_split ("[_]", $get_id);
					$this->id = $spl[0];
					$this->filexml = $file;
					$this->custom = true;
					$this->custom_id = $get_id; 
					return;
				}
				else
				{
					return_error("invalid_id", "full");
					die();
				}	
			}
			// show error
			return_error("invalid_id", "full");
			die();
		}

		// save id
		$this->id = $get_id;
		
		if(isset($_FILES["osmfile"])) // user uploaded route file
		{
			$uploaddir = './osmdata/';
			$uploadfile = $uploaddir . "user".$this->id."_";
			$i = 0;
			while(file_exists( $uploadfile . $i . ".osm")) // do not override existing custom routes
			{
				$i++;
			}
			$uploadfile .= $i . ".osm";
			// try uploading file
			if ( move_uploaded_file($_FILES['osmfile']['tmp_name'], $uploadfile)) 
			{
				if( !@simplexml_load_file($uploadfile) )
				{
					return_error("invalid_xml_file","full");
					unlink($uploadfile);
					die();
				}
			}
			else
			{
				return_error("upload_error", "full");
				print_r($_FILES);
				log_error( "File upload error:" . print_r($_FILES["osmfile"]["error"]) );
				die();
			}
			$this->filexml = $uploadfile;
			$this->custom = true;
			$this->custom_id = $get_id . "_" . $i;
		}
		else
		{
			// build link to overpass api
			$overpass_data = "[out:xml];(relation(")
				. $get_id
				. ");rel(br););out;(relation(")
				. $get_id
				. ");>>;);out;");
			$link = "http://overpass-api.de/api/interpreter?data=" . urlencode($overpass_data);
			
			// build file name
			$file_name = "osmdata/data" . $this->id . ".osm";
			
			// check if data needs to be refreshed
			
			$refresh = true; // default value
			
			// relation was already loaded
			if ( file_exists($file_name) )
			{
				// check age of data
				$this->filemtime = filemtime($file_name);
				
				// data is younger than 40 days
				if( $this->filemtime > ( time() - ( 40 * 24 * 60 * 60 ) ) )
				{
					$refresh = false;
				}
			}
			
			// forced refresh
			if ( isset($_GET["rf"]) && $_GET["rf"] == "1" )
			{
				$refresh = true;
			}
			
			if ( isset($_GET["maxspeed"]) && $_GET["maxspeed"] > 0 )
			{
				$this->vmz = $_GET["maxspeed"];
			}
			
			// get data from overpass-api when needed
			if ( $refresh )
			{
				$content = @file_get_contents($link);
				if( $content )
				{
					$this->refresh_success = true;
					file_put_contents($file_name, $content);
					$this->filemtime = time();
				}
				else
				{
					$this->refresh_success = false;
				}
			}
			
			$this->filexml = $file_name;
		}
	}
	 
	/**
	 * Load XML file
	 * 
	 * This function loads the XML file and extracts the nodes and ways
	 */
	function loadXml()
	{
		// show error when file does not exist
		if ( !file_exists($this->filexml) ) 
		{
			return_error("no_xml_file","full");
			die();
		}
		
		// load xml file
		$xml = @simplexml_load_file($this->filexml);
		
		if ( !$xml ) // file is not a valid xml file
		{
			return_error("invalid_xml_file","full");
			die();
		}
		
		// go through each node
		foreach ( $xml->node as $node ) 
		{
			
			// load attributes
			foreach ( $node->attributes() as $a => $b )
			{
				if ( $a == "id" )
				{
					$id = (string)$b;
				}
				if ( $a == "lat" )
				{
					$lat = (string)$b;
				}
				if ( $a == "lon" )
				{
					$lon = (string)$b;
				}
			}
			
			// set lat and lon for node
			$this->node[$id]["lat"] = $lat;
			$this->node[$id]["lon"] = $lon;
			
			// set tags for nodes
			$node_tags = Array();
			foreach ( $node->tag as $tag )
			{
				foreach ( $tag->attributes() as $a => $b ) 
				{
					if ( $a == "k" )//key
					{
						$k = strtolower((string)$b);
					}
					elseif ( $a == "v" )//value
					{
						$v = (string)$b;
					}
				}
				// set tags
				if ( $k != "lat" && $k != "lon" ) // lat and lon are not valid tags 
				{
					$this->node[$id][$k] = $v;
				}
			}
		}
		// go through each way
		foreach ( $xml->way as $way ) 
		{
			// load attributes
			foreach ( $way->attributes() as $a => $b )
			{
				if( $a == "id" )
				{
					$id = (string)$b;
				}
			}
			
			// set tags for ways
			foreach ( $way->tag as $tag )
			{
				foreach ( $tag->attributes() as $a => $b ) 
				{
					if ( $a == "k" )//key
					{
						$k = strtolower((string)$b);
					}
					elseif ( $a == "v" )//value
					{
						$v = (string)$b;
					}
				}
				$this->way_tags[$id][$k] = $v;
			}
			
			//add nodes to ways
			foreach ( $way->nd as $nd )
			{
				foreach ( $nd->attributes() as $a => $b ) 
				{
					if( $a == "ref" )
					{
						$this->way_nodes[$id][] = (string)$b;
					}
				}
			}
				
			//calculate length of way
			$this->way_length[$id] = 0;
			
			//go through all nodes
			$i = 0;
			while ( isset($this->way_nodes[$id][$i]) )
			{
				if ( $i > 0 )//exclude first node
				{
					//add distance between this node and node before
					$this->way_length[$id] += $this->getDistance($this->node[$this->way_nodes[$id][$i-1]]["lat"], $this->node[$this->way_nodes[$id][$i-1]]["lon"], $this->node[$this->way_nodes[$id][$i]]["lat"], $this->node[$this->way_nodes[$id][$i]]["lon"]);
				}
				if ( !isset($this->node_way[$this->way_nodes[$id][$i]]) || $i > 0 )
				{
					/*add distance of node from beginning of way
					(also set for nodes that are only at beginning of way (distance=0) */ 
					$this->node_distance[$this->way_nodes[$id][$i]] = $this->way_length[$id];
					$this->node_way[$this->way_nodes[$id][$i]] = $id;
				}
				$i++;
			}
			//set id of first and last node
			$this->first_node[$id] = $this->way_nodes[$id][0];
			$this->last_node[$id] = $this->way_nodes[$id][$i-1];
		}
		
		$rel_done = false;
		
		//load all relations
		foreach ( $xml->relation as $relation ) 
		{	
			//load attributes
			foreach ( $relation->attributes() as $a => $b)
			{
				if ( $a == "id" )
				{
					$rel_id = (string)$b;
				}
			}
			//temporary array for tags
			$temp_relation_array = Array();
			
			//load relation tags
			foreach ( $relation->tag as $tag )
			{
				foreach ( $tag->attributes() as $a=>$b ) 
				{
					if ( $a == "k" )
					{
						$k = strtolower((string)$b);
					}
					elseif ( $a == "v" )
					{
						$v = (string)$b;
					}
				}
				$temp_relation_array[$k] = $v; //store tags temporary
			}
			// check if tags are relevant (type of relation is either route or route_master)
			if ( isset($temp_relation_array["type"]) && ( $temp_relation_array["type"] == "route" || $temp_relation_array["type"] == "route_master" ) )
			{
				foreach ( $temp_relation_array as $c => $d )
				{
					//do not overwrite tags for route_master when tag is already set in route
					if ( $temp_relation_array["type"] != "route_master" || !isset($this -> relation_tags[$c]) )
					{
						// type tag should only be route
						if ( $c != "type" || $d == "route" )
						{
							// add tags to relation
							$this->relation_tags[$c] = $d;
						}
					}
				}
			}
			
			
			// only ways of relation with the loaded id is needed - this is needed only once (sometimes relations are more than once in the data)
			if ( $rel_id != $this->id || $rel_done )
			{
				continue;
			}
			$rel_done = true; // relation was parsed already -> dos not need to be parsed again.
			
			//load relation members
			foreach ( $relation->member as $member ) 
			{
				$type = "";
				foreach ( $member->attributes() as $a => $b ) 
				{
					// get type of member
					if ( $a == "type" )
					{
						if ( $b == "way" )
						{
							$type = "w";
						}
						elseif ( $b == "node" )
						{
							$type = "n";
						}
						else
						{
							$type = "r";
						}
					}
					
					// get ref of member
					if ( $a == "ref" )
					{
						$member_ref = (string)$b;
						if ( $type == "w" )
						{
							// add ref to ways list
							$this->relation_ways[] = $member_ref;
						}
					}
					
					//get role of member
					if ( $a == "role")
					{
						$role = $b;
					}
					
					//member is a stop -> add to stops list
					if ( $a == "role" && ( $b == "stop" || strstr($b, "stop_") ) )
					{
						$this->relation_stops[] = $member_ref;
						$this->relation_stops_type[] = $type;
					}
				}
				$this->role_way[$member_ref] = $role;
			}
		}
		
		// loaded relation is not a valid route (type and route values not correct)
		if ( !isset($this->relation_tags["type"]) || $this->relation_tags["type"] != "route" || !isset($this->relation_tags["route"]) || !($this->relation_tags["route"] == "train" || $this->relation_tags["route"] == "tram" || $this->relation_tags["route"] == "light_rail" || $this->relation_tags["route"] == "subway" || $this->relation_tags["route"] == "rail") )
		{
			//connect to database
			$con = connectToDB();
			// delete id from database
			@$con->query("DELETE FROM osm_train_details WHERE `id` = " . @$con->real_escape_string($this->id)) or log_error(@$con->error);

			// show error
			return_error("no_route", "full");
			die();
		}
	}
	/**
	 * load relation ways
	 * 
	 * This function loads the ways for the relation
	 */
	function loadRelationWays()
	{
		// set variables to 0
		$maxspeed_before = $maxspeed_before_max = $maxspeed_before_min = $distance_before = $distance_before_min = $distance_before_max = $exact_before = $maxspeed_total_max = $maxspeed_total_min = $maxspeed_total = $last_id = 0;

		// set maxspeed of train
		$maxspeed_train = 0;
		if( isset($this->vmz) && $this->vmz > 0 ) // if a VMZ exists, first use this
		{
			$maxspeed_train = $this->vmz; // use set VMZ
		}
		if($this->train->maxspeed < $this->vmz || $maxspeed_train == 0) // check if a VMZ exists or if vehicles are slower
		{
			$maxspeed_train = $this->train->maxspeed; // use slower or standalone vehicle maxspeed
		}
		
		$this->count_holes = 0; // start value for holes in relation
		$l = 0; // counter for map nodes
		
		// set distance to 0
		$this->trafficmode_distance = $this->operator_distance = $this->tunnel_distance = $this->cutting_distance = $this->embankment_distance = $this->bridge_distance = $this->building_distance = $this->electrified_distance = 0;
		
		// go through all relation ways
		foreach ( $this->relation_ways as $a => $b )
		{
			//exlude platforms and stops
			if ( strstr($this->role_way[$b], "stop") || strstr($this->role_way[$b], "platform") )
			{
				continue;
			}
			//forward or backward?
			if ( isset($last_last_node) )
			{
				$gap[$b] = false;
				if ( $this->first_node[$b] == $last_last_node || $this->first_node[$b] == $last_first_node )
				{
					$direction[$b] = "forward";
				}
				elseif ( $this->last_node[$b] == $last_last_node || $this->last_node[$b] == $last_first_node )
				{
					$direction[$b] = "backward";
				}
				else // there's a hole in the relation
				{
					$this->count_holes++;
					$direction[$b] = "unknown";
					$gap[$b] = true;
				}
			}
			else
			{
				$direction[$b] = "unknown";
				$gap[$b] = true;
			}
				
			// add way direction to way before if needed
			if( isset($direction[$last_id]) && $direction[$last_id] == "unknown" && $direction[$b] != "unknown" )
			{
				if ( ( $direction[$b] == "forward" && $this->first_node[$b] == $last_last_node) || ( $direction[$b] == "backward" && $this->last_node[$b] == $last_last_node))
				{
					$direction[$last_id] = "forward";
				}
				elseif ( ( $direction[$b] == "forward" && $this->first_node[$b] == $last_first_node) || ( $direction[$b] == "backward" && $this->last_node[$b] == $last_first_node))
				{
					$direction[$last_id] = "backward";
				}
			}
			$last_last_node = $this->last_node[$b];
			$last_first_node = $this->first_node[$b];
			$last_id = $b;
		}
		
		$s = 0; //counter for signals
		$distance_node = 0;
		// go through all relation ways
		foreach ( $this->relation_ways as $a => $b )
		{
			//exlude platforms and stops
			if ( strstr($this->role_way[$b], "stop") || strstr($this->role_way[$b], "platform") )
			{
				continue;
			}
				
			// check if way is railway
			if ( !isset($this->way_tags[$b]["railway"]) ||
				( $this->way_tags[$b]["railway"] != "rail" &&
				$this->way_tags[$b]["railway"] != "light_rail" &&
				$this->way_tags[$b]["railway"] != "tram" &&
				$this->way_tags[$b]["railway"] != "narrow_gauge" &&
				$this->way_tags[$b]["railway"] != "miniature" &&
				$this->way_tags[$b]["railway"] != "subway" &&
				$this->way_tags[$b]["railway"] != "construction" ) )
			{
				continue;
			}

			// distance from beginning of relation to beginning of way
			$this->way_start_distance[$b] = $this->relation_distance;

			// get distance from beginning for each node in the way
			// FIXME: This fails when the route is going through the same way twice!!
			foreach ( $this->node_distance as $id => $distance ) // go through all nodes
			{
				if ( $this->node_way[$id] == $b ) //node is in this way
				{
					//adjust node distance if way is backward
					if ( $direction[$b] == "backward" )
					{
						$this->node_distance[$id] = $this->way_length[$b] - $this->node_distance[$id];
					}
					//get distance from beginning of route
					$this->stop_node_distance[$id] = $this->way_start_distance[$this->node_way[$id]] + $this->node_distance[$id];
				}
			}
			
			// add way length to relation distance
			$this->relation_distance += $this->way_length[$b];

			// convert mph if necessary
			if ( isset($this->way_tags[$b]["maxspeed"]) && substr($this->way_tags[$b]["maxspeed"], -3) == "mph" )
			{
				//delete mph string and convert to number
				$this->way_tags[$b]["maxspeed"] = trim(substr($this->way_tags[$b]["maxspeed"], 0, strlen($this->way_tags[$b]["maxspeed"]) - 3));
				if ( is_numeric($this->way_tags[$b]["maxspeed"]) )
				{
					//convert to km/h
					$this->way_tags[$b]["maxspeed"] = round($this->way_tags[$b]["maxspeed"] * 1.609);
				}
				else
				{
					//not a valid mph speed limit
					unset($this->way_tags[$b]["maxspeed"]);
				}
			}			
			
			// delete non numeric maxspeed values
			if ( isset($this->way_tags[$b]["maxspeed"]) && !is_numeric($this->way_tags[$b]["maxspeed"]) )
			{
				unset($this->way_tags[$b]["maxspeed"]);
			}
			
			// set maxspeed 
			// maxspeed tag is set
			if ( isset($this->way_tags[$b]["maxspeed"]) || (isset($this->way_tags[$b]["maxspeed:forward"]) && $direction[$b]=="forward") || ( isset($this->way_tags[$b]["maxspeed:backward"]) && $direction[$b] == "backward" ) )
			{
				//set maxspeed according to way direction
				if ( isset($this->way_tags[$b]["maxspeed:forward"]) && $direction[$b] == "forward" )
				{
					$maxspeed = $this->way_tags[$b]["maxspeed:forward"];
				}
				elseif ( isset($this->way_tags[$b]["maxspeed:backward"]) && $direction[$b] == "backward" )
				{
					$maxspeed = $this->way_tags[$b]["maxspeed:backward"];
				}
				else
				{
					$maxspeed = $this->way_tags[$b]["maxspeed"];
				}
				$exact = true;
				$maxspeed_max = $maxspeed_min = $maxspeed;
			}
			//maxspeed tag is not set
			else
			{
				$maxspeeds = $this->getMaxspeed($b);
				$maxspeed = $maxspeeds[0];
				$maxspeed_min = $maxspeeds[1];
				$maxspeed_max = $maxspeeds[2];
				$exact = false;
			}
			//maxspeeds can not be higher than train maxspeed
			$maxspeed = min($maxspeed, $maxspeed_train);
			$maxspeed_min = min($maxspeed_min, $maxspeed_train);
			$maxspeed_max = min($maxspeed_max, $maxspeed_train);
				
			// get total maximum speed for whole route
			$maxspeed_total_max = max($maxspeed_total_max, $maxspeed);
	
			/*Set maxspeed matrix for average*/
			if ( $maxspeed_before != $maxspeed && $maxspeed_before != 0 )
			{
				$maxspeed_array[] = Array($distance_before, $maxspeed_before, $exact_before);
				$distance_before = 0;
			}
			/*Set maxspeed matrix for max*/
			if( $maxspeed_before_max != $maxspeed && $maxspeed_before_max != 0 )
			{
				$maxspeed_array_max[] = Array($distance_before_max, $maxspeed_before_max, $exact_before);
				$distance_before_max = 0;
			}
			/*Set maxspeed matrix for min*/
			if ( $maxspeed_before_min != $maxspeed && $maxspeed_before_min != 0 )
			{
				$maxspeed_array_min[] = Array($distance_before_min, $maxspeed_before_min, $exact_before);
				$distance_before_min = 0;
			}

			$distance_before += $this->way_length[$b];
			$distance_before_min += $this->way_length[$b];
			$distance_before_max += $this->way_length[$b];
			$maxspeed_before = $maxspeed;
			$maxspeed_before_max = $maxspeed;
			$maxspeed_before_min = $maxspeed;
			$exact_before = $exact;
							
			// handle operators
			// FIXME: how to handle name differences for operators?
			if ( isset($this->way_tags[$b]["operator"]) )
			{
				$this->operator_distance += $this->way_length[$b];
				if ( !isset($this->operator[$this->way_tags[$b]["operator"]]) )
				{
					$this->operator[$this->way_tags[$b]["operator"]] = 0;
				}
				$this->operator[$this->way_tags[$b]["operator"]] += $this->way_length[$b];
			}
			
			// handle traffic_modes
			// default for tram and light rail without traffic_mode tag
			if ( !isset($this->way_tags[$b]["railway:traffic_mode"]) && ( $this->way_tags[$b]["railway"] == "tram" || $this->way_tags[$b]["railway"] == "light_rail" || $this->way_tags[$b]["railway"] == "subway" ) )
			{
				$this->way_tags[$b]["railway:traffic_mode"] = "passenger";
			}
			// traffic mode is set
			if ( isset($this->way_tags[$b]["railway:traffic_mode"]) )
			{
				$this->trafficmode_distance += $this->way_length[$b];
				if ( !isset($this->trafficmode[$this->way_tags[$b]["railway:traffic_mode"]]) )
				{
					$this->trafficmode[$this->way_tags[$b]["railway:traffic_mode"]] = 0;
				}
				$this->trafficmode[$this->way_tags[$b]["railway:traffic_mode"]] += $this->way_length[$b];
			}
			
			// handle electrification
			if ( isset($this->way_tags[$b]["electrified"]) )
			{
				if ( $this->way_tags[$b]["electrified"] != "no" )
				{
					if ( !isset($this->way_tags[$b]["voltage"]) )
					{
						$this->way_tags[$b]["voltage"] = Lang::l_('N/A');
					}
					if ( !isset($this->way_tags[$b]["frequency"]) )
					{
						$this->way_tags[$b]["frequency"] = Lang::l_('N/A');
					}
					if ( !isset($this->electrified[$this->way_tags[$b]["voltage"] . ";" . $this -> way_tags[$b]["frequency"]]) )
					{
						$this->electrified[$this->way_tags[$b]["voltage"] . ";" . $this->way_tags[$b]["frequency"]] = 0;
					}
					$this->electrified[$this->way_tags[$b]["voltage"] . ";" . $this->way_tags[$b]["frequency"]] += $this->way_length[$b];
				}
				else
				{
					if ( !isset($this->electrified["no"]) )
					{
						$this->electrified["no"] = 0;
					}
					$this->electrified["no"] += $this->way_length[$b];
				}
				$this->electrified_distance += $this->way_length[$b];
			}
			
			// handle building structures
			// bridges
			if ( isset($this->way_tags[$b]["bridge"]) )
			{
				if ( $this->way_tags[$b]["bridge"] != "no" )
				{
					$this->bridge_distance += $this->way_length[$b];
					$this->building_distance += $this->way_length[$b];
				}
			}
			
			// tunnels
			if ( isset($this->way_tags[$b]["tunnel"]) )
			{
				if ( $this->way_tags[$b]["tunnel"] != "no" )
				{
					$this->tunnel_distance += $this->way_length[$b];
					$this->building_distance += $this->way_length[$b];
				}
			}
			
			// embankments
			if ( isset($this->way_tags[$b]["embankment"]) )
			{
				if ( $this->way_tags[$b]["embankment"] != "no" )
				{
					$this->embankment_distance += $this->way_length[$b];
					$this->building_distance += $this->way_length[$b];
				}
			}
			
			//cuttings
			if(isset($this -> way_tags[$b]["cutting"]))
			{
				if($this -> way_tags[$b]["cutting"]!="no")
				{
					$this -> cutting_distance+=$this -> way_length[$b];
					$this -> building_distance+=$this -> way_length[$b];
				}
			}
			
			//copy way nodes in a temporary array
			$temp_way_nodes = $this->way_nodes[$b];
			
			//reverse nodes in case direction is backward
			if ( $direction[$b] == "backward" )
			{
				$temp_way_nodes = array_reverse($temp_way_nodes);
			}
			if ( $gap[$b] == true )//gap in the route
			{
				$this->map_node[$l]["lat"] = 0;
				$this->map_node[$l]["lon"] = 0;
				$l++;
			}
			$old_lat = $old_lon = 0;
			foreach ( $temp_way_nodes as $node_ref => $node_id )
			{
				//add nodes to array for drawing the route later;
				$this->map_node[$l]["lat"] = $this->node[$node_id]["lat"];
				$this->map_node[$l]["lon"] = $this->node[$node_id]["lon"];
				
				//get bounds for map
				if ( !isset($this->min_lat_bounds) )
				{
					$this->min_lat_bounds = $this->node[$node_id]["lat"];
				}
				if ( !isset($this->min_lon_bounds) )
				{
					$this->min_lon_bounds = $this->node[$node_id]["lon"];
				}
				if ( !isset($this->max_lat_bounds) )
				{
					$this->max_lat_bounds = $this->node[$node_id]["lat"];
				}
				if ( !isset($this->max_lon_bounds) )
				{
					$this->max_lon_bounds = $this->node[$node_id]["lon"];
				}
				$this->min_lat_bounds = min($this->min_lat_bounds, $this->node[$node_id]["lat"]);
				$this->max_lat_bounds = max($this->max_lat_bounds, $this->node[$node_id]["lat"]);
				$this->min_lon_bounds = min($this->min_lon_bounds, $this->node[$node_id]["lon"]);
				$this->max_lon_bounds = max($this->max_lon_bounds, $this->node[$node_id]["lon"]);
				
				// find signals on the route
				if($old_lat != 0 && $old_lon != 0)
				{
					$distance_node += $this->getDistance($old_lat,$old_lon,$this->node[$node_id]["lat"],$this->node[$node_id]["lon"]);
				}
				if(($old_lat != 0 && $old_lon != 0) || $distance_node == 0)
				{
					if(isset($this->node[$node_id]["railway"]) && $this->node[$node_id]["railway"] == "signal")
					{
						if(isset($this->node[$node_id]["railway:signal:direction"]) && $this->node[$node_id]["railway:signal:direction"] == $direction[$b])
						{
							if( $direction[$b] == "backward" )
							{
								if( isset( $this->node[$node_id]["railway:signal:position"] ) )
								{
									if( $this->node[$node_id]["railway:signal:position"] == "right" )
									{
										$this->node[$node_id]["railway:signal:position"] = "left";
									}
									if( $this->node[$node_id]["railway:signal:position"] == "left" )
									{
										$this->node[$node_id]["railway:signal:position"] = "right";
									}
								}
								if( isset( $this->node[$node_id]["railway:signal:expected_position"] ) )
								{
									if( $this->node[$node_id]["railway:signal:expected_position"] == "right" )
									{
										$this->node[$node_id]["railway:signal:expected_position"] = "left";
									}
									if( $this->node[$node_id]["railway:signal:expected_position"] == "left" )
									{
										$this->node[$node_id]["railway:signal:expected_position"] = "right";
									}
								}
							}
							$this->signals_array[$s][0] = $distance_node;
							$this->signals_array[$s][1] = $node_id; 
							$s++;
						}
					}
				}
				$l++;
				$old_lat = $this->node[$node_id]["lat"];
				$old_lon = $this->node[$node_id]["lon"];
				
			}
		}
		//add last value to maxspeed_array:
		if($distance_before && $maxspeed_before)
		{
			$maxspeed_array[] = Array($distance_before, $maxspeed_before, $exact_before);
		}
		$maxspeed_array[] = Array(0, 0, true);


		$this->maxspeed_array = $maxspeed_array;
	}


	/**
	 * This function produces the html output for the homepage
	 */	
	function output()
	{
		//calculate operatorstring
		if ( $this->operator_distance > 0 )
		{
			$operator_string = "";
			arsort($this->operator);
			foreach ( $this->operator as $a => $b )
			{
				$operator_string .= $a . " (" . round( ( $b / $this->relation_distance ) * 100, 1) . " %), ";
			}
			if ( $this->operator_distance < $this->relation_distance )
			{
				$operator_string .= LANG::l_('N/A') . " (" . round( ( ( $this->relation_distance - $this->operator_distance ) / $this->relation_distance) * 100, 1) . " %)";				
			}
			else
			{
				//delete comma
				$operator_string = substr($operator_string,  0, strlen($operator_string) - 2);
			}
		}	
		else
		{
			$operator_string = LANG::l_('N/A') . " (100 %)";
		}
		
		// calculate trafficmodes string
		$trafficmode_string = LANG::l_('Unknown');//default
		if ( $this->trafficmode_distance > 0 )
		{
			arsort($this->trafficmode);
			$trafficmode_string = "";
			$trafficmode_name = Array(
					"mixed" => LANG::l_('mixed traffic'),
					"passenger" => LANG::l_('passenger traffic'),
					"freight" => LANG::l_('freight traffic')
					);
			foreach ( $this->trafficmode as $a => $b )
			{
				if ( isset($trafficmode_name[$a]) )
				{
					$trafficmode_string .= $trafficmode_name[$a] . " (" . round( ( $b / $this->relation_distance ) * 100, 1) . " %), ";
				}
				else//unknown trafficmode
				{
					$this->trafficmode_distance -= $b; //remove from trafficmode_distance
				}
			}
			if ( $this->trafficmode_distance < $this->relation_distance )
			{
				$trafficmode_string .= LANG::l_('N/A') . " (" . round( ( ( $this->relation_distance - $this->trafficmode_distance ) / $this->relation_distance ) * 100, 1) . " %)";				
			}
			else
			{
				//delete comma
				$trafficmode_string = substr($trafficmode_string,  0, strlen($trafficmode_string) - 2);
			}
		}		
		else
		{
			$trafficmode_string = LANG::l_('N/A')." (100 %)";
		}
		
		// calculate electrified distances
		if ( $this->electrified_distance > 0 )
		{
			arsort($this->electrified);
			$electrified_string = "";
			foreach ( $this->electrified as $a => $b )
			{
				if ( $a == "no" )
				{
					$electrified_string .= LANG::l_('not electrified') . " (" . round( ( $b / $this->relation_distance ) * 100, 1) . " %), ";
				}
				else
				{
					$volfre = explode(";", $a);
					if ( $volfre[0] == LANG::l_('N/A') )
					{
						$voltage = LANG::l_('N/A');
					}
					else
					{
						$voltage = $volfre[0];
					}
					if ( $volfre[1] == LANG::l_('N/A') )
					{
						$frequency = LANG::l_('N/A');
					}
					elseif ( $volfre[1] == "0" )
					{
						$frequency = LANG::l_('DC');
					}
					else
					{
						$frequency = $volfre[1] . " Hz " . LANG::l_('AC');
					}
					if ( $voltage == LANG::l_('N/A') && $frequency == LANG::l_('N/A') )
					{
						$electrified_string .= LANG::l_('electrified with unknown voltage') . " (" . round( ( $b / $this->relation_distance ) * 100, 1) . " %), ";
					}
					else
					{
						$electrified_string .= $voltage . " V / " . $frequency . " (" . round( ( $b / $this->relation_distance ) * 100, 1) . " %), ";
					}					
				}
			}
			if ( $this->electrified_distance < $this->relation_distance )
			{
				$electrified_string .= LANG::l_('N/A') . " (" . round( ( ( $this->relation_distance - $this->electrified_distance ) / $this->relation_distance ) * 100, 1) . " %)";				
			}
			else
			{
				//delete comma
				$electrified_string = substr($electrified_string,  0, strlen($electrified_string) - 2);
			}
		}		
		else
		{
			$electrified_string = LANG::l_('N/A')." (100 %)";
		}
		// calculate structures
		if ( $this->building_distance > 0 )
		{
			$building_string = "";
			if ( $this->tunnel_distance > 0 )
			{
				$building_string .= round($this->tunnel_distance, 1) . " km " . LANG::l_('in tunnels') . " (" . round( ( $this->tunnel_distance / $this->relation_distance ) * 100, 1) . " %), ";
			}
			if ( $this->bridge_distance > 0 )
			{
				$building_string .= round($this->bridge_distance, 1) . " km " . LANG::l_('on bridges') . " (" . round( ( $this->bridge_distance / $this->relation_distance ) * 100, 1) . " %), ";				
			}
			if ( $this->embankment_distance > 0 )
			{
				$building_string .= round($this->embankment_distance, 1) . " km " . LANG::l_('on embankments') . " (" . round( ( $this->embankment_distance / $this->relation_distance ) * 100, 1) . " %), ";
			}
			if ( $this->cutting_distance > 0 )
			{
				$building_string .= round($this->cutting_distance, 1) . " km " . LANG::l_('in cuttings') . " (" . round( ( $this->cutting_distance / $this->relation_distance ) * 100, 1) . " %), ";				
			}
			//check whether there is a ground level part
			if ( $this->relation_distance != $this->building_distance )
			{
				$building_string .= round($this->relation_distance - $this->building_distance, 1) . " km " . LANG::l_('on ground level') . " (" . round( ( ( $this->relation_distance - $this->building_distance ) / $this->relation_distance ) * 100, 1) . " %)";
			}
			else
			{
				//delete comma
				$building_string = substr($building_string,  0, strlen($building_string) - 2);
			}
		}	
		else
		{
			$building_string = round($this->relation_distance, 1) . " km " . LANG::l_('on ground level') . " (100 %)";
		}
		
		if(!isset($this->relation_tags["service"]))
		{
			$this->relation_tags["service"]="";
		}

		//set ref to N/A, when not available
		if ( !isset($this->relation_tags["ref"]) )
		{
			$this->relation_tags["ref"] = "N/A";
		}
		
		//set colour
		if ( isset($this->relation_tags["color"]) )
		{
			$this->relation_tags["colour"]=$this->relation_tags["color"];
		}
		elseif ( !isset($this->relation_tags["colour"]) )
		{
			$this->relation_tags["colour"]="";
		}
		if ( isset($this->relation_tags["text_color"]) )
		{
			$this->relation_tags["text_colour"]=$this->relation_tags["text_color"];
		}
		elseif ( isset($this->relation_tags["colour:text"]) )
		{
			$this->relation_tags["text_colour"]=$this->relation_tags["colour:text"];
		}
		elseif ( !isset($this->relation_tags["text_colour"]) )
		{
			$this->relation_tags["text_colour"]="";
		}
		
		//get from and to values
		if ( !isset($this->relation_tags["from"]) )
		{
			$this->relation_tags["from"] = Lang::l_('Unknown');
		}
		if ( !isset($this->relation_tags["to"]))
		{
			$this->relation_tags["to"] = Lang::l_('Unknown');
		}
		if ( !isset($this->relation_tags["via"]))
		{
			$this->relation_tags["via"] = "";
		}
		
		//get route type:
		$route_type = Route::getRouteType($this->relation_tags["route"],$this->relation_tags["service"]);

		//title
		?>
	<title><?php echo LANG::l_("Train Analysis: ") . $this->relation_tags["ref"]; ?> <?php echo Route::showfromviato($this->relation_tags["to"], $this->relation_tags["from"], $this->relation_tags["via"]); ?></title>
		<?php 
		//update location for custom_files
		if( $this->custom && $this->custom_id )
		{
			?>
<script type="text/javascript">
var stateObj = {};
history.pushState(stateObj, "", "?id=<?php echo $this->custom_id;?>&train=<?php echo $this->train->ref;?>");
</script>
			<?php
		} 
		//javascript for speed profile
		?>
<!-- flot implementation -->
<script type="text/javascript" src="flot/jquery.flot.js"></script>
<script type="text/javascript" src="flot/jquery.flot.dashes.js"></script>
<script type="text/javascript" src="flot/jquery.flot.selection.js"></script>
<script type="text/javascript" src="flot/jquery.flot.resize.js"></script>

  
<script type="text/javascript">

$(function() 
{
	// setup plot
	var options = 
	{
	 	series: 
		{
 			lines: 
 	 		{
	 	 		lineWidth: 1,
	 		},
	 		points: 
		 	{
	 	 		radius: 0.5,
	 		},
	 	shadowSize: 0.3
	},
	grid: 
	{
		hoverable: true,
	 	clickable: true,
	 	color: "#CCCCFF",
	 	lineWidth: 0.1
	},
	colors: ['#3333FF'],
	selection: 
	{
		mode: "x"
	}
};

var startData = [[0,0],<?php 

	//construct matrix for speed data
	$real_average_speed = 0;
	
    $this->maxspeed_point_array[-1] = $this->maxspeed_point_array[0];
    for ( $i = 0; isset($this->maxspeed_point_array[$i]); $i++)
    {
    	//calculate average speed
    	$real_average_speed += ( $this->maxspeed_point_array[$i][0] - $this->maxspeed_point_array[$i-1][0] ) * ( $this->maxspeed_point_array[$i-1][1] + $this->maxspeed_point_array[$i][1] ) / 2;
    	
    	//add speed to javascript matrix
    	echo "[" . $this->maxspeed_point_array[$i][0] . "," . $this->maxspeed_point_array[$i][1] . ", 'real']";
    	
    	if ( isset($this->maxspeed_point_array[$i+1]) )// this is not the last value
       	{
       		echo ","; 
 		} 
    }
    ?>];
    <?php 
    // add allowed maxspeed and distinguish between guessed and mapped values
    $k = 0;
    $l = 0;
    
    // only for first maxspeed value
    if ( $this->maxspeed_array[0][2] ) // mapped maxspeed values
    {
    	?>

	var maxspeed_<?php echo $k;?> = [<?php
		$k++;
	}
	else // guessed maxspeed values
    {
    	?>

	var maxspeed_guessed_<?php echo $l;?> = [<?php
		$l++;
	}

	// all other maxspeed values
    $this->maxspeed_array[-1] = $this->maxspeed_array[0];
    $maxspeed_distance = 0;
    $maxspeed_known = 0;
    for ( $i = 0; isset($this->maxspeed_array[$i]); $i++)
    {
    	// change between guessed and mapped -> new array
    	if($this->maxspeed_array[$i][2]!=$this->maxspeed_array[$i-1][2])
    	{
		    if($this->maxspeed_array[$i][1]<$this->maxspeed_array[$i-1][1]) // add vertical line in the right pattern
		    {
    			echo ",[" . $maxspeed_distance . "," . $this->maxspeed_array[$i][1] . ", 'allowed']";
		    }
		    if($this->maxspeed_array[$i][2]) // mapped maxspeed values
		    {
		    		?>];

	var maxspeed_<?php echo $k;?> = [<?php
				$k++;
			}
			else // guessed maxspeed values
		    {
		    	?>];

	var maxspeed_guessed_<?php echo $l;?> = [<?php
				$l++;
			}
		    if($this->maxspeed_array[$i][1]>$this->maxspeed_array[$i-1][1]) // add vertical line in the right pattern
		    {
    			echo "[" . $maxspeed_distance . "," . $this->maxspeed_array[$i-1][1] . ", 'allowed'],";
		    }
    	}
    	//add speed to javascript matrix
    	echo "[" . $maxspeed_distance . "," . $this->maxspeed_array[$i][1] . ", 'allowed'],";
    	echo "[" . ($maxspeed_distance + $this->maxspeed_array[$i][0]) . "," . $this->maxspeed_array[$i][1] . ", 'allowed']";
    	
    	if ( isset($this->maxspeed_array[$i+1]) &&  $this->maxspeed_array[$i+1][2]==$this->maxspeed_array[$i][2])// this is not the last value
       	{
       		echo ","; 
 		} 
 		$maxspeed_distance += $this->maxspeed_array[$i][0];
 		
 		// calculate how much of the maxspeed data is actually mapped and not guessed
 		if($this->maxspeed_array[$i][2])
 		{
 			$maxspeed_known += $this->maxspeed_array[$i][0];
 		}
    }
    ?>];

    var stationData = [<?php 
    
    //construct matrix for stations
    $j = 0;
    if ( isset($this->relation_stops[0]) )//stops exist
    {
    	//go through all stops
    	foreach ( $this->relation_stops as $nr => $ref )
    	{
    		$stop_i = -1;
    		//get id of stop in stop_position
    		for ( $i = 0; isset($this->stop_position[$i]["ref"]); $i++ )
    		{
    			if ( isset($this->stop_position[$i]["ref"]) && $this->stop_position[$i]["ref"] == $ref )
    			{
    				$stop_i = $i;
    			}
    		}

    		if ( $stop_i >= 0 )
    		{
    			//get stop name
	    		$stop_name[$nr] = "";
	    		if ( $this->relation_stops_type[$nr] == "n" )//stop is node
	    		{
	    			if ( isset($this->node[$ref]["ref_name"]) )
	    			{
	    				$stop_name[$nr] = $this->node[$ref]["ref_name"];
	    			}
	    			elseif ( isset($this->node[$ref]["name"]) )
	    			{
	    				$stop_name[$nr] = $this->node[$ref]["name"];
	    			}
	    			elseif ( isset($this->node[$ref]["description"]) )
	    			{
	    				$stop_name[$nr] = $this->node[$ref]["description"];
	    			}
	    			//mask '-sign:
	    			$stop_name[$nr] = str_replace("'","\'",$stop_name[$nr]);
	    			//write stop into matrix
	    			echo "[" . $this->stop_position[$stop_i]["dis"] . ",0,'" . $stop_name[$nr] . "'],";
	    			$j++; 
	    		}
    		}
    	}	
    }
    ?>[]];

	for ( var i = 0; stationData[i]; i++ )
	{
 		$("<div id='station" + i + "' class='hidden-xs'></div>").css({	
	 		position: "absolute",
	 		border: "none",
	 		padding: "2px",
	 		opacity: 0.80,
	 		width: 300,
	 		"border-radius": "2px",
		 	"transform": "rotate(-90deg)",
		 	"font-size": "0.6em",
		 	height:20,
		 	"z-index": "1"
 		}).appendTo("body");
	}
	var stations = new Array();
	
    function updateLabels(plot, stationData, stations)
    {	
		// add labels for stations
	 	var offset_left = $("#maxspeed").offset().left;
	 	var offset_top = $("#maxspeed").offset().top;
	 	
		for ( var i = 0; stationData[i]; i++ )
		{
			var xpos = stationData[i][0];
			var pO = plot.pointOffset({ x: xpos, y: 0 });
			$("#station" + i).html(stationData[i][2])
			.css({top: offset_top+$("#maxspeed").height()-200, left: (pO.left+offset_left-145)})
			
			if ( $('#maxspeed_labels:checked').length > 0 && ( pO.left + offset_left ) < $("#maxspeed").width() )
			{
				$("#station" + i).fadeIn(200);
			}
			else
			{
				$("#station" + i).hide();
			}
		}
		  
    }	      
    var plotdata = []; 
    var plotdata_nm = [];             
		<?php 
		for ($i = 0; $i < $k; $i++)
		{
			?>
	var plotmaxspeed_<?php echo $i;?>={
		data: maxspeed_<?php echo $i;?>, 
		lines: 
		{
			show: true,
	        fill: true,
	        fillColor: "rgba(255, 168, 0, 0.1)",
	    },
		color: "#FF8800",
	};

	
		plotdata.push(plotmaxspeed_<?php echo $i;?>);
		<?php 
		} 
		for ($i = 0; $i < $l; $i++)
		{
			?>
	var plotmaxspeed_guessed_<?php echo $i;?>={
		data: maxspeed_guessed_<?php echo $i;?>, 
		lines: 
		{
			show: true,
	        fill: true,
	        fillColor: "rgba(255, 168, 0, 0.06)",
	        lineWidth: 0,
	    },
	    dashes:
	    {
		    show: true,
 	 		lineWidth: 1,
 	 		dashLength: 2,
	    },
		color: "#FF8800"
		}
		plotdata.push(plotmaxspeed_guessed_<?php echo $i;?>);

		<?php 
		}?>
		var plotMaxspeed = {
		data: startData, 
		lines: 
		{
			show: true,
		}
		};
		var plotStationData = {
		data: stationData,
		lines: 
		{
			show: false,
		},
		points: 
		{
			show: true,
			radius: 1,
		}
		};

		plotdata.push(plotMaxspeed);
		plotdata.push(plotStationData);

		plotdata_nm.push(plotMaxspeed);
		plotdata_nm.push(plotStationData);
		
	    
		var plot = $.plot("#maxspeed", plotdata,
	 options);


	$("#maxspeed").bind("plothover", function (event, pos, item) 
	{
	 	if ( item) 
		{
	 		var x = item.datapoint[0].toFixed(3),
	 		y = item.datapoint[1].toFixed(0);
	 		var offset_left = $("#maxspeed").offset().left + $("#maxspeed").width();
	 		var offset_top = $("#maxspeed").offset().top;

	 		//default
	 		var postop = item.pageY - 33;
	 		var posleft = item.pageX - $("#tooltip_wrapper").width()/2;
			var className="top";
			var classNameArrow="";
	 		// right border
	 		if ( ( offset_left - posleft ) <  $("#tooltip_wrapper").width() )
	 		{
 				 posleft = item.pageX - $("#tooltip_wrapper").width()+7;
 				 var classNameArrow="right";	 
	 		}
	 		// left border
	 		if ( posleft <  $("#tooltip_wrapper").width()/2 )
	 		{
 				 posleft = item.pageX - 7;
 				 var classNameArrow="left";	 
	 		}
			// top border
			if ( ( postop - offset_top ) < 30 )
 			{
					var postop = item.pageY + 5;
					var className="bottom";
 			}
 			
	 		$("#tooltip").html("km " + x + ": " + y + " km/h");
	 		
 			$("#tooltip_wrapper")
 			.removeClass("top")
 			.removeClass("bottom")
 			.addClass("tooltip "+className)
 		 	.css({top: postop, left: posleft})
			.fadeIn(200);
 			$("#tooltip_arrow")
 			.removeClass("right")
 			.removeClass("left")
 			.addClass("tooltip-arrow "+classNameArrow)
 			if(item.series.data[item.dataIndex][2] == "allowed")
 			{
 	 			$("#tooltip").css("background-color","rgb(255, 168, 0)");
 	 			$("#tooltip").css("border-color","rgb(255, 168, 0)");
 	 			if ( className == "bottom" )
 	 			{
 	 				$("#tooltip_arrow").css("border-bottom-color","rgb(255, 168, 0)");
 	 			}
 	 			else
 	 			{
 	 				$("#tooltip_arrow").css("border-top-color","rgb(255, 168, 0)");
 	 			}
 			}
 			else
 			{
 	 			$("#tooltip").css("background-color","");
 	 			$("#tooltip").css("border-color","");
 	 			$("#tooltip_arrow").css("border-bottom-color","");
 	 			$("#tooltip_arrow").css("border-top-color","");
 			}
	 	} 
	 	else 
	  	{
	 		$("#tooltip_wrapper").hide();
	 	}
	});
	 
	// Create the overview plot
	var options_overview = 
	{
		series: 
		{
	 		lines: 
		 	{
	 	 		lineWidth:0.1,
	 		},
	 		points: {
	 			radius: 0.5,
 			},
	 		shadowSize:0
	 	},
	 	grid: {
	 		color: "#CCCCFF",
	 		lineWidth:0.1
	 	},
	 	colors: ['#3333FF'],
		selection: 
		{
			mode: "x"
		}
	}
	
	var overview = $.plot("#maxspeed_overview", 
	[{
		data: startData, 
		legend: 
		{
			show: false
		},
		lines: 
		{
			show: true,
			lineWidth: 0.5
		},
		shadowSize: 0
 	},
 	{
 		data: stationData,
 		lines: 
 	 	{
 			show: false,
 		},
 		points: 
 	 	{
 			show: true,
 			radius: 0.5,
		}		
 	}],options_overview
 	);

	// now connect the two
	var global_ranges;
	$("#maxspeed").bind("plotselected", function (event, ranges) 
	{

		// clamp the zooming to prevent eternal zoom

		if (ranges.xaxis.to - ranges.xaxis.from < 0.00001) 
		{
			ranges.xaxis.to = ranges.xaxis.from + 0.00001;
		}

		if (ranges.yaxis.to - ranges.yaxis.from < 0.00001) 
		{
			ranges.yaxis.to = ranges.yaxis.from + 0.00001;
		}

		//get the data
		if ( $('#show_maxspeed:checked').length > 0 )
		{
			data = plotdata;
		}
		else
		{
			data = plotdata_nm;
		}

		// do the zooming
		plot = $.plot("#maxspeed", data,
		$.extend(true, {}, options, 
		{
			xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to },
			yaxis: { min: ranges.yaxis.from, max: ranges.yaxis.to }
		})
		);
		global_ranges = ranges;


		// don't fire event on the overview to prevent eternal loop

		overview.setSelection(ranges, true);

		// update labels
		updateLabels(plot, stationData, stations);
	});

	$("#maxspeed_overview").bind("plotselected", function (event, ranges) 
	{
		plot.setSelection(ranges);
	});

	// add labels
	updateLabels(plot, stationData, stations);
	$('#maxspeed_labels').change(function() 
	{
		if ( $('#maxspeed_labels:checked').length > 0 )
		{
			for ( i = 0 ; i < <?php echo $j;?>; i++ )
			{ 
				$('#station' + i).fadeIn(200);
			}
		}		
		else
		{	
			for ( i = 0; i < <?php echo $j;?>; i++ )
			{ 
				$('#station' + i).hide();
			}
		}
			
	});

	// update labels when window is resized
	$( window ).resize(function(event,ranges) {
		updateLabels(plot, stationData, stations);
		});

	// update labels when alerts are closed
	if($('#alert'))
	{
		$('#alert').on('closed.bs.alert', function () {
			updateLabels(plot, stationData, stations);
		})
	}

	// show and hide maxspeed overview
	$('#show_overview').change(function() 
	{
		if ( $('#show_overview:checked').length > 0 )
		{
				$('#maxspeed_overview').show();
		}		
		else
		{	
			for ( i = 0; i < <?php echo $j;?>; i++ )
			{ 
				$('#maxspeed_overview').hide();
			}
		}
	});

	// show and hide allowed maxspeeds
	$('#show_maxspeed').change(function() 
	{	
		if ( $('#show_maxspeed:checked').length > 0 )
		{
			data = plotdata;
		}					
		else
		{
			data = plotdata_nm;
		}
		if(global_ranges)
		{
			$.plot("#maxspeed", data, 
					$.extend(true, {}, options, 
							{
								xaxis: { min: global_ranges.xaxis.from, max: global_ranges.xaxis.to },
								yaxis: { min: global_ranges.yaxis.from, max: global_ranges.yaxis.to }
							})
					);
		}
		else
		{
			$.plot("#maxspeed", data, options);
		}
	});
	
	// Add the Flot version string 
	$("#flotversion").prepend('powered by <a href="http://www.flotcharts.org/">Flot ' + $.plot.version + '</a>');
});

</script>

</head>
<body>
<?php top_nav();?>
<div id="header" class="page-header">
	<div class="container">
		<header>
<h2> <?php echo Route::showRef($this->relation_tags["ref"], $this->relation_tags["route"], $this->relation_tags["service"], $this->relation_tags["colour"], $this->relation_tags["text_colour"]) . " " . Route::showfromviato($this->relation_tags["to"], $this->relation_tags["from"], $this->relation_tags["via"]);?></h2>
				</header>
	</div>
</div>
<div class="container-fluid panel-group">
<?php 
if ( isset($this->refresh_success) && $this->refresh_success == false )
{
	?>
	<div class="alert alert-danger alert-dismissable fade in" role="alert" id="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Error:</span>
		<?php echo Lang::l_("Route Data could not be updated from Overpass API.")?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?php 
} 
elseif ( isset($this->refresh_success) && $this->refresh_success == true )
{
	?>
	<div class="alert alert-success alert-dismissable fade in" role="alert" id="alert">
		<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
		<span class="sr-only">Success:</span>
		<?php echo Lang::l_("Route Data was successfully updated from Overpass API.")?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?php 
}
 
if (  $this->relation_distance == 0 )
{
	?>
	<div class="alert alert-warning alert-dismissable fade in" role="alert" id="alert_noways">
		<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
		<span class="sr-only">Warning:</span>
		<?php echo Lang::l_("We couldn't find any ways for this route. Please check the OpenStreetMap data for errors.")?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?php 
}
?>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo Lang::l_('Route Details');?>:</h4>
		</div>
		<div class="panel-body">
		<?php 
		if ( isset($this->relation_tags["operator"]) ) //check if operator is known
		{
			?>	
			<div class="col-md-6"><b><?php echo Lang::l_("Operator:");?></b> <?php echo $this->relation_tags["operator"];?></div>
			<?php 
		}
		else
		{
			//set operator value for database input
			$this->relation_tags["operator"]="";
		}
		if ( $this->relation_distance > 10 )
		{
			$relation_distance_show = round($this->relation_distance, 1);
		}
		else
		{
			$relation_distance_show = round($this->relation_distance, 2);
		}

		//calculate travel time
		$travel_time = 0;
		if($this->real_average_speed > 0)
		{
			$travel_time = ( $this->relation_distance * $this->relation_distance / $this->real_average_speed ) * 60;
		}
		//calculate average speed	
		$average_speed = 0;
		if($this->relation_distance > 0)
		{
			$average_speed = $this->real_average_speed / $this->relation_distance;
		}
		//calculate speed_coverage	
		$speed_coverage = 0;
		if($this->relation_distance > 0)
		{
			$speed_coverage = $maxspeed_known / $this->relation_distance;
		}	
		?>
			<div class="col-md-6"><b><?php echo Lang::l_('Train Type');?>:</b> <?php echo $route_type;?></div> 
			<div class="col-md-6"><b><?php echo Lang::l_('Route Length');?>:</b> <?php echo $relation_distance_show;?> km</div> 
			<div class="col-md-6"><b><?php echo Lang::l_('Travel Time');?>:</b> <?php echo round($travel_time);?> min</div> 
			<div class="col-md-6"><b><?php echo Lang::l_('Average Speed');?>:</b> <?php echo round($average_speed);?> km/h</div>
			<div class="col-md-6"><b><?php echo Lang::l_('Maximum Speed');?>:</b> <?php echo $this->maxspeed_max;?> km/h</div>
			<div class="col-md-6"><b><?php echo Lang::l_('Known speed limits in OSM database');?>:</b> <?php echo round($speed_coverage*100,1);?> %</div>
		</div>
	</div>
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo Lang::l_('Speed Profile');?>:</h4>
		</div>
		<div class="panel-body">
			<div style="position:relative" style="height:300px;width:100%;max-height:20%;">
				<div class="table-responsive">
					<div id="maxspeed" style="height:300px;width:100%;min-width:600px"></div>
				</div>
				<div id="maxspeed_overview"></div>
			</div>
			<small id="flotversion"></small>
			<div class="btn-group hidden-xs">
				<span class="input-group-addon">
				<input type="checkbox" id="maxspeed_labels" checked="checked" aria-label="..."/>
				</span>
				<label for="maxspeed_labels" class="input-group-addon"><?php echo Lang::l_('Show Stop Names');?></label>
			</div>
			<div class="btn-group hidden-xs">
				<span class="input-group-addon">
				<input type="checkbox" id="show_overview" checked="checked" aria-label="..."/>
				</span>
				<label for="show_overview" class="input-group-addon"><?php echo Lang::l_('Show Overview');?></label>
			</div>
			<div class="btn-group hidden-xs">
				<span class="input-group-addon">
				<input type="checkbox" id="show_maxspeed" checked="checked" aria-label="..."/>
				</span>
				<label for="show_maxspeed" class="input-group-addon"><?php echo Lang::l_('Show Allowed Maxspeed');?></label>
			</div>
			<div class="row"><small class="col-md-12"><b><?php echo Lang::l_('Please note');?>:</b> <?php echo Lang::l_('note_maxspeed');?></small></div>
		</div>
	</div>
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo Lang::l_('Railway details');?>:</h4>
		</div>
		<div class="panel-body">
			<div class="col-md-12"><b><?php echo Lang::l_('Railway Operators');?>:</b> <?php echo $operator_string;?></div>
			<div class="col-md-12"><b><?php echo Lang::l_('Railway Users');?>:</b> <?php echo $trafficmode_string;?></div>
			<div class="col-md-12"><b><?php echo Lang::l_('Electrification');?>:</b> <?php echo $electrified_string;?></div>
			<div class="col-md-12"><b><?php echo Lang::l_('Structures');?>:</b> <?php echo $building_string;?></div>
			<div class="col-md-12"><b><?php echo Lang::l_('Gaps in Route');?>:</b> 
		<?php 
		if( $this->count_holes > 0 )
		{
			?>
			<span class="text-danger"><?php echo $this->count_holes; ?></span> (<a href="http://ra.osmsurround.org/analyzeRelation?relationId=<?php echo $this->id; ?>&noCache=true&_noCache=on" title="<?php echo Lang::l_('Analyze route with OSM Relation Analyzer'); ?>"><?php echo Lang::l_('Analyze route'); ?></a>)</span>
			<?php  
		}
		else
		{
			?>
			<span class="text-success"><?php echo $this->count_holes; ?></span>
			<?php 
		}
		?>	
			</div>
		</div>
	</div>
	
	<div class="panel panel-primary">
		<div class="panel-heading" data-toggle="collapse" aria-expanded="false" aria-controls="signalsTab" role="tab">
			<h4 class="panel-title"><a data-toggle="collapse" href="#signalsTab" aria-expanded="false" aria-controls="signalsTab">
			<?php echo Lang::l_('Signals on Route');?>:
			</a></h4>
		</div>
		<div class="panel-body collapse" id="signalsTab">
		<?php Signals::analyseSignals($this->signals_array, $this->node, $this->maxspeed_array);?>
			<table class="table table-striped">
			<tr>
				<th><?php echo Lang::l_("Position")?></th>
				<th><?php echo Lang::l_("Image")?></th>
				<th><?php echo Lang::l_("Location")?></th>
				<th><?php echo Lang::l_("Description")?></th>
				<th><?php echo Lang::l_("Distance to main signal")?></th>
				<th><?php echo Lang::l_("Distance between main signals")?></th>
				<th><?php echo Lang::l_("Show on map")?></th>
			</tr>
		<?php
		foreach ($this->signals_array as $signals)
		{
			$signal = Signals::getSignal($signals[1], $this->node[$signals[1]], $this->maxspeed_array, $signals[0]);
			if($signal)
			{
				echo $signal;
			}	
		}
		?>
			</table>
		</div>
	</div>
	
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo Lang::l_('Map of Route and Stops');?>:</h4>
		</div>
		<div class="panel-body">
		<?php 
		$this->getStopNames();
		$this->showMap();
		?>
			<div class="col-lg-6">
				<ul class="stations">
		<?php
		if ( isset($this->relation_stops[0]) )
		{
			//go through all stations
			foreach ( $this->relation_stops as $nr => $ref )
			{
				/* get class that should be used */
				$class = "default";
				if ( $nr == 0)
				{
					$class = "first";
				}
				elseif ( !isset($this->relation_stops[$nr + 1]) )
				{
					$class = "last";
				}
				
				// show stops 
				echo '<li class="'.$class.'"><span><a href="#map" onClick="railway_stops[' . $nr . '].openPopup();" onMouseOver="railway_stops[' . $nr . '].togglePopup();">' . $this->stop_name[$nr] . '</a></span></li>';
			}
		}
		else
		{
			?>
					<li><?php echo Lang::l_('N/A');?></li>
			<?php 
		}
		?>
	
				</ul>
			</div>
		</div>
	</div>
	
		<?php
		//connect to database
		$con = connectToDB();

		if( !$this->custom )
		{
			// add route to database
			$query = "SELECT id FROM osm_train_details WHERE id=" . @$con->real_escape_string($this->id);
			$result = @$con->query($query) or log_error(@$con->error);
			while ( $row = @$result->fetch_array() )
			{
				$mysql_id = $row["id"];
			}
			if ( isset($mysql_id) && $mysql_id == $this->id )
			{
				if ( $this->relation_distance > 0 ) //only update when route includes ways
				{
					$query2 = "UPDATE osm_train_details SET id=" . @$con->real_escape_string($this->id) . ", ref='" . @$con->real_escape_string($this->relation_tags["ref"]) . "', ref_colour='" . @$con->real_escape_string($this->relation_tags["colour"]) . "', ref_textcolour='" . @$con->real_escape_string($this->relation_tags["text_colour"]) . "', `from`='" . @$con->real_escape_string($this->relation_tags["from"]) . "', `to`='" . @$con->real_escape_string($this->relation_tags["to"]) . "', operator='" . @$con->real_escape_string($this->relation_tags["operator"]) . "', route='" . @$con->real_escape_string($this->relation_tags["route"]) . "', service='" . @$con->real_escape_string($this->relation_tags["service"]) . "', length='" . @$con->real_escape_string($this->relation_distance) . "', time='" . @$con->real_escape_string($travel_time) . "', ave_speed='" . @$con->real_escape_string($average_speed) . "',max_speed='" . @$con->real_escape_string($this->maxspeed_max) . "', date='" . @$con->real_escape_string($this->filemtime) . "' WHERE id=" . @$con->real_escape_string($this->id) . ";";
				}
				else // delete otherwise
				{
					$query2 = "DELETE FROM osm_train_details WHERE id=" . @$con->real_escape_string($this->id) . ";";
				}
				@$con->query($query2) or log_error(@$con->error);
			}
			else
			{
				if ( $this->relation_distance > 0 ) //only add when route includes ways
				{
					$query2 = "INSERT INTO osm_train_details VALUES( '" . @$con->real_escape_string($this->id) . "','" . @$con->real_escape_string($this->relation_tags["ref"]). "','" . @$con->real_escape_string($this->relation_tags["colour"]) . "','" . @$con->real_escape_string($this->relation_tags["text_colour"]) . "','" . @$con->real_escape_string($this->relation_tags["from"]) . "','" . @$con->real_escape_string($this->relation_tags["to"]) . "', '" . @$con->real_escape_string($this->relation_tags["operator"]) . "', '" . @$con->real_escape_string($this->relation_tags["route"]) . "', '" . @$con->real_escape_string($this->relation_tags["service"]) . "','" . @$con->real_escape_string($this->relation_distance) . "','" . @$con->real_escape_string($travel_time) . "', '" . @$con->real_escape_string($average_speed) . "','" . @$con->real_escape_string($this->maxspeed_max) . "','" . @$con->real_escape_string($this->train->ref) . "','" . @$con->real_escape_string($this->filemtime) . "');";
					@$con->query($query2) or log_error(@$con->error);
	
					Train::setDefaultTrain($this->train->ref, $this->id, $this->relation_tags["service"], $this->relation_tags["route"], true);
				}
			}
		}
		?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo Lang::l_('Train details');?>:</h4>
		</div>
		<div class="panel-body">
			<form action="index.php" method="get" class="form-inline" id="train_form">
				<input type="hidden" name="id" value="<?php echo $this->id;?>">
				<input type="hidden" name="service" value="<?php echo $this->relation_tags["service"];?>">
				<input type="hidden" name="route" value="<?php echo $this->relation_tags["route"];?>">
		<?php 
		//show image for train if available
		if(isset($this->train->image))
		{
			?>
			<div class="col-md-12"><img src="img/trains/<?php echo $this->train->image?>" style="max-height: 50px;max-width: 100%" alt="<?php echo Lang::l_("Train Image");?>"></div>
			<?php 
		}
		?>
			<div class="col-md-4"><b><?php echo Lang::l_('Train name');?>:</b> <?php echo $this->train->name;?></div>
			<div class="col-md-4"><b><?php echo Lang::l_('Train type');?>:</b> <?php echo Lang::l_(Train::$train_type[$this->train->type]);?></div>
			<div class="col-md-4"><b><?php echo Lang::l_('Maximum speed');?>: </b><?php echo $this->train->maxspeed;?> km/h</div>
			<div class="col-md-4"><b><?php echo Lang::l_('Weight empty');?>:</b> <?php echo $this->train->mass_empty / 12960;?> t</div>
			<div class="col-md-4"><b><?php echo Lang::l_('Power');?>:</b> <?php echo $this->train->power / 12960;?> kW</div>
			<div class="col-md-4"><b><?php echo Lang::l_('Maximum torque');?>:</b> <?php echo $this->train->torque / 12960;?> Nm</div>
			<div class="col-md-4"><b><?php echo Lang::l_('Maximum brake');?>:</b> <?php echo $this->train->brake / 12960;?> m/s²</div>
			<div class="col-md-4"><b><?php echo Lang::l_('Length');?>:</b> <?php echo $this->train->length * 1000;?> m</div>
			<div class="col-md-4"><b><?php echo Lang::l_('Seats');?>:</b> <?php echo $this->train->seats;?></div>

		<?php
		$default_train = false;
		$train_def = Train::getDefaultTrain($this->id);
		if ( $train_def == $this->train->ref )
		{
			$default_train = true;
		}
		
		if($default_train == true)
		{
			$train_icon = "star";
			$train_text = Lang::l_('Set as Default');
			$btn = "btn-info disabled";
			$disabled = " disabled=\"disabled\"";
		}
		else
		{
			$train_icon = "star-empty";
			$btn = "btn-default";
			$train_text = Lang::l_('Set ') . $this->train->name . Lang::l_(' as Default');
			$disabled = "";
		}
		?>
			
			<div class="col-md-12"> 
				<div class="form-group">
					<div>
						<label for="train"><?php echo Lang::l_('Change train');?>:</label> 
						<?php echo Train::changeTrain($this->train->ref, $train_def);?>
					</div>
					<div>
						<input type="checkbox" id="train_default"<?php echo $disabled;?> class="sr-only">
    					<span id="text_default_train" class="hidden" aria-hidden="true"><?php echo Lang::l_('Set as Default');?></span>
    					<span id="text_not_default_change_train1" class="hidden" aria-hidden="true"><?php echo Lang::l_('Change train and set ');?></span>
    					<span id="text_not_default_train1" class="hidden" aria-hidden="true"><?php echo Lang::l_('Set ');?></span>
    					<span id="text_not_default_train2" class="hidden" aria-hidden="true"><?php echo Lang::l_(' as Default');?></span>
    					<span id="text_default_error" class="hidden" aria-hidden="true"><?php echo Lang::l_('Can\'t set as Default');?></span>
    					<span id="text_default_loading" class="hidden" aria-hidden="true"><?php echo Lang::l_('Loading...');?></span>
	    				
    					<div class="btn-group" role="group" id="train_default_group">
    						<div class="btn <?php echo $btn;?> btn-sm">
	    						<label for="train_default">
	    						<span id="train_icon" class="glyphicon glyphicon-<?php echo $train_icon;?>" aria-hidden="true"></span>
	    						</label>
	    					</div>
	    					<div class="btn <?php echo $btn;?> btn-sm" title="<?php echo Lang::l_('Click button to change.');?>">
	    						<label for="train_default" id="train_default_text">
	    						<?php echo $train_text;?>
	    						</label>
	    					</div>
	    					<button id="train_submit" class="btn btn-default btn-sm" type="submit" disabled="disabled"><?php echo Lang::l_('Change train');?></button>
    					</div>
    				</div>
    			</div>		
    		</div>
			</form>
		</div>
	</div>
</div>
</div>
    <nav class="navbar" id=footer>
		<div class="container">
			<small><strong><?php echo Lang::l_('Data date');?>:</strong> <?php echo  date ("F d Y H:i:s", $this->filemtime);?> (<a href="?id=<?php echo $this->id?>&train=<?php echo $this->train->ref?>&rf=1" title="<?php echo Lang::l_('Update data');?>"><?php echo Lang::l_('Update data');?></a>) | <?php echo Lang::l_('Route Data');?> © <a href="http://www.openstreetmap.org/copyright" title="OpenStreetMap <?php echo Lang::l_('licence');?>">OpenStreetMap</a><?php echo Lang::l_(' contributors');?> | <a id="josmLink" href="http://127.0.0.1:8111/load_object?objects=r<?php echo $this->id;?>&relation_members=true" data-editor="remote"><?php echo Lang::l_('Load relation in JOSM');?></a></small>
			<div class="navbar-right">
<?php 
/** Flattr-Button, feel free to add your own flattr username or delete it **/
?>
<script id='fbcr6gj'>(function(i){var f,s=document.getElementById(i);f=document.createElement('iframe');f.src='//api.flattr.com/button/view/?uid=sb89&button=compact&url='+encodeURIComponent(document.URL);f.title='Flattr';f.height=20;f.width=110;f.style.borderWidth=0;s.parentNode.insertBefore(f,s);})('fbcr6gj');</script>

<?php 
/** Github-Button, feel free to add your own github repository or delete it **/
?>       
<!-- Place this tag where you want the button to render. -->
<a data-count-api="/repos/sb12/OSMTrainRouteAnalysis#stargazers_count" data-count-href="/sb12/OSMTrainRouteAnalysis/stargazers" data-icon="octicon-star" href="https://github.com/sb12/OSMTrainRouteAnalysis" class="github-button">Star</a> 
 
			</div>
		</div>
	</nav>
</div>
<div class="" role="tooltip" id="tooltip_wrapper" style="display:none;position:absolute">
	<div class="tooltip-arrow" id="tooltip_arrow"></div>
	<div id='tooltip' class='tooltip-inner'></div>
</div>

<div class="modal fade" id="josmErrorDialog" tabindex="-1" role="dialog" aria-labelledby="aboutLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<p id="josmError" class="text-danger"><?php echo Lang::l_('Loading relation to the editor failed - make sure JOSM or Merkaartor is loaded and the remote control option is enabled.');?></p>
	        </div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
		</div>
	</div>
</div>
<!-- Place this tag right after the last button or just before your close body tag. -->
<script async defer id="github-bjs" src="https://buttons.github.io/buttons.js"></script>
		<?php 
	}
	
	/**
	 * calculates speeds for maxspeed matrix
	 */
	function calculateSpeed()
	{
		$max_before = 0;
		$this->maxspeed_array[-1] = Array(0, 0, true);

		//handle stops and add them to maxspeed matrix
		if ( isset($this->relation_stops) )
		{
			// get position of stops on the way
			$i = 0;
			foreach ( $this->relation_stops as $nr => $ref )
			{
				if ( $this->relation_stops_type[$nr] == "n" )
				{
					// node is not on way
					if ( !isset($this->stop_node_distance[$ref]) )
					{
						$old_ref = $ref;
						
						// try to find nearest node on way 
						// FIXME: only works for nodes
						$ref = $this->get_nearest_node($ref);

						if(!$ref) //use old ref in case no node was found
						{
							$ref = $old_ref;
						}
						// add new ref and move name and description to new ref
						$this->relation_stops[$nr] = $ref;
						if ( isset($this->node[$old_ref]["ref_name"]) )
						{
							$this->node[$ref]["ref_name"] = $this->node[$old_ref]["ref_name"];
						}
						if ( isset($this->node[$old_ref]["name"]) )
						{
							$this->node[$ref]["name"] = $this->node[$old_ref]["name"];
						}
						if ( isset($this->node[$old_ref]["description"]) )
						{
							$this->node[$ref]["description"] = $this->node[$old_ref]["description"];
						}
					}
	
					if ( isset($this->stop_node_distance[$ref]) )
					{
						if ( isset($this->node[$ref]["lat"]) )
						{
							$this->stop_position[$i]["lat"] = $this->node[$ref]["lat"];
							$this->stop_position[$i]["lon"] = $this->node[$ref]["lon"];
						}
						$this->stop_position[$i]["dis"] = $this->stop_node_distance[$ref];
						$this->stop_position[$i]["ref"] = $ref;
						$i++;
					}
				}
				elseif ( $this->relation_stops_type[$nr] == "w" )
				{
					$old_ref = $ref;
					
					// try to find nearest node on way
					$ref = $this->get_nearest_node($this->way_nodes[$ref][0]);

					if(!$ref) //use old ref in case no node was found
					{
						$ref = $this->way_nodes[$old_ref][0];
					}
	
					// add new ref and move name and description to new ref
					$this->relation_stops[$nr] = $ref;
					if ( isset($this->way_tags[$old_ref]["ref_name"]) )
					{
						$this->node[$ref]["ref_name"] = $this->way_tags[$old_ref]["ref_name"];
					}
					if ( isset($this->way_tags[$old_ref]["name"]) )
					{
						$this->node[$ref]["name"] = $this->way_tags[$old_ref]["name"];
					}
					if ( isset($this->way_tags[$old_ref]["description"]) )
					{
						$this->node[$ref]["description"] = $this->way_tags[$old_ref]["description"];
					}
					
					$this->relation_stops_type[$nr] = "n";
	
					if ( isset($this->stop_node_distance[$ref]) )
					{
						if ( isset($this->node[$ref]["lat"]) )
						{
							$this->stop_position[$i]["lat"] = $this->node[$ref]["lat"];
							$this->stop_position[$i]["lon"] = $this->node[$ref]["lon"];
						}
						$this->stop_position[$i]["dis"] = $this->stop_node_distance[$ref];
						$this->stop_position[$i]["ref"] = $ref;
						$i++;
					}
				}
					
			}

			//sort stops in array
			if ( isset($this->stop_position) )
			{
				foreach ( $this->stop_position as $key => $row ) 
				{
					$dis[$key] = $row['dis'];
					$lat[$key] = $row['lat'];
					$lon[$key] = $row['lon'];
				}
				array_multisort($dis, SORT_ASC, $this->stop_position);
			}
		}
		
		//enter stops into speed matrix
		$i = 0;
		while ( isset($this->stop_position[$i]["dis"]) )
		{
			if ( isset($this->stop_position[$i]["dis"]) && $i > 0 )
			{
				$this->way_length[$i] = $this->stop_position[$i]["dis"] - $this->stop_position[$i-1]["dis"];
				$s = $this->way_length[$i];
				$a = ( $this->train->brake * 12960 + $this->train->acceleration($this->train->mass_empty, $this->train->torque, $this->train->power, 200, 0, 200) ) / 2;
				$maxspeed_stops[$i] = sqrt ( $a * $s * 2 ) / 4;
			}
			$i++;
		}
		
		$i = $j = -1;
		$k = 0;
		$this->relation_distance_ms = 0;//way of relation up to this point

		//go through all maxspeed sections
		while ( isset($this->maxspeed_array[$i]) )
		{
			$stop = false;
			$way_remaining = $this->maxspeed_array[$i][0]; //distance of whole way
			$maxspeed_this = $this->maxspeed_array[$i][1]; //maxspeed before

			
			$k = 0;
			//go through all stations
			while ( isset($this->stop_position[$k]) )  
			{

				//there's a stop in this section
				if ( isset($this->stop_position[$k]["dis"]) && $this->stop_position[$k]["dis"] > $this->relation_distance_ms && $this->stop_position[$k]["dis"] <= ( $this->relation_distance_ms + $this->maxspeed_array[$i][0] ) )
				{
					//Section before stop (be careful when more than one stop is in the same section!
					$exmaxarray[$j][0] = $this->stop_position[$k]["dis"] - $this->relation_distance_ms - ( $this->maxspeed_array[$i][0] - $way_remaining );
					$exmaxarray[$j][1] = $maxspeed_this;
					$exmaxarray[$j][2] = $this->maxspeed_array[$i][2];
					$j++;
					
					//Stop (0 km/h, length 0)
					$exmaxarray[$j][0] = 0;
					$exmaxarray[$j][1] = 0;
					$exmaxarray[$j][2] = true;
					$j++;
					
					//remaining part of section
					$way_remaining = $way_remaining - $exmaxarray[$j-2][0];
					
					//remove negative numbers due to rounding
					$way_remaining = max(0, $way_remaining);

				}
				$k++;
			}
			
			//section for remaining part of old section (original value, when no stop)
			if ( $way_remaining >= 0 )
			{
				$exmaxarray[$j][0] = $way_remaining;
				$exmaxarray[$j][1] = $maxspeed_this;
				$exmaxarray[$j][2] = $this->maxspeed_array[$i][2];
				$j++;
			}
			
			//update relation distance
			$this->relation_distance_ms += $this->maxspeed_array[$i][0];
			$i++;				
		}
		
		//get points where train has to start braking/accelerating
		$brake_array = $this->getBrakingPoints($exmaxarray, $this->train);
		$acc_array = $this->getAccelerationPoints($exmaxarray, $this->train);
		$i = 0;
		$way_total = 0;
		$brake = false;
		
		//copy maxarray into temporary array
		while ( isset($exmaxarray[$i]) )
		{
			$savemaxarray[$i] = $exmaxarray[$i];
			if ( $exmaxarray[$i][0] < 0 )
			{
				log_error("WARNING: negative Way. Relation ID: " . $this->id . " | Maxspeed array position: " . $i);
			}
			$i++;
		}
		
		//merge acceleration and braking points
		if($brake_array && $acc_array)
		{
			$accbrake_array = array_merge($brake_array, $acc_array);
		}
		else
		{
			$accbrake_array[] = Array(0,0,0,0,"error");
			log_error("WARNING: Empty Acceleration and Brake Array. Relation ID: " . $this->id );
		}
		
		
		//sort accbrake array as long as there are still improvements		
		$accbrake_array_old = Array();
		while ( $accbrake_array_old != $accbrake_array )
		{	
			$accbrake_array_old = $accbrake_array;
			$accbrake_array = $this->sort_accbrake($accbrake_array);
		}
		
		//create maxpoint array for rendering later
		$maxspeed_point_array = Array();
		for ( $i = 0; isset($accbrake_array[$i]); $i++ )
		{		
			$maxspeed_point_array[] = Array($accbrake_array[$i][0], $accbrake_array[$i][2]);
			$maxspeed_point_array[] = Array($accbrake_array[$i][1], $accbrake_array[$i][3]);
		}
		$this->maxspeed_point_array = $maxspeed_point_array;
		$this->getAverageSpeed();
	}
	
	/** 
	 * gets average and maximal speed
	 */
	function getAverageSpeed()
	{ 
		 $this->maxspeed_max = 0;
         $this->real_average_speed = 0;
         $this->maxspeed_point_array[-1] = $this->maxspeed_point_array[0];
         for ( $i = 0; isset($this->maxspeed_point_array[$i]); $i++ )
         {
         	$this->real_average_speed += ( $this->maxspeed_point_array[$i][0] - $this->maxspeed_point_array[$i-1][0] ) * ( $this->maxspeed_point_array[$i-1][1] + $this->maxspeed_point_array[$i][1] ) / 2;
         	
         	if ( $this->maxspeed_max < $this->maxspeed_point_array[$i][1] )
         	{
         		$this->maxspeed_max = $this->maxspeed_point_array[$i][1];
         	} 
         }
	}
	/**
	 * gets position of Braking points
	 * 
	 * @param Array $exmaxarray maxspeed matrix
	 * @param Train $train used train
	 * @return multitype:number NULL string braking point matrix
	 */
	function getBrakingPoints($exmaxarray, $train)
	{
		$brake_train = $train->brake;
		$i = 0;
		$maxpoint = 0;
		$way_total = 0;
		//go through each point of maxspeed matrix
		while ( isset($exmaxarray[$i]) )
		{
			$way = 0;
			//find all places where maxspeed is lower than before
			for ( $j = $i - 1; $j >= -1; $j-- )
			{
				$way += $exmaxarray[$j][0];
				if ( $exmaxarray[$j][1] > $exmaxarray[$i][1] && $way_total > $maxpoint )
				{
					//calculate braking distance
					$way_brake = ( $exmaxarray[$j][1] * $exmaxarray[$j][1] - $exmaxarray[$i][1] * $exmaxarray[$i][1] ) / ( 2 * $brake_train );
					//braking starts in current section
					if ( $way_brake < $way )
					{
						//found braking point
						$brake_array[] = Array($way_total - $way_brake, $way_total, $exmaxarray[$j][1], $exmaxarray[$i][1], "brake");
						$maxpoint = $way_total - $way_brake;
						break;
					}
					// braking starts in section before and we are between two stops
					elseif ( $exmaxarray[$i][1] == 0  && $exmaxarray[$j-1][1] == 0)
					{
						//found braking point
						$brake_array[] = Array($way_total - $way, $way_total, $exmaxarray[$i][1] - ( $exmaxarray[$i][1] - $exmaxarray[$j][1] ) * $way / $way_brake, $exmaxarray[$i][1], "brake");
						$maxpoint = $way_total - $way;
						break;
					}
				}
				else
				{
					break;
				}
			}
			$way_total += $exmaxarray[$i][0];
			$i++;
		}
		
		if(isset($brake_array))
		{
			return $brake_array;
		}
	}
	
	/**
	 * get position of accerlation points
	 * 
	 * @param array $exmaxarray maxspeed array
	 * @param Train $train used train
	 * @return multitype:number NULL string acceleration point matrix
	 */
	function getAccelerationPoints($exmaxarray, $train)
	{
		$tr_mass_empty = $train->mass_empty;
		$tr_torque = $train->torque;
		$tr_power = $train->power;
		$i = -1;
		$way_total = 0;
		$maxpoint = 0;
		
		//go through each point of maxspeed matrix
		while ( isset($exmaxarray[$i]) )
		{
			$way = 0;
			$way_total += $exmaxarray[$i][0];
			//find all places where maxspeed is higher than before
			for ( $j = $i + 1; isset($exmaxarray[$j]); $j++ )
			{
				$way += $exmaxarray[$j][0];
				//maxspeed is higher and is not already in a acceleration section
				if ( $exmaxarray[$j][1] > $exmaxarray[$i][1] && $way_total >= $maxpoint )
				{
					//calculate acceleration:
					$acceleration = $train->acceleration($tr_mass_empty, $tr_torque, $tr_power, 200, $exmaxarray[$i][1], $exmaxarray[$j][1]);
					//calculate acceleration distance
					$way_acc = ( $exmaxarray[$j][1] * $exmaxarray[$j][1] - $exmaxarray[$i][1] * $exmaxarray[$i][1] ) / ( 2 * $acceleration ); 
					//acceleration finishes in this section
					if ( $way_acc <= $way )
					{
						//found acceleration point
						$acc_array[] = Array($way_total, $way_total + $way_acc, $exmaxarray[$i][1], $exmaxarray[$j][1], "acc");
						$maxpoint = $way_total + $way_acc;
						break;
					}
					// acceleration does not finish in this section and we are between two stops
					elseif ( $exmaxarray[$i][1] == 0 && $exmaxarray[$j+1][1] == 0)
					{
						//found braking point
						$acc_array[] = Array($way_total, $way_total + $way, $exmaxarray[$i][1], $exmaxarray[$i][1] + ( $exmaxarray[$j][1] - $exmaxarray[$i][1] ) * $way / $way_acc, "acc");
						$maxpoint = $way_total + $way;
						break;
					}
				}
				else
				{
					break;
				}
			}
			$i++;
		}
		
		if(isset($acc_array))
		{
			return $acc_array;
		}
	}
	/**
	 * Recalculates an acceleration way s2 for a speed change v2, when s1 for v1 is known
	 * @param number $s2
	 * @param number $v1
	 * @param number $v2
	 * @return number s2
	 */
	function ReCalculateS1($s2, $v1, $v2)
	{
		$s1 = $s2 * $v1 / $v2;
		return $s1;
	}

	/**
	 * calculates the distance between two point lat1/lon1 and lat2/lon2
	 * @param unknown $lat1
	 * @param unknown $lon1
	 * @param unknown $lat2
	 * @param unknown $lon2
	 * @return number
	 */
	function getDistance($lat1, $lon1, $lat2, $lon2)
	{
		$diflat = ( $lat1 - $lat2 ) * 111.12;
		$diflon = ( $lon1 - $lon2 ) * cos(deg2rad( ( $lat1 + $lat2 ) / 2 )) * 111.12;
		$dis = sqrt( ( $diflat * $diflat ) + ( $diflon * $diflon ) );
		return $dis;
	}
	
	/**
	 * sorts the accbrake array and deletes impossible accelerations/brakes
	 * @param unknown $accbrake_array
	 * @return number
	 */
	function sort_accbrake($accbrake_array)
	{

		//sort array after the start points of the accelerations and brakes
		foreach ( $accbrake_array as $key => $row ) 
		{
			$start[$key]    = $row[0];
			$stop[$key]     = $row[1];
			$vstart[$key]   = $row[2];
			$vstop[$key]    = $row[3];
			$type[$key]     = $row[4];
		}		
		array_multisort($start, SORT_ASC, $accbrake_array);

		//go through array
		$j=0;
		for ( $i = 0; isset($accbrake_array[$i+1]); $i++ )
		{
			//train breaks without accelerating before (next speed is bigger than current speed)
			if ( $accbrake_array[$i + 1][2] > $accbrake_array[$i][3] )
			{
				//Special case: train is stopped
				if ( $accbrake_array[$i][3] == 0 )
				{
					//TODO: do we need to do anything here?
				}
				else
				{
					//set start speed of next one to end speed of current
					$accbrake_array[$i + 1][2] = $accbrake_array[$i][3];
				}
			}
				
			//train accelerates without breaking after (next speed is smaller than current speed)
			if ( $accbrake_array[$i + 1][2] < $accbrake_array[$i][3]  && $accbrake_array[$i][4] == "acc" && $accbrake_array[$i + 1][4] == "brake")
			{
				//skip acceleration and delete array if possible
				if ( $accbrake_array[$i][2] == $accbrake_array[$i + 1][2] )
				{
					$accbrake_array[$i][0] = 0;
					$accbrake_array[$i][1] = 0;
					$accbrake_array[$i][2] = 0;
					$accbrake_array[$i][3] = 0;
				}
				// or recalculate acceleration
				elseif ( $accbrake_array[$i][2] < $accbrake_array[$i + 1][2] )
				{
					$acceleration = $this->train->acceleration($this->train->mass_empty, $this->train->torque, $this->train->power, 200, $accbrake_array[$i][2], $accbrake_array[$i + 1][2]);
					$way_acc = ( $accbrake_array[$i + 1][2] * $accbrake_array[$i + 1][2] - $accbrake_array[$i][2] * $accbrake_array[$i][2] ) / ( 2 * $acceleration );
					$accbrake_array[$i][0] = $accbrake_array[$i][0];
					$accbrake_array[$i][1] = $accbrake_array[$i][0] + $way_acc;
					$accbrake_array[$i][2] = $accbrake_array[$i][2];
					$accbrake_array[$i][3] = $accbrake_array[$i + 1][2];
				}
				else
				{
					log_error("WARNING: Train accelerates without breaking after. Relation ID: " . $this->id . " | Maxspeed array position: " . $i);
				}
			}
			
			//two accelerations with different in-between speeds and no braking (next speed is smaller than current speed)
			if ( $accbrake_array[$i + 1][2] < $accbrake_array[$i][3] && $accbrake_array[$i][4] == "acc" && $accbrake_array[$i + 1][4] == "acc")
			{
				//set maxspeed of first acceleration to lower speed
				$accbrake_array[$i][3] = $accbrake_array[$i + 1][2];
				echo "-".$accbrake_array[$i][1]."|".$accbrake_array[$i][2]."|".$accbrake_array[$i][3];
			}
			//two brakings with different in-between speeds and no acceleration (next speed is smaller than current speed)
			if ( $accbrake_array[$i + 1][2] < $accbrake_array[$i][3] && $accbrake_array[$i][4] == "brake" && $accbrake_array[$i + 1][4] == "brake")
			{
				//calculate new braking:
				$way_brake = ( $accbrake_array[$i][2] * $accbrake_array[$i][2] - $accbrake_array[$i + 1][3] * $accbrake_array[$i + 1][3] ) / ( 2 * $this->train->brake );
				$accbrake_array[$i][0] = $accbrake_array[$i + 1][1] - $way_brake;
				$accbrake_array[$i][1] = $accbrake_array[$i + 1][1];
				$accbrake_array[$i][2] = $accbrake_array[$i][2];
				$accbrake_array[$i][3] = $accbrake_array[$i + 1][3];
			
				$accbrake_array[$i + 1][0] = 0;
				$accbrake_array[$i + 1][1] = 0;
				$accbrake_array[$i + 1][2] = 0;
				$accbrake_array[$i + 1][3] = 0;
			}

			//Operation B is within Operation A
			if ( $accbrake_array[$i + 1][0] > $accbrake_array[$i][0] && $accbrake_array[$i + 1][1] < $accbrake_array[$i][1] )
			{
				//delete operation B
				$accbrake_array[$i + 1][0] = 0;
				$accbrake_array[$i + 1][1] = 0;
				$accbrake_array[$i + 1][2] = 0;
				$accbrake_array[$i + 1][3] = 0;
			}
			
			//two operations overlap
			if ( $accbrake_array[$i + 1][0] < $accbrake_array[$i][1] )
			{
				//accelerating before braking
				if ( $accbrake_array[$i + 1][4] == "brake" && $accbrake_array[$i][4] == "acc" )
				{
					//brake speed is same as acceleration speed
					if ( $accbrake_array[$i + 1][3] == $accbrake_array[$i][3] )
					{
						//do not brake
						$accbrake_array[$i + 1][1] = $accbrake_array[$i + 1][0] = $accbrake_array[$i][1];
						$accbrake_array[$i + 1][2] = $accbrake_array[$i + 1][3];
	
					}
					//brake speed is higher than before
					elseif ( $accbrake_array[$i + 1][3] > $accbrake_array[$i][2] )
					{
						//only accelerate to braking speed
						$accbrake_array[$i][3] = $accbrake_array[$i + 1][3];
						$accbrake_array[$i][1] = $accbrake_array[$i + 1][0] = ( $accbrake_array[$i + 1][1] + $accbrake_array[$i][0] ) / 2;
						$accbrake_array[$i + 1][2] = $accbrake_array[$i][3];
					}
					//brake speed is lower than before
					elseif ( $accbrake_array[$i + 1][3] < $accbrake_array[$i][2] && $accbrake_array[$i + 1][3] != $accbrake_array[$i + 1][2] )
					{
						//do not accelerate
						$accbrake_array[$i][1] = $accbrake_array[$i][0];
						$accbrake_array[$i][3] = $accbrake_array[$i][2];
						//recalculate braking way
						$accbrake_array[$i + 1][0] = $accbrake_array[$i + 1][1] - $this->ReCalculateS1($accbrake_array[$i + 1][1] - $accbrake_array[$i + 1][0], $accbrake_array[$i + 1][3] - $accbrake_array[$i][2], $accbrake_array[$i + 1][3] - $accbrake_array[$i + 1][2] );
						//new maxspeed value
						$accbrake_array[$i + 1][2] = $accbrake_array[$i][2];
					}
					//brake speed is same as before
					elseif ( $accbrake_array[$i + 1][3] == $accbrake_array[$i][2] )
					{
						//Special case: train is stopped -> must be accelerated to move
						if ( $accbrake_array[$i][2] == 0 )
						{
							if ( $accbrake_array[$i][3] != 0 && $accbrake_array[$i+1][2] != 0 )
							{
								//calculate new acceleration speed
								while ( $accbrake_array[$i + 1][0] < $accbrake_array[$i][1] )
								{
									//set speed to 80%
									$newSpeed = 0.8 * $accbrake_array[$i][3];
		
									//recalculate acceleration
									$accbrake_array[$i][1] = $accbrake_array[$i][0] + $this->ReCalculateS1($accbrake_array[$i][1] - $accbrake_array[$i][0], $newSpeed, $accbrake_array[$i][3]);
									$accbrake_array[$i][3] = $newSpeed;
		
									//recalculate braking
									$accbrake_array[$i + 1][0] = $accbrake_array[$i + 1][1] - $this->ReCalculateS1($accbrake_array[$i + 1][1] - $accbrake_array[$i + 1][0], $newSpeed, $accbrake_array[$i + 1][2]);
									$accbrake_array[$i + 1][2] = $newSpeed;
								}
							}
						}
						else
						{
							//do not brake or accelerate
							//delete braking
							$accbrake_array[$i + 1][0] = 0;
							$accbrake_array[$i + 1][1] = 0;
							$accbrake_array[$i + 1][2] = 0;
							$accbrake_array[$i + 1][3] = 0;
							//delete acceleration
							$accbrake_array[$i][0] = $accbrake_array[$i][1];
							$accbrake_array[$i][3] = $accbrake_array[$i][2];
						}
					}
	
				}
				//crossing operations
				if ( $accbrake_array[$i + 1][4] == "brake" && $accbrake_array[$i][4] == "brake" )
				{
					//delete braking
					$accbrake_array[$i + 1][0] = $accbrake_array[$i][1];
					$accbrake_array[$i + 1][1] = $accbrake_array[$i][1];
					$accbrake_array[$i + 1][2] = $accbrake_array[$i][3];
					$accbrake_array[$i + 1][3] = $accbrake_array[$i][3];
					
				}
			}

		}
		return $accbrake_array;
	}
	
	/**
	 * adds javascript code to show map 
	 */
	function showMap()
	{
		// only set bounds when bounds are given
		$fitBounds = ".setView([50, 10], 4)";
		if($this->min_lat_bounds)
		{
			$fitBounds = ".fitBounds([[" . $this->min_lat_bounds . ", " . $this->min_lon_bounds . "], [" . $this->max_lat_bounds . ", " . $this->max_lon_bounds . "]])";
		}
		?>
		<div id="map" class="col-lg-6"></div>
		<script type="text/javascript">

		/* define bounds */
		var map = L.map('map', {
			scrollWheelZoom: false
		})<?php echo $fitBounds;?>;

		/* activate scrollWhellZoom after first focus on the map */
		map.once('focus', function() 
		{
			map.scrollWheelZoom.enable(); 
		});
		
		/* define map layers */
		var transport = L.tileLayer('http://{s}.tile.thunderforest.com/transport/{z}/{x}/{y}.png', {
		    attribution: 'Map © <a href="http://www.thunderforest.com/">Thunderforest</a>. Map data <a href="http://www.openstreetmap.org/copyright">© OpenStreetMap contributers, ODbL</a>',
		    maxZoom: 18
		}).addTo(map);
		
		var openstreetmap = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    attribution: 'Map data <a href="http://www.openstreetmap.org/copyright">© OpenStreetMap contributors, ODbL</a>',
		    maxZoom: 19
		});
		
		var stamen_toner = L.tileLayer('http://a.tile.stamen.com/toner/{z}/{x}/{y}.png', {
		    attribution: 'Map tiles by <a href="http://stamen.com/">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Map Data <a href="http://www.openstreetmap.org/copyright">© OpenStreetMap contributors, ODbL</a>',
		    maxZoom: 19
		});

		/* define ORM overlays */
		var orm_standard = L.tileLayer('http://{s}.tiles.openrailwaymap.org/standard/{z}/{x}/{y}.png', {
		    attribution: 'Overlay: <a href="http://www.openrailwaymap.org/">OpenRailwayMap</a> <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		    maxZoom: 19
		});
		var orm_maxspeed = L.tileLayer('http://{s}.tiles.openrailwaymap.org/maxspeed/{z}/{x}/{y}.png', {
		    attribution: 'Overlay: <a href="http://www.openrailwaymap.org/">OpenRailwayMap</a> <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		    maxZoom: 19
		});
		var orm_signals = L.tileLayer('http://{s}.tiles.openrailwaymap.org/signals/{z}/{x}/{y}.png', {
		    attribution: 'Overlay: <a href="http://www.openrailwaymap.org/">OpenRailwayMap</a> <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		    maxZoom: 19
		});

		/* add line for route */
		var latlng = new Array();
				<?php
				$j = -1;
				for ( $i = 0; isset($this->map_node[$i]["lat"]); $i++ )
				{
					//Gap in Route
					if ( $this->map_node[$i]["lat"] == 0 && $this->map_node[$i]["lon"] == 0)
					{
						$j++;
						?>
		latlng[<?php echo $j;?>] = new Array();
						<?php
						$k = 0; 
						continue;
					}
					?>
		latlng[<?php echo $j;?>][<?php echo $k;?>] = L.latLng(<?php echo $this->map_node[$i]["lat"];?>, <?php echo $this->map_node[$i]["lon"];?>);
					<?php 
					$k++;
				}
				?>
		var railway_route = L.multiPolyline(latlng)
		
		/* define icon for railway stations */
		var railwayIcon = L.icon({
		    iconUrl: 'img/station_map.svg',
		    iconSize:     [21, 21], // size of the icon
		    iconAnchor:   [10.5, 10.5], // point of the icon which will correspond to marker's location
		    popupAnchor:  [0, 0] // point from which the popup should open relative to the iconAnchor
		});

		/* add stops */
		var railway_stops = new Array();
		var railway_popups = new Array();
		<?php
		if ( isset($this->relation_stops[0]) )
		{
			$j = 0;
			foreach ( $this->relation_stops as $nr => $ref )
			{
				//$stop_name[$nr]=Lang::l_('Unknown stop');
				if ( $this->relation_stops_type[$nr] == "n" )//only show nodes
				{
					?>
		railway_stops[<?php echo $j;?>] = L.marker([<?php echo $this->node[$ref]["lat"];?>, <?php echo $this->node[$ref]["lon"];?>], {icon: railwayIcon}).bindPopup("<?php echo $this->stop_name[$nr];?>");
		railway_stops[<?php echo $j;?>].on('mouseover', railway_stops[<?php echo $j;?>].togglePopup);
					<?php
					$j++; 
				}
			}	
		}
		?>

		/* define LayerGroups for routes and stops*/
		var layer_route = L.layerGroup([railway_route]).addTo(map);
		var layer_stops = L.layerGroup(railway_stops).addTo(map);

		/* define base maps */
		var baseMaps = {
			    "OpenStreetMap": openstreetmap,
			    "Transport Map": transport,
			    "Stamen Toner": stamen_toner
			};

		/* define overlays */
		var overlayMaps = {
			    "<?php echo Lang::l_('OpenRailwayMap - Infrastructure')?>": orm_standard,
			    "<?php echo Lang::l_('OpenRailwayMap - Speed Limits')?>": orm_maxspeed,
			    "<?php echo Lang::l_('OpenRailwayMap - Rail signals')?>": orm_signals,
			    "<?php echo Lang::l_('Route')?>": layer_route,
			    "<?php echo Lang::l_('Stops')?>": layer_stops
		};
		
		/* add control element to map */
		L.control.layers(baseMaps, overlayMaps).addTo(map);
		</script>
		<?php 
	}

	/**
	 * gets name of stops
	 */
	function getStopNames()
	{
		//stops exist
		if ( isset($this->relation_stops[0]) )
		{
			//go through all stops
			foreach ( $this->relation_stops as $nr => $ref )
			{
				$this->stop_name[$nr] = Lang::l_('Unknown stop');
				if ( $this->relation_stops_type[$nr] == "n" )//nodes
				{
					if ( isset($this->node[$ref]["ref_name"]) )
					{
						$this->stop_name[$nr] = $this->node[$ref]["ref_name"];
					}
					elseif ( isset($this->node[$ref]["name"]) )
					{
						$this->stop_name[$nr] = $this->node[$ref]["name"];
					}
					elseif ( isset($this->node[$ref]["description"]) )
					{
						$this->stop_name[$nr] = $this->node[$ref]["description"];
					}
				}
				elseif ( $this->relation_stops_type[$nr] == "w" )//ways
				{
					if ( isset($this->way_tags[$ref]["name"]) )
					{
						$this->stop_name[$nr] = $this->way_tags[$ref]["name"];
					}
				}
			}	
		}
	}
	
	/**
	 * gets maxspeed for ways without maxspeed tag
	 * 
	 * @param int id way id
	 * 
	 * @return array(average,min,max) 
	 */
	function getMaxspeed($id)
	{
		// tram and subway
		if ( isset($this->way_tags[$id]["railway"]) && ( $this->way_tags[$id]["railway"] == "tram" || $this->way_tags[$id]["railway"] == "subway" ) )
		{
			// service tracks
			if ( isset($this->way_tags[$id]["service"]) )
			{
				$maxspeed = 30;
				$maxspeed_max = 40;
				$maxspeed_min = 15;
			}
			// tracks with train protection system
			elseif (
				( isset($this->way_tags[$id]["railway:pzb"]) && $this->way_tags[$id]["railway:pzb"] == "yes" ) || //Punktförmige Zugbeeinflussung
				( isset($this->way_tags[$id]["railway:lzb"]) && $this->way_tags[$id]["railway:lzb"] == "yes" ) || //Linienzugbeeinflussung
				( isset($this->way_tags[$id]["railway:imu"]) && $this->way_tags[$id]["railway:imu"] == "yes" ) //AVG-IMU
			)
			{
				$maxspeed = 80;
				$maxspeed_max = 90;
				$maxspeed_min = 15;
			}
			// tracks without service tags or train protection system
			else
			{
				$maxspeed = 50;
				$maxspeed_max = 70;
				$maxspeed_min = 15;
			}
		}
		// light rail
		elseif ( isset($this->way_tags[$id]["railway"]) && $this->way_tags[$id]["railway"] == "light_rail" )
		{
			//service ways
			if ( isset($this->way_tags[$id]["service"]) )
			{
				$maxspeed = 30;
				$maxspeed_max = 60;
				$maxspeed_min = 25;
			}
			else
			{
				$maxspeed = 80;
				$maxspeed_max = 120;
				$maxspeed_min = 30;
			}
		}
		// miniature
		elseif ( isset($this->way_tags[$id]["railway"]) && $this->way_tags[$id]["railway"] == "miniature" )
		{
			$maxspeed = 10;
			$maxspeed_max = 30;
			$maxspeed_min = 5;
		} // highspeed lines
		elseif ( isset($this->way_tags[$id]["highspeed"]) && $this->way_tags[$id]["highspeed"] == "yes" )
		{
			$maxspeed = 250;
			$maxspeed_max = 320;
			$maxspeed_min = 200;
		}
		// usage is known
		elseif ( isset($this->way_tags[$id]["usage"]) && ( $this->way_tags[$id]["usage"] == "main" || $this->way_tags[$id]["usage"] == "branch") )
		{
			//main lines
			if ( $this->way_tags[$id]["usage"] == "main" )
			{
				// tracks with high speed train protection system
				if(
					( isset($this->way_tags[$id]["railway:lzb"]) && $this->way_tags[$id]["railway:lzb"] == "yes") || //Linienzugbeeinflussung (Germany)
					( isset($this->way_tags[$id]["railway:etcs"]) && $this->way_tags[$id]["railway:etcs"] != "no") || //European Train Control System
					( isset($this->way_tags[$id]["railway:selcab"]) && $this->way_tags[$id]["railway:selcab"] == "yes") //SELCAB (Spain)
				)
				{
					$maxspeed = 200;
				}
				else
				{
					$maxspeed = 140;
				}
				// not a highspeed line
				if ( isset($this->way_tags[$id]["highspeed"]) && $this->way_tags[$id]["highspeed"] == "no" )
				{
					$maxspeed_max = 200;
				}
				else
				{
					$maxspeed_max = 250;
				}
				$maxspeed_min = 40;
			}
			//branch lines
			elseif ( $this->way_tags[$id]["usage"] == "branch" )
			{
				$maxspeed = 50;
				$maxspeed_max = 100;
				$maxspeed_min = 20;
			}
		}
		//service ways
		elseif ( isset($this->way_tags[$id]["service"]) )
		{
			$maxspeed = 60;
			$maxspeed_max = 120;
			$maxspeed_min = 20;
		}
		else
		{
			$maxspeed = 100;
			$maxspeed_min = 20;
			if ( isset($this->way_tags[$id]["highspeed"]) && $this->way_tags[$id]["highspeed"] == "no" )
			{
				$maxspeed_max = 200;
			}
			else
			{
				$maxspeed_max = 250;
			}
		}
		return Array($maxspeed, $maxspeed_min, $maxspeed_max);
	}
	
	/**
	 * get nearest node to node
	 * @param int $ref
	 * @param double $treshold maximum distance of nodes to station
	 * @return int id of nearest node
	 */
	function get_nearest_node($ref, $treshold = 0.3)
	{
		if ( !isset($this->node[$ref]) )
		{
			return $ref;
		}
		
		foreach ( $this->node as $nodeid => $node)
		{
			// distance between nodes
			$node_diff = $this->getDistance($node["lat"], $node["lon"], $this->node[$ref]["lat"], $this->node[$ref]["lon"]);

			// only use nodes that are less than specified distance away
			if ( $node_diff < $treshold && $node_diff > 0 )
			{
				// add node to array
				$nodes_dis[$nodeid] = $node_diff;
			}
		}

		if( isset ( $nodes_dis) )
		{
			//sort array
			asort($nodes_dis);
	
			//use nearest found stop position
			foreach ( $nodes_dis as $nodeid => $nodedis )
			{
				$flipped_stops = array_flip($this->relation_stops);
				// use this node when it is a stop position
				if ( isset($this->node[$nodeid]["public_transport"]) && $this->node[$nodeid]["public_transport"] == "stop_position" && !isset($flipped_stops[$ref]))
				{
					return $nodeid;
				}
			}		
			
			// no stop position found
			foreach ( $nodes_dis as $nodeid => $nodedis )
			{
				return $nodeid;
				break;
			}
		}
		else
		{
			if($treshold < 2)
			{
				return $this->get_nearest_node($ref, ( $treshold + 0.2 ) );
			}
		}		
	}
	
	/**
	 * Function to show destination, origin and via stations of route in nice format
	 * @param string $to destination
	 * @param string $from origin
	 * @param string $via via stations
	 * @return string result
	 */
	static function showfromviato($to="",$from="",$via="")
	{
		$result = "";
		
		if($from)
		{
			$result .= $from;
		}
		
		if($via)
		{
			$a_via = explode ( ";", $via );
			foreach($a_via as $v_via)
			{
				$result .= " &#8594 " . $v_via;
			}
		}
		if($to)
		{
			$result .= " &#8594 " . $to;
		}

		return $result;
	}

	/**
	 * Function to show and style ref
	 * @param string $ref route ref
	 * @param string $route route type
	 * @param string $service service type
	 * @param string $colour background colour
	 * @param string $textcolour text colour
	 */	
	static function showRef($ref="", $route="", $service="", $colour="", $text_colour="")
	{
		//get train class
		if ( $route == "train" )
		{
			$css_ref_class = "ref_regional";
			if ( $service )
			{
				if ( $service == "high_speed" || $service == "long_distance" || $service == "night" || $service == "car" || $service == "car_shuttle" )
				{
					$css_ref_class = "ref_long_distance";
				}
				elseif ( $service == "regional" || $service == "commuter" )
				{
					$css_ref_class = "ref_regional";
				}
				elseif ( $service == "tourism")
				{
					$css_ref_class = "ref_tourism";
				}
			}
		}
		elseif ( $route == "light_rail" )
		{
			$css_ref_class = "ref_light_rail";
			if ( $service == "tourism")
			{
				$css_ref_class = "ref_tourism";
			}
		}
		elseif ( $route == "subway" )
		{
			$css_ref_class = "ref_light_rail";
			if ( $service == "tourism")
			{
				$css_ref_class = "ref_tourism";
			}
		}
		else
		{
			$css_ref_class = "ref_tram";
			if ( $service == "tourism")
			{
				$css_ref_class = "ref_tourism_tram";
			}
		}
		
		//set ref to N/A, when not available
		if ( !$ref )
		{
			$ref = "N/A";
		}
		
		//get css style for route ref
		$css_ref_style = "";
		if ( $colour )
		{
			$css_ref_style .= "background-color:" . $colour . ";";
		}
		if ( $text_colour )
		{
			$css_ref_style .= "color:" . $text_colour . ";";
		}
		
		return '<span class="' . $css_ref_class . '" style="' . $css_ref_style . '">' . $ref . '</span>';
		
	}

	/**
	 * Function to get route type
	 * @param string $route route type
	 * @param string $service service type
	 */	
	static function getRouteType($route,$service="")
	{
		$route_type_lang = Array(
		"high_speed"     => Lang::l_('Highspeed Train'),
		"long_distance" => Lang::l_('Long Distance Train'),
		"car"           => Lang::l_('Motorail Train'),
		"car_shuttle"   => Lang::l_('Car Shuttle Train'),
		"night"         => Lang::l_('Night Train'),
		"regional"      => Lang::l_('Regional Train'),
		"commuter"      => Lang::l_('Commuter Train'),
        "train"         => Lang::l_('Unspecified Train'),
        "light_rail"    => Lang::l_('Light Rail'),
		"tram"			=> Lang::l_('Tram'),
		"subway"		=> Lang::l_('Subway'),
		"tourism"		=> Lang::l_('Tourist Train'),
		"tourism_tram"  => Lang::l_('Tourist Tram'),
		"unknown"       => Lang::l_('N/A'),
		);
		
		if ( $route == "train" )
		{
			$route_type = "train";
			if ( $service == "high_speed" )
			{
				$route_type = "high_speed";
			}
			elseif ( $service == "long_distance" )
			{
				$route_type = "long_distance";
			}
			elseif ( $service == "night" )
			{
				$route_type = "night";
			}
			elseif ( $service == "car" )
			{
				$route_type = "car";
			}
			elseif ( $service == "car_shuttle" )
			{
				$route_type = "car_shuttle";
			}
			elseif ( $service == "regional" )
			{
				$route_type = "regional";
			}
			elseif ( $service == "commuter" )
			{
				$route_type = "commuter";
			}
			elseif ( $service == "tourism")
			{
				$route_type = "tourism";
			}
		}
		elseif ( $route == "tram" )
		{
			$route_type = "tram";
			if ( $service == "tourism")
			{
				$route_type = "tourism_tram";
			}
		}
		elseif ( $service == "tourism")
		{
			$route_type = "tourism";
		}
		elseif ( $route == "light_rail" )
		{
			$route_type = "light_rail";
		}
		elseif ( $route == "subway" )
		{
			$route_type = "subway";
		}
		return $route_type_lang[$route_type];
	}
}
?>
