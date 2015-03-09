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
		if ( $this->variables["ref"] )
		{
			$link .= "%3Chas-kv%20k%3D%22ref%22%20regv%3D%22" . urlencode( htmlspecialchars($this->variables["ref"]) ) . "%22%2F%3E";
		}

		// network
		if ( $this->variables["network"] )
		{
			$link .= "%3Chas-kv%20k%3D%22network%22%20regv%3D%22" . urlencode( htmlspecialchars($this->variables["network"]) ) . "%22%2F%3E";
		}

		// operator
		if ( $this->variables["operator"] )
		{
			$link .= "%3Chas-kv%20k%3D%22operator%22%20regv%3D%22" . urlencode( htmlspecialchars($this->variables["operator"]) ) . "%22%2F%3E";
		}

		// to
		if ( $this->variables["to"] )
		{
			$link .= "%3Chas-kv%20k%3D%22to%22%20regv%3D%22" . urlencode( htmlspecialchars($this->variables["to"]) ) . "%22%2F%3E";
		}

		// from
		if ( $this->variables["from"] )
		{
			$link .= "%3Chas-kv%20k%3D%22from%22%20regv%3D%22" . urlencode( htmlspecialchars($this->variables["from"]) ) . "%22%2F%3E";
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
	function sortResult($orderby="ref")
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
			else
			{
				$ref[$key] = "";
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

		// Obtain a list of columns
		foreach ($this->result as $key => $row) 
		{
			//add missing variables
			if(!isset($row["ref"]))
			{
				$row["ref"]="";
			}
			if(!isset($row["service"]))
			{
				$row["service"]="";
			}
			if ( !isset($row["from"]) )
			{
				$row["from"] = "";
			}
			if ( !isset($row["to"]) )
			{
				$row["to"] = "";
			}
			if ( !isset($row["via"]) )
			{
				$row["via"] = "";
			}
			//set colour
			if ( isset($row["color"]) )
			{
				$row["colour"]=$row["color"];
			}
			elseif ( !isset($row["colour"]) )
			{
				$row["colour"]="";
			}
			if ( isset($row["text_color"]) )
			{
				$row["text_colour"]=$row["text_color"];
			}
			elseif ( isset($row["colour:text"]) )
			{
				$row["text_colour"]=$row["colour:text"];
			}
			elseif ( !isset($row["text_colour"]) )
			{
				$row["text_colour"]="";
			}
			
			//build html output
			
			$html = "<a href=\"?id=".$row["id"]."&train=".urlencode(htmlentities($this->variables["train"]))."\" class=\"list-group-item\">\n";

			$html .= "<h4>";
			
			$html .= Route::showRef($row["ref"], $row["route"], $row["service"], $row["colour"], $row["text_colour"]) . " ";

			
			$html .= Route::showfromviato($row["to"],$row["from"],$row["via"]);
			
			$html .= "</h4>\n";
			$html .= "<span>";

			$html .= Route::getRouteType($row["route"], $row["service"]);
			if ( isset($row["network"]) )
			{
				$html .= " / " . $row["network"];
			}		
			if ( isset($row["operator"]) )
			{
				$html .= " / " . $row["operator"];
			}
			
			$html .= "</span>\n</a>";
			
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
	<div class="panel panel-primary">
		<div class="panel-heading" data-toggle="collapse" aria-expanded="false" aria-controls="searchForm" role="tab">
			<h3 class="panel-title"><a data-toggle="collapse" href="#searchForm" aria-expanded="false" aria-controls="searchForm"><?php echo Lang::l_("By route information:");?></a></h3>
		</div>
		<div class="panel-body collapse" id="searchForm">
			<form method="get" id="searchform" class=".form-horizontal">
				<div class="form-group">
					<label for="ref" class="col-sm-2 control-label"><?php echo Lang::l_("Line");?>:</label>
					<div class="col-sm-10">
						<input type="text" name="ref" id="ref" class="form-control">
					</div>
				</div>	
				<div class="form-group">
					<label for="operator" class="col-sm-2 control-label"><?php echo Lang::l_("Operator");?>:</label>
					<div class="col-sm-10">
						<input type="text" name="operator" id="operator" class="form-control">
					</div>
				</div>	
				<div class="form-group">
					<label for="network" class="col-sm-2 control-label"><?php echo Lang::l_("Network");?>:</label>
					<div class="col-sm-10">
						<input type="text" name="network" id="network" class="form-control">
					</div>
				</div>	
				<div class="form-group">
					<label for="from" class="col-sm-2 control-label"><?php echo Lang::l_("Origin");?>:</label>
					<div class="col-sm-10">
						<input type="text" name="from" id="from" class="form-control">
					</div>
				</div>	
				<div class="form-group">
					<label for="to" class="col-sm-2 control-label"><?php echo Lang::l_("Destination");?>:</label>
					<div class="col-sm-10">
						<input type="text" name="to" id="to" class="form-control">
					</div>
				</div>										
				<div class="form-group">
					<label for="trainsearch" class="col-sm-2 control-label"><?php echo Lang::l_('Train');?>:</label>
					<div class="col-sm-10">
						<?php echo Train::changeTrain("", "", "trainsearch");?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default"><?php echo Lang::l_("Search route");?></button>
					</div>
				</div>
			</form>
		</div>
		</div>		
		<?php
	}

	/**
	 * HTML Output for Search Result Box
	 */
	static function showSearchResult()
	{
		?>
<!-- Modal -->
<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="searchLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="searchLabel"><?php echo Lang::l_("Search Results"); ?></h4>
			</div>
			<div class="modal-body list-group" id="searchcontent">
			</div>      
			<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
		</div>
	</div>
</div>
		<?php
	}
}
?>