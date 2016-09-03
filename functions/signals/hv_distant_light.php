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
Class HV_distant extends SignalPart
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
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($position)
	{
		
		$colour_vr0 = "&yellow;";
		$colour_vr1 = "&green;";
		$colour_vr12 = "&green;";
		$colour_vr2 = "&yellow;";
		$colour_marker = "&gray;";

		$marker = false;
		if ( isset ( $_GET["railway:signal:distant:states"] ) )
		{
			if ( strpos( $_GET["railway:signal:distant:states"], "kennlicht" ) )
			{
				$marker = true;
			}
		}
		if( ( isset($_GET["railway:signal:distant:repeated"]) &&
			$_GET["railway:signal:distant:repeated"] == "yes" ) ||
				( isset($_GET["railway:signal:distant:shortened"]) &&
				$_GET["railway:signal:distant:shortened"] == "yes" ) )
		{
			// marker light when it is a repeater or in shortened distance to main signal
			$colour_marker = "&white;";
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
			if($_GET["state_distant"] == "off")
			{
				$colour_vr0 = "&gray;";
				$colour_vr1 = "&gray;";
				$colour_vr12 = "&gray;";
				$colour_vr2 = "&gray;";	
				$colour_marker = "&gray;";				
			}
		}

		if( $_GET["railway:signal:distant:form"] == "light" )
		{
			$geometry = "6,1 34,1 34,49 6,49";
			$r_main = 4;
			$r_minor = 1.5;
			$lights[] = Array(
					'id'        =>	'vr0',
					'colour'    => $colour_vr0,
					'cx'        => 27,
					'cy'        => 22,
					'r'         => $r_main,
			);
			$lights[] = Array(
					'id'        =>	'vr12',
					'colour'    => $colour_vr12,
					'cx'        => 27,
					'cy'        => 12,
					'r'         => $r_main,
			);
			$lights[] = Array(
					'id'        =>	'vr1',
					'colour'    => $colour_vr1,
					'cx'        => 13,
					'cy'        => 30,
					'r'         => $r_main,
			);
			$lights[] = Array(
					'id'        =>	'vr2',
					'colour'    => $colour_vr2,
					'cx'        => 13,
					'cy'        => 40,
					'r'         => $r_main,
			);
	
			if ( $marker )
			{
				$lights[] = Array(
						'id'        =>	'marker',
						'colour'    => $colour_marker,
						'cx'        => 12,
						'cy'        => 12,
						'r'         => $r_minor,
				);
			}
			return Signal_Light::generateImage($position,50,$geometry,$lights);
		}
	}
}
