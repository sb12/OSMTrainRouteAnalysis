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
 * Class for Search
 * 
 * This class has all functions and variables that are needed to do a search for a route
 * 
 * @author sb12
 *
 */
Class Search
{

	/**
	 * variables used for search
	 * @var array
	 */
	private $variables;

	/**
	 * content of search achieved from overpass api
	 * @var String
	 */
	private $content;

	/**
	 * contains search results
	 * @var array[i][key]
	 */
	private $result;
	
	/**
	 * Load data of search
	 * 
	 * Loads route data from overpass api.
	 */
	public function getData() 
	{
		// add GET to variables
		$this->variables=$_GET;

		// FIXME: add error handling
		
		// build link
		$link = "http://overpass-api.de/api/interpreter?data=%3Cquery%20type%3D%22relation%22%3E";

		// reference number
		if ( isset($this->variables["ref"]) )
		{
			$link .= "%3Chas-kv%20k%3D%22ref%22%20regv%3D%22" . urlencode( htmlentities($this->variables["ref"]) ) . "%22%2F%3E";
		}

		// network
		if ( isset($this->variables["network"]) )
		{
			$link .= "%3Chas-kv%20k%3D%22network%22%20regv%3D%22" . urlencode( htmlentities($this->variables["network"]) ) . "%22%2F%3E";
		}

		// operator
		if ( isset($this->variables["operator"]) )
		{
			$link .= "%3Chas-kv%20k%3D%22operator%22%20regv%3D%22" . urlencode( htmlentities($this->variables["operator"]) ) . "%22%2F%3E";
		}

		// to
		if ( isset($this->variables["to"]) )
		{
			$link .= "%3Chas-kv%20k%3D%22to%22%20regv%3D%22" . urlencode( htmlentities($this->variables["to"]) ) . "%22%2F%3E";
		}

		// from
		if ( isset($this->variables["from"]) )
		{
			$link .= "%3Chas-kv%20k%3D%22from%22%20regv%3D%22" . urlencode( htmlentities($this->variables["from"]) ) . "%22%2F%3E";
		}

		$link .= "%3Chas-kv%20k%3D%22type%22%20v%3D%22route%22%2F%3E%3Chas-kv%20k%3D%22route%22%20regv%3D%22train%7Ctram%7Clight_rail%7Csubway%22%2F%3E%3C%2Fquery%3E%3Cprint%2F%3E";

		// get data from overpass api
		$this->content = file_get_contents($link);

		
		// FIXME: add error handling
	}
	 
	/**
	 * Load XML file
	 * 
	 * This function loads the XML file and extracts the search result
	 */
	function loadXml()
	{
		
		// load xml file
		$xml = @simplexml_load_string($this->content);
		
		if ( !$xml ) // content is not a valid xml 
		{
			// FIXME: add error message
			die();
		}
		
		$i = 0;
		
		//load all relations
		foreach ( $xml->relation as $relation ) 
		{	
			//load attributes
			foreach ( $relation->attributes() as $a => $b)
			{
				if ( $a == "id" )
				{
					$this->result[$i]["id"] = (string)$b;
				}
			}
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
				
				if($k!="id") // prevent overwrite of id
				{
					$this->result[$i][$k] = $v; //store tags temporary
				}
			}
			$i++;
		}
	}

	/**
	 * Sort Search Result
	 *
	 * This function sorts the search results
	 */
	function sortResult($orderby="id")
	{
		//result is empty
		if(!isset($this->result))
		{
			return;
		}
		
		// Obtain a list of columns
		foreach ( $this->result as $key => $row)
		{
			$id[$key] = $row['id'];
				
			if ( isset($row["ref"]) )
			{
				$ref[$key] = $row['ref'];
			}
		}
		
		if ( $orderby == "ref" && isset($ref))
		{
			$sort = $ref;
		}
		else
		{
			$sort = $id;
		}
	
		// Sort the data 
		array_multisort($sort, SORT_ASC, $id, SORT_ASC, $this->result);

	}
	
	
	/**
	 * Show Search Result
	 *
	 * This function shows the search results
	 */
	function showResult()
	{
		//result is empty
		if(!isset($this->result))
		{
			//FIXME: translation
			?>
			No data was found.
			<?php
			return;
		}
		$route_type["high_speed"] = Lang::l_('Highspeed train');
		$route_type["long_distance"] = Lang::l_('Long distance train');
		$route_type["car"] = Lang::l_('Motorail Train');
		$route_type["car_shuttle"] = Lang::l_('Car Shuttle Train');
		$route_type["night"] = Lang::l_('Night Train');
		$route_type["regional"] = Lang::l_('Regional train');
		$route_type["commuter"] = Lang::l_('Commuter train');
		$route_type["light_rail"] = Lang::l_('Light Rail');
		$route_type["tram"] = Lang::l_('Tram');
		$route_type["subway"] = Lang::l_('Subway');
		$route_type["unknown"] = Lang::l_('N/A');

		// Obtain a list of columns
		foreach ($this->result as $key => $row) 
		{

		//build html output
		
			$html = "<div class=\"search_result\">\n";

			$html .= "<h4><a href=\"?id=".$row["id"]."\">";
			if ( isset($row["id"]) )
			{
				$html .= $row["ref"];
			}
			else
			{
				$html .= Lang::l("Unknown");
			}
			if ( isset($row["from"]) )
			{
				$html .= " " . Lang::l_("from") . " " . $row["from"];
			}
			if ( isset($row["to"]) )
			{
				$html .= " " . Lang::l_("to") . " " . $row["to"];
			}
			if ( isset($row["via"]) )
			{
				$html .= " " . Lang::l_("via") . " " . $row["via"];
			}
			$html.="</a></h4>\n";
			$html.="<span>";

			if ( $row["route"] == "tram")
			{
				$html.=$route_type["tram"];
			}
			elseif ( $row["route"] == "light_rail")
			{
				$html.=$route_type["light_rail"];
			}
			elseif ( $row["route"] == "subway")
			{
				$html.=$route_type["subway"];
			}
			else
			{
				if ( isset($row["service"]) && isset($route_type[$row["service"]]) )
				{
					$html.=$route_type[$row["service"]];
				}
				else
				{
					$html.=$route_type["unknown"];					
				}
			}
			if ( isset($row["network"]) )
			{
				$html .= " / " . $row["network"];
			}		
			if ( isset($row["operator"]) )
			{
				$html .= " / " . $row["operator"];
			}
			
			$html .= "</span>\n</div>";
			
			//write html
			echo $html;
		 
		}
	}
	
	/**
	 * shows the Search box
	 */
	static function showSearchBox()
	{
		?>
		
		<div class="choose_route">
			<form method="get" id="searchform">
				
				<label for="ref">Ref:</label> <input type="text" name="ref">
				<label for="operator">Operator:</label> <input type="text" name="operator">
				<label for="network">Network:</label> <input type="text" name="network"> <br />
				<label for="from">From:</label> <input type="text" name="from">
				<label for="to">To:</label> <input type="text" name="to">
				
				<input type="submit"/>
			</form>
		</div>		
		<?php
	}

	/**
	 * HTML Output for Search Result Box
	 */
	static function showSearchResult()
	{
		?>
		<div class="search" id="search">
		<a class="close" href="#">X</a>
		<div id="searchcontent"></div>
		</div>
		<?php
	}
}
?>