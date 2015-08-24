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
 * German Ks Distant Signal
 * @author sb12
 *
 */
Class KS_distant
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
			if ( $next_speed_distant == 0 && strpos($tags["railway:signal:distant:states"], "ks2" )) // last distant signal of route
			{
				$state = "ks2";
			}
			elseif ( strpos($tags["railway:signal:distant:states"], "ks1" ) ) // default
			{
				$state = "ks1";
			}
			elseif ( strpos($tags["railway:signal:distant:states"], "ks2" ) ) // signal can not show ks1
			{
				$state = "ks2";
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
		
		$colour_ks1 = "&green;";
		$colour_ks2 = "&yellow;";
		$class_ks1 = "";
		if(isset($_GET["state_distant"]))
		{
			if($_GET["state_distant"] == "ks1")
			{
				$colour_ks1 = "&green;";
				$colour_ks2 = "&gray;";
				if(isset($_GET["speed_distant"]))
				{
					$class_ks1 = "signal_blink";
				}
			}
			if($_GET["state_distant"] == "ks2")
			{
				$colour_ks1 = "&gray;";
				$colour_ks2 = "&yellow;";
			}
		}
		
		$image = '
			<g transform="translate(0 ' . $height . ')">
				<g>
					<polygon style="&background;" points="6,1 34,1 34,49 6,49"/>
				</g>
					
				<g id="ks1">
					<circle style="&gray;" cx="12" cy="24" r="4"/>
					<circle class="' . $class_ks1 . '" style="' . $colour_ks1 . '" cx="12" cy="24" r="4"/>
				</g>
					
				<g id="ks2">
					<circle style="' . $colour_ks2 . '" cx="28" cy="24" r="4"/>
				</g>';
		// repeated signals
		if( ( isset($_GET["railway:signal:distant:repeated"]) && $_GET["railway:signal:distant:repeated"] == "yes" ) )
		{
			if( ( $_GET["state_distant"] == "ks2" ) || ( $class_ks1 == "signal_blink" ) ) // only when Ks 1 is blinking or Ks 2 is shown
			{
				$color_additional_light = "&white;";
			}
			else
			{
				$color_additional_light = "&gray;";
			}
			$image .= '
				<g id="repeated">
					<circle style="' . $color_additional_light . '" cx="10" cy="39" r="2"/>
				</g>';
		}
		// signals with shortened distance to main
		if( ( isset($_GET["railway:signal:distant:shortened"]) && $_GET["railway:signal:distant:shortened"] == "yes" ) )
		{
			if( ( $_GET["state_distant"] == "ks2" ) || ( $class_ks1 == "signal_blink" ) ) // only when Ks 1 is blinking or Ks 2 is shown
			{
				$color_shortened = "&white;";
			}
			else
			{
				$color_shortened = "&gray;";
			}
			$image .= '
				<g id="repeated">
					<circle style="' . $color_shortened . '" cx="12" cy="10" r="2"/>
				</g>';
		}
		$image .= '
		</g>';
		$height = 50;
		return array($image, $height);
	}
}