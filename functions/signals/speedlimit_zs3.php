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
 * German Zs3 Speed signal
 * @author sb12
 *
 */
Class Speedlimit_zs3
{

	/**
	 * returns the state of the signal
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 */
	public static function findState($tags, $next_speed)
	{
		$speed="";
		if( isset($tags["railway:signal:speed_limit:form"]) )
		{
			if( $tags["railway:signal:speed_limit:form"] == "light" )
			{
				$speeds = "";
				if(isset($tags["railway:signal:speed_limit:speed"]))
				{
					$speeds = $tags["railway:signal:speed_limit:speed"];
					$speed_array = explode(";",$speeds);
					if( count( $speed_array ) == 1 && $speed_array[0] > 0) // there's only one value and it is a number
					{
						$speed = $speed_array[0];
					}
					elseif( in_array($next_speed,$speed_array)) // next speed is in array
					{
						$speed = $next_speed;
					}
				}
			}
			elseif( $tags["railway:signal:speed_limit:form"] == "sign" )
			{
				if( isset ($tags["railway:signal:speed_limit:speed"]) && $tags["railway:signal:speed_limit:speed"] > 0 )
				{
					$speed = $tags["railway:signal:speed_limit:speed"];
				}
			}
		}
		return $speed;
	}
	

	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return Lang::l_("German Zs3 Speed Signal");
	}
	

	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage()
	{
		return; // not needed
	}
}
