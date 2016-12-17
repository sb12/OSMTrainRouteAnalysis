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
Class KS_distant extends SignalPart
{
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($position)
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
				if( ( isset($_GET["speed_distant"]) && $_GET["speed_distant"] > 0 && isset($_GET["railway:signal:speed_limit_distant"]) && $_GET["railway:signal:speed_limit_distant"]=="DE-ESO:zs3v" )
						|| ( isset($_GET["railway:signal:speed_limit_distant"]) && $_GET["railway:signal:speed_limit_distant"]=="DE-ESO:zs3v" && isset($_GET["railway:signal:speed_limit_distant:form"]) && $_GET["railway:signal:speed_limit_distant:form"]=="sign" ) )
				{
					$class_ks1 = "signal_blink";
				}
			}
			if($_GET["state_distant"] == "ks2")
			{
				$colour_ks1 = "&gray;";
				$colour_ks2 = "&yellow;";
			}
			if($_GET["state_distant"] == "off")
			{
				$colour_ks1 = "&gray;";
				$colour_ks2 = "&gray;";
			}
		}

		$geometry = "6,1 34,1 34,49 6,49";
		$r_main = 4;
		$r_minor = 1.5;
				
		// signals with shortened distance to main: upper white additional light
		// TODO: or Kennlicht
		if( ( isset($_GET["railway:signal:distant:shortened"]) && $_GET["railway:signal:distant:shortened"] == "yes" ) )
		{
			if( ( $_GET["state_distant"] == "ks2" ) || ( $class_ks1 == "signal_blink" ) ) // only when Ks 1 is blinking or Ks 2 is shown
			{
				$colour_additional_light_upper = "&white;";
			}
			else
			{
				$colour_additional_light_upper = "&gray;";
			}
			
			$lights[] = Array(
					'id'        => 'repeated',
					'colour'    => $colour_additional_light_upper,
					'cx'        => 13,
					'cy'        => 10,
					'r'         => $r_minor,
			);
		}


		$lights[] = Array(
				'id'        => 'ks1_bg',
				'colour'    => '&gray;',
				'cx'        => 13,
				'cy'        => 24,
				'r'         => $r_main,
		);

		// two big lights
		$lights[] = Array(
				'id'        => 'ks1',
				'colour'    => $colour_ks1,
				'class'     => $class_ks1,
				'cx'        => 13,
				'cy'        => 24,
				'r'         => $r_main,
		);
			
		$lights[] = Array(
				'id'        => 'ks2',
				'colour'    => $colour_ks2,
				'cx'        => 27,
				'cy'        => 24,
				'r'         => $r_main,
		);

		// repeated signals: lower white additional light
		if( ( isset($_GET["railway:signal:distant:repeated"]) && $_GET["railway:signal:distant:repeated"] == "yes" ) )
		{
			if( ( isset($_GET["state_distant"]) && $_GET["state_distant"] == "ks2" ) || ( $class_ks1 == "signal_blink" ) ) // only when Ks 1 is blinking or Ks 2 is shown
			{
				$colour_additional_light_lower = "&white;";
			}
			else
			{
				$colour_additional_light_lower = "&gray;";
			}
			
			$lights[] = Array(
					'id'        => 'repeated',
					'colour'    => $colour_additional_light_lower,
					'cx'        => 13,
					'cy'        => 39,
					'r'         => $r_minor,
			);
		}
		return Signal_Light::generateImage($position,50,$geometry,$lights);
	}
}
