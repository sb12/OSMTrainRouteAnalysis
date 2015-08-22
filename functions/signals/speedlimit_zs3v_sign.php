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
 * German Zs 3v Distant Speed Sign
 * @author sb12
 *
 */
Class Speedlimit_zs3v_sign
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
		return; // not needed
	}
	
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
			$speed = "";
			if(isset($_GET["railway:signal:speed_limit:speed"]))
			{
				$speed = $_GET["railway:signal:speed_limit:speed"];
			}
			$image = '
<g>
	<polygon fill="#000000" stroke="yellow" points="3,1 20,32 37,1" stroke-width="2"/>';
			$path = Signal_path::getPath($speed);
			if(isset($path))
			{
				$image .= '
	<path transform="translate(0, -13)" d="' . $path . '" style="&yellow;" />';
				
			}
			$image .= '
</g>';
		$s++;
		$height = 33;
		return array($image, $height);
	}
}