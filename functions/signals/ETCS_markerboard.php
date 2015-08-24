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
		$polygon = "10,8 20,8 20,2 28,10 20,18 20,12 10,12";
		$rect = 'x="10" y="0" width="1" height="20"';
		if( isset($_GET["railway:signal:position"]) )
		{
			if( $_GET["railway:signal:position"] == "right")
			{
				$polygon = "30,8 20,8 20,2 11,10 20,18 20,12 30,12";
				$rect = 'x="29" y="0" width="1" height="20"';	
			}
			elseif( $_GET["railway:signal:position"] == "overhead")
			{
				$polygon = "18,1 18,10 12,10 20,19 28,10 22,10 22,1";
				$rect = 'x="10" y="0" width="20" height="1"';	
			}
		}	
		$image = '
			<g transform="translate(0 ' . $height . ')">
    			<rect fill="#3366FF" x="10" y="0" width="20" height="20" />
    			
				<polygon fill="#FFFF00" stroke="#FFFFFF" stroke-width="1" points="' . $polygon . '"/>
    			<rect fill="#3366FF" ' . $rect . ' />
			
			</g>';
		$height = 20;
		return array($image, $height);
	}
}