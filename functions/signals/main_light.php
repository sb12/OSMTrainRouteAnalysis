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
 * Unknown Main Light Signal
 * @author sb12
 *
 */
Class Main_light
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
	public static function generateImage($height)
	{
		$image = '
				<g transform="translate(0 ' . $height . ')">
					<g>
						<polygon fill="&background;" points="10,1 30,1 30,59 10,59"/>
					</g>
						
					<g id="green">
						<circle style="&green;" cx="20" cy="20" r="4"/>
					</g>
						
					<g id="red">
						<circle style="&red;" cx="20" cy="50" r="4"/>
					</g>
				</g>';
		$height = 60;
		return array($image, $height);
	}
}