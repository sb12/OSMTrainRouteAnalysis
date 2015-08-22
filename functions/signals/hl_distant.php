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
?>
<?php
/**
 * German Hl Distant Signal
 * @author sb12
 *
 */
Class HL_distant
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed_distant, $main_distance)
	{
		$state = "";
		if(isset($tags["railway:signal:distant:states"]))
		{
			// last distant signal of route
			if ( $next_speed_distant == 0  && 
					 strpos($tags["railway:signal:distant:states"], "hl10") )
			{
				$state = "hl10";
			}
			elseif ( $next_speed_distant == 100  && 
					 strpos($tags["railway:signal:distant:states"], "hl4") )
			{
				$state = "hl4";
			}
			elseif ( ( $next_speed_distant == 40 || $next_speed_distant == 60 ) && 
					 strpos($tags["railway:signal:distant:states"], "hl7") )
			{
				$state = "hl7";
			}
			elseif ( strpos($tags["railway:signal:distant:states"], "hl1" ) ) // signal can only show hp0
			{
				$state = "hl1";
			}
			elseif ( strpos($tags["railway:signal:distant:states"], "hl10" ) ) // signal can only show hp0
			{
				$state = "hl10";
			}
		}
		return $state;
	}
	
	
	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return Lang::l_("German Hl");
	}
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
		$colour_gelb1 = "&yellow;";
		$colour_gruen = "&green;";
		$class_gelb1 = "";
		$class_gruen = "";

		$show_gruen = $show_gelb1 = true;
		if( isset($_GET["railway:signal:distant:states"]) )
		{
			$show_gruen = $show_gelb1 = false;
			if( strpos($_GET["railway:signal:distant:states"], "hl1")
					|| strpos($_GET["railway:signal:distant:states"], "hl4")
					)
			{
				$show_gruen = true;
			}
			
			if( strpos($_GET["railway:signal:distant:states"], "hl7")
					|| strpos( $_GET["railway:signal:distant:states"], "hl10") 
					)
			{
				$show_gelb1 = true;
			}
		}
		
		if( isset($_GET["state_distant"]) )
		{
			if($_GET["state_distant"] == "hl1")
			{
				$colour_gelb1 = "&gray;";
				$colour_gruen = "&green;";
			}
			if($_GET["state_distant"] == "hl4")
			{
				$colour_gelb1 = "&gray;";
				$colour_gruen = "&green;";
				$class_gruen = "signal_blink";
			}
			if($_GET["state_distant"] == "hl7")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gruen = "&gray;";	
				$class_gelb1 = "signal_blink";
			}
			if($_GET["state_distant"] == "hl10")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gruen = "&gray;";
			}
		}
		
		$image = '
			<g transform="translate(0 ' . $height . ')">
				<g>
					<polygon style="&background;" points="6,6 11,1 29,1 34,6 34,55 6,55"/>
				</g>
					';
		if($show_gelb1)
		{
			$image .= '
				<g id="gelb1">
					<circle style="&gray;" cx="12" cy="12" r="4"/>
					<circle class="' . $class_gelb1 . '" style="' . $colour_gelb1 . '" cx="12" cy="12" r="4"/>
				</g>
					';
		}
		if($show_gruen)
		{
			$image .= '
				<g id="gruen">
					<circle style="&gray;" cx="28" cy="12" r="4"/>
					<circle class="' . $class_gruen . '" style="' . $colour_gruen . '" cx="28" cy="12" r="4"/>
				</g>
					
					';
		}
		$image .= '
		</g>';
		$height = 55;
		return array($image, $height);
	}
}