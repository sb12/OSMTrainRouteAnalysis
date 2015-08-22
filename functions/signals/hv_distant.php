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
 * German H/V Distant Signal
 * @author sb12
 *
 */
Class HV_distant
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
			if ( $next_speed_distant == 0 && strstr($tags["railway:signal:distant:states"], "vr0" )) // signal at end of route
			{
				$state = "vr0";
			}
			elseif ( $next_speed_distant > 60 && strstr($tags["railway:signal:distant:states"], "vr1" ) )
			{
				$state = "vr1"; 
			}
			elseif ( $next_speed_distant <= 60 && $next_speed_distant > 0 && strstr ( $tags["railway:signal:distant:states"], "vr2" ) )
			{
				$state = "vr2"; 
			}
			elseif ( $next_speed_distant > 60 && strstr ( $tags["railway:signal:distant:states"], "vr2" ) )
			{
				$state = "vr2"; 
			}
			elseif( strstr($tags["railway:signal:distant:states"], "vr0" ) ) // signal can not show vr2 or vr1
			{
				$state = "vr0";
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
		return Lang::l_("German H/V");
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
