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
 * Unknown Distant Light Signal
 * @author sb12
 *
 */
Class Distant_light
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed_distant, $main_distance)
	{
		return; // not needed
	}
	
	
	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return Lang::l_("Unknown");
	}
	
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($position)
	{
	{
		$colour_green = "&green;";
		$colour_yellow = "&yellow;";
	
		$geometry = "10,1 30,1 30,59 10,59";
		$r_main = 4;
		$lights[] = Array(
			'id'        =>	'yellow',
			'colour'    => $colour_yellow,
			'cx'        => 20,
			'cy'        => 20,
			'r'         => $r_main,
		);
		$lights[] = Array(
			'id'        =>	'green',
			'colour'    => $colour_green,
			'cx'        => 20,
			'cy'        => 40,
			'r'         => $r_main,
		);
		
		return Signal_Light::generateImage($position,60,$geometry,$lights);	
	}
		$image = '
				<g transform="translate(0 ' . $height . ')">
					<g>
						<polygon style="&background;" points="10,1 30,1 30,59 10,59"/>
					</g>
						
					<g id="green">
						<circle style="&green;" cx="20" cy="20" r="4"/>
					</g>
						
					<g id="yellow">
						<circle style="&yellow;" cx="20" cy="40" r="4"/>
					</g>
				</g>';
		$height = 60;
		return array($image, $height);
	}
}