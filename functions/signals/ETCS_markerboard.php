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
 * ETCS marker board
 * @author sb12
 *
 */
Class ETCS_markerboard
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed, $main_distance)
	{
		return; //not needed
	}
	
	
	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return Lang::l_("ETCS Marker Board (German Ne 14)");
	}
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
		$polygon = "6,10 20,10 20,3 33,15 20,27 20,20 6,20";
		$rect = 'x="5" y="0" width="2" height="30"';
		if( isset($_GET["railway:signal:position"]) )
		{
			if( $_GET["railway:signal:position"] == "right")
			{
				$polygon = "34,10 20,10 20,3 7,15 20,27 20,20 34,20";
				$rect = 'x="33" y="0" width="2" height="30"';	
			}
			elseif( $_GET["railway:signal:position"] == "overhead")
			{
				$polygon = "15,1 15,15 8,15 20,28 32,15 25,15 25,1";
				$rect = 'x="5" y="0" width="30" height="2"';	
			}
		}	
		$image = '
			<g transform="translate(0 ' . $height . ')">
    			<rect fill="#3366FF" x="5" y="0" width="30" height="30" />
    			
				<polygon fill="#FFFF00" stroke="#FFFFFF" stroke-width="2" points="' . $polygon . '"/>
    			<rect fill="#3366FF" ' . $rect . ' />
			
			</g>';
		$height = 30;
		return array($image, $height);
	}
}