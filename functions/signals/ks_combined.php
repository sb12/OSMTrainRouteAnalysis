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
Class KS_combined
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $this_speed int speed which is relevant for the signal
	 * @param $next_speed int speed which is relevant for the next signal (0 if stop or no next signal)
	 * @param $main_distance int distance to next main signal (0 if no relevant next main signal)
	 */
	public static function findState($tags, $this_speed, $next_speed, $main_distance)
	{
		$state = "";
		if(isset($tags["railway:signal:combined:states"]))
		{
			if ( $this_speed == 0 && strpos($tags["railway:signal:combined:states"], "hp0" )) // signal at end of route
			{
				$state = "hp0";
			}
			elseif ( $next_speed == 0 && $main_distance > 0 && strpos($tags["railway:signal:combined:states"], "ks2" )) // last distant signal of route
			{
				$state = "ks2";
			}
			elseif ( strpos($tags["railway:signal:combined:states"], "ks1" ) ) // default
			{
				$state = "ks1";
			}
			elseif ( strpos($tags["railway:signal:combined:states"], "ks2" ) ) // signal can not show ks1
			{
				$state = "ks2";
			}
			elseif ( strpos($tags["railway:signal:combined:states"], "hp0" ) ) // signal can only show hp0
			{
				$state = "hp0";
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
		
		// zs3v is not shown when distant speed is same or higher than speed
		if( isset($_GET["speed_distant"]) && isset($_GET["speed"]) && $_GET["speed_distant"] >= $_GET["speed"])
		{
			unset($_GET["speed_distant"]);
		}
		$colour_hp0 = "&red;";
		$colour_ks1 = "&green;";
		$colour_ks2 = "&yellow;";
		$colour_sh1 = "&gray;";
		$colour_zs1 = "&gray;";
		$colour_zs7 = "&gray;";
		$class_zs1 = "";
		$class_ks1 = "";
		if( isset($_GET["state_combined"]) )
		{
			if($_GET["state_combined"] == "hp0")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";	
				$colour_ks2 = "&gray;";			
			}
			if($_GET["state_combined"] == "ks1")
			{
				$colour_hp0 = "&gray;";
				$colour_ks1 = "&green;";
				$colour_ks2 = "&gray;";
				if( isset($_GET["speed_distant"]) )
				{
					$class_ks1 = "signal_blink";
				}
			}
			if($_GET["state_combined"] == "ks2")
			{
				$colour_hp0 = "&gray;";
				$colour_ks1 = "&gray;";
				$colour_ks2 = "&yellow;";
			}
			if($_GET["state_combined"] == "sh1")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";
				$colour_ks2 = "&gray;";
				$colour_sh1 = "&white;";
				$colour_zs1 = "&white;";
			}
			if($_GET["state_combined"] == "zs1" && isset( $_GET["railway:signal:combined:substitute_signal"] ) && $_GET["railway:signal:combined:substitute_signal"] == "DE-ESO:dr:zs1")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";
				$colour_ks2 = "&gray;";
				$colour_zs1 = "&white;";
				$class_zs1 = "signal_blink";
			}
			if($_GET["state_combined"] == "zs7" && isset($_GET["railway:signal:combined:substitute_signal"]) && $_GET["railway:signal:combined:substitute_signal"] == "DE-ESO:db:zs7")
			{
				$colour_hp0 = "&red;";
				$colour_ks1 = "&gray;";
				$colour_ks2 = "&gray;";
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
					<circle style="&gray;" cx="12" cy="29" r="4"/>
					<circle class="' . $class_ks1 . '" style="' . $colour_ks1 . '" cx="12" cy="29" r="4"/>
				</g>
					
				<g id="ks2">
					<circle style="' . $colour_ks2 . '" cx="28" cy="29" r="4"/>
				</g>
				<g id="sh1">';
		if ( ( isset($_GET["railway:signal:combined:substitute_signal"]) && $_GET["railway:signal:combined:substitute_signal"] == "DE-ESO:dr:zs1" ) || ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" ) )
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
		if ( isset($_GET["railway:signal:combined:substitute_signal"]) && $_GET["railway:signal:combined:substitute_signal"] == "DE-ESO:db:zs7" )
		{
			$image .= '
					<g id="zs7">
						<circle style="' . $colour_zs7 . '" cx="15" cy="39" r="2"/>
						<circle style="' . $colour_zs7 . '" cx="25" cy="39" r="2"/>
						<circle style="' . $colour_zs7 . '" cx="20" cy="49" r="2"/>
					</g>';
		}
		// signals with shortened distance to main
		if( ( isset($_GET["railway:signal:combined:shortened"]) && $_GET["railway:signal:combined:shortened"] == "yes" ) )
		{
			if( ( $_GET["state_combined"] == "ks2" ) || ( $class_ks1 == "signal_blink" ) ) // only when Ks 1 is blinking or Ks 2 is shown
			{
				$color_shortened = "&white;";
			}
			else
			{
				$color_shortened = "&gray;";
			}
			$image .= '
				<g id="shortened">
					<circle style="' . $color_shortened . '" cx="12" cy="8" r="2"/>
				</g>';
		}
		$image .= '
		</g>';
		$height = 60;
		return array($image, $height);
	}
}
