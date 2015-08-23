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
 * German Ks Main Signal
 * @author sb12
 *
 */
Class KS_main
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed, $main_distance)
	{
		$state = "";
		if(isset($tags["railway:signal:main:states"]))
		{
			if ( $next_speed == 0 && strpos($tags["railway:signal:main:states"], "hp0" )) // signal at end of route
			{
				$state = "hp0";
			}
			elseif ( strpos($tags["railway:signal:main:states"], "ks1" ) )
			{
				$state = "ks1";
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
		return Lang::l_("German Ks");
	}
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
		$colour_hp0 = "&red;";
		$colour_ks1 = "&green;";
		$colour_sh1 = "&gray;";
		$colour_zs1 = "&gray;";
		$colour_zs7 = "&gray;";
		$class_zs1 = "";
		if(isset($_GET["state_main"]))
		{
			if($_GET["state_main"] == "hp0")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";				
			}
			if($_GET["state_main"] == "ks1")
			{
				$colour_hp0 = "&gray;";
				$colour_ks1 = "&green;";
			}
			if($_GET["state_main"] == "sh1")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";
				$colour_sh1 = "&white;";
				$colour_zs1 = "&white;";
			}
			if($_GET["state_main"] == "zs1" && isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:dr:zs1")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";
				$colour_zs1 = "&white;";
				$class_zs1 = "signal_blink";
			}
			if($_GET["state_main"] == "zs7" && isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs7")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";
				$colour_zs7 = "&yellow;";
			}
		}
		
		$image = '
			<g transform="translate(0 ' . $height . ')">
				<g>
					<polygon style="&background;" points="6,1 34,1 34,59 6,59"/>
				</g>
					
				<g id="hp0">
					<circle style="' . $colour_hp0 . '" cx="20" cy="16" r="4"/>
				</g>
					
				<g id="ks1">
					<circle style="' . $colour_ks1 . '" cx="20" cy="29" r="4"/>
				</g>
				<g id="sh1">';
		if ( ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:dr:zs1" ) || ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" ) )
		{
			$image .= '
					<circle style="&gray;" cx="20" cy="39" r="2"/>
					<circle class="' . $class_zs1 . '" style="' . $colour_zs1 . '" cx="20" cy="39" r="2"/>';
		}
		if ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" )
		{
			$image .= '
					<circle style="' . $colour_sh1 . '" cx="10" cy="49" r="2"/>';
		}
		$image .= '
				</g>';
		if ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs7" )
		{
			$image .= '
					<g id="zs7">
						<circle style="' . $colour_zs7 . '" cx="15" cy="39" r="2"/>
						<circle style="' . $colour_zs7 . '" cx="25" cy="39" r="2"/>
						<circle style="' . $colour_zs7 . '" cx="20" cy="49" r="2"/>
					</g>';
		}
		$image .= '
		</g>';
		$height = 60;
		return array($image, $height);
	}
}