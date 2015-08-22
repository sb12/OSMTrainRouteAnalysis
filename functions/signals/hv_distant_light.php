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
 * describes a signal on the route
 * @author sb12
 *
 */
Class HV_distant_light
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed_distant, $main_distance)
	{
		return HV_distant::findState($tags, $next_speed_distant, $main_distance);
	}
	
	
	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return HV_distant::showDescription();
	}
	
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
		
		$colour_vr0 = "&yellow;";
		$colour_vr1 = "&green;";
		$colour_vr12 = "&green;";
		$colour_vr2 = "&yellow;";

		$marker = false;
		if ( isset ( $_GET["railway:signal:distant:states"] ) )
		{
			if ( strpos( $_GET["railway:signal:distant:states"], "kennlicht" ) )
			{
				$marker = true;
			}
		}
		if( ( isset($_GET["railway:signal:distant:repeated"]) && $_GET["railway:signal:distant:repeated"] == "yes" ) || ( isset($_GET["railway:signal:distant:shortened_distance"]) && $_GET["railway:signal:distant:shortened_distance"] == "yes" ) )
		{
			$colour_marker = "&white;";
			$marker = true;
		}
		else
		{
			$colour_marker = "&gray;";
			$marker = true;
		}
		
		if(isset($_GET["state_distant"]))
		{
			if($_GET["state_distant"] == "vr0")
			{
				$colour_vr0 = "&yellow;";
				$colour_vr1 = "&gray;";
				$colour_vr12 = "&gray;";
				$colour_vr2 = "&yellow;";				
			}
			if($_GET["state_distant"] == "vr1")
			{
				$colour_vr0 = "&gray;";
				$colour_vr1 = "&green;";
				$colour_vr12 = "&green;";
				$colour_vr2 = "&gray;";				
			}
			if($_GET["state_distant"] == "vr2")
			{
				$colour_vr0 = "&gray;";
				$colour_vr1 = "&gray;";
				$colour_vr12 = "&green;";
				$colour_vr2 = "&yellow;";				
			}
			if($_GET["state_distant"] == "kennlicht")
			{
				$colour_vr0 = "&gray;";
				$colour_vr1 = "&gray;";
				$colour_vr12 = "&gray;";
				$colour_vr2 = "&gray;";	
				$colour_marker = "&white;";				
			}
		}
		$image = '
			<g transform="translate(0 ' . $height . ')">
				<g>
					<polygon style="&background;" points="6,1 34,1 34,59 6,59"/>
				</g>';


		$image .= '
				<g id="vr0">
					<circle style="' . $colour_vr0 . '" cx="27" cy="25" r="4"/>
				</g>
				<g id="vr12">
					<circle style="' . $colour_vr12 . '" cx="27" cy="12" r="4"/>
				</g>
				<g id="vr1">
					<circle style="' . $colour_vr1 . '" cx="13" cy="38" r="4"/>
				</g>
				<g id="vr2">
					<circle style="' . $colour_vr2 . '" cx="13" cy="50" r="4"/>
				</g>';

		if ( $marker )
		{
			$image .= '
				<g id="marker">
					<circle style="' . $colour_marker . '" cx="12" cy="11" r="2"/>
				</g>';
		}
		$image .= '
			</g>';
		$height = 60;
		return array($image, $height);
	}
}