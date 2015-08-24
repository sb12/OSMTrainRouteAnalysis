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
 * German H/V Main Light Signal
 * @author sb12
 *
 */
Class HV_main_light
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed, $main_distance)
	{
		return HV_main::findState($tags, $next_speed, $main_distance);
	}
	
	
	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return HV_main::showDescription();
	}
	
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
		$colour_hp0 = "&red;";
		$colour_hp00 = "&red;";
		$colour_hp1 = "&green;";
		$colour_hp2 = "&yellow;";
		$colour_zs1 = "&gray;";
		$colour_zs7 = "&gray;";
		$colour_sh1 = "&gray;";
		$colour_marker = "&gray;";
		$class_zs1 = "";
	
		if(isset($_GET["state_main"]))
		{
			if($_GET["state_main"] == "hp0")
			{
				$colour_hp0 = "&red;";
				$colour_hp00 = "&red;";
				$colour_hp1 = "&gray;";
				$colour_hp2 = "&gray;";
			}
			if($_GET["state_main"] == "hp1")
			{
				$colour_hp0 = "&gray;";
				$colour_hp00 = "&gray;";
				$colour_hp1 = "&green;";
				$colour_hp2 = "&gray;";
			}
			if($_GET["state_main"] == "hp2")
			{
				$colour_hp0 = "&gray;";
				$colour_hp00 = "&gray;";
				$colour_hp1 = "&green;";
				$colour_hp2 = "&yellow;";
			}
			if($_GET["state_main"] == "sh1" || $_GET["state_main"] == "zs1" || $_GET["state_main"] == "zs7" || $_GET["state_main"] == "zs8")
			{
				$colour_hp0 = "&red;";
				$colour_hp00 = "&gray;";
				$colour_hp1 = "&gray;";
				$colour_hp2 = "&gray;";
			}
			if($_GET["state_main"] == "sh1")
			{
				$colour_sh1 = "&white;";
			}
			if($_GET["state_main"] == "zs1")
			{
				$colour_zs1 = "&white;";
			}
			if($_GET["state_main"] == "zs8")
			{
				$colour_zs1 = "&white;";
				$class_zs1 = "signal_blink";
			}
			if($_GET["state_main"] == "zs7")
			{
				$colour_zs7 = "&yellow;";
				$colour_marker = "&yellow;"; // the marker light is part of zs7
			}
			if($_GET["state_main"] == "kennlicht")
			{
				$colour_hp0 = "&gray;";
				$colour_hp00 = "&gray;";
				$colour_hp1 = "&gray;";
				$colour_hp2 = "&gray;";
				$colour_marker = "&white;";
			}
		}
	
		$image = '
			<g transform="translate(0 ' . $height . ')">
				<g>
					<polygon style="&background;" points="6,1 34,1 34,59 6,59"/>
				</g>';
	
	
		$image .= '
				<g id="hp0">
					<circle style="' . $colour_hp0 . '" cx="13" cy="23" r="4"/>
				</g>
				<g id="hp1">
					<circle style="' . $colour_hp1 . '" cx="13" cy="11" r="4"/>
				</g>';
	
		$marker = false;
		if ( isset ( $_GET["railway:signal:main:states"] ) )
		{
			if ( strpos( $_GET["railway:signal:main:states"], "hp2" ) )
			{
				$image .= '
				<g id="hp2">
					<circle style="' . $colour_hp2 . '" cx="13" cy="50" r="4"/>
				</g>';
			}
			if ( strpos( $_GET["railway:signal:main:states"], "kennlicht" ) )
			{
				$marker = true;
			}
		}
		else
		{
			$image .= '
				<g id="hp2">
					<circle style="' . $colour_hp2 . '" cx="13" cy="50" r="4"/>
				</g>';
		}
		if ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" )
		{
			$image .= '
				<g id="hp00">
					<circle style="' . $colour_hp00 . '" cx="27" cy="23" r="4"/>
				</g>
				<g id="sh1">
					<circle style="' . $colour_sh1 . '" cx="20" cy="33" r="1.5"/>
					<circle style="' . $colour_sh1 . '" cx="12" cy="41" r="1.5"/>
				</g>';
		}
		if ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs1" )
		{
			$image .= '
				<g id="zs1">
					<circle style="&gray;" cx="24" cy="33" r="1.5"/>
					<circle class="' . $class_zs1 . '" style="' . $colour_zs1 . '" cx="24" cy="33" r="1.5"/>
					<circle style="&gray;" cx="20" cy="41" r="1.5"/>
					<circle class="' . $class_zs1 . '" style="' . $colour_zs1 . '" cx="20" cy="41" r="1.5"/>
					<circle style="&gray;" cx="28" cy="41" r="1.5"/>
					<circle class="' . $class_zs1.'" style="' . $colour_zs1 . '" cx="28" cy="41" r="1.5"/>
				</g>';
		}
		if ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs7" )
		{
			$image .= '
				<g id="zs1">
					<circle style="' . $colour_zs7 . '" cx="24" cy="33" r="1.5"/>
					<circle style="' . $colour_zs7 . '" cx="20" cy="41" r="1.5"/>
				</g>';
		}
		if ( ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs7") || $marker)
		{
			$image .= '
				<g id="marker">
					<circle style="' . $colour_marker . '" cx="16" cy="33" r="1.5"/>
				</g>';
		}
		$image .= '
			</g>';
		$height = 60;
		return array($image, $height);
	}
}