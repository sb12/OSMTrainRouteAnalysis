<?php 
    /**
    
    OSMTrainRouteAnalysis Copyright © 2014-2016 sb12 osm.mapper999@gmail.com
    
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
Class KS_main extends SignalPart
{	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($position)
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

		$geometry = "6,1 34,1 34,59 6,59";
		$r_main = 4;
		$r_minor = 1.5;
		$lights[] = Array(
				'id'        =>	'hp0',
				'colour'    => $colour_hp0,
				'cx'        => 20,
				'cy'        => 16,
				'r'         => $r_main,
		);
		$lights[] = Array(
				'id'        =>	'ks1',
				'colour'    => $colour_ks1,
				'cx'        => 20,
				'cy'        => 29,
				'r'         => $r_main,
		);
		if ( ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:dr:zs1" ) || ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" ) )
		{
			$lights[] = Array(
					'id'        => 'zs1_bg',
					'colour'    => '&gray;',
					'cx'        => 20,
					'cy'        => 39,
					'r'         => $r_minor
			);
			$lights[] = Array(
					'id'        => 'zs1',
					'colour'    => $colour_zs1,
					'colour'    => $class_zs1,
					'cx'        => 20,
					'cy'        => 39,
					'r'         => $r_minor
			);
		}
		if ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" )
		{
			$lights[] = Array(
					'id'        => 'sh1',
					'colour'    => $colour_sh1,
					'cx'        => 10,
					'cy'        => 49,
					'r'         => $r_minor
			);
		}
		if ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs7" )
		{
			$lights[] = Array(
					'id'        => 'zs7_1',
					'colour'    => $colour_zs7,
					'cx'        => 15,
					'cy'        => 39,
					'r'         => $r_minor
			);
			$lights[] = Array(
					'id'        => 'zs7_1',
					'colour'    => $colour_zs7,
					'cx'        => 25,
					'cy'        => 39,
					'r'         => $r_minor
			);
			$lights[] = Array(
					'id'        => 'zs7_1',
					'colour'    => $colour_zs7,
					'cx'        => 20,
					'cy'        => 49,
					'r'         => $r_minor
			);
		}
		return Signal_Light::generateImage($position,60,$geometry,$lights);
	}	
}