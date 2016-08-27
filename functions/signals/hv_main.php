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
 * German H/V Main Signal
 * @author sb12
 *
 */
Class HV_main extends SignalPart
{

	public function __construct($tags)
	{
		parent::__construct($tags);
	}
	
	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 *//*
	public function possibleSpeedsMain()
	{
		if( count($this->states) > 0)
		{	
			if( in_array($this->states,"hp0") )
			{
				$speed_array[]=0;
			}
			if( in_array($this->states,"hp1") )
			{
				$speed_array[]=-1; // no limit
			}
			if( in_array($this->states,"hp2") )
			{
				$speed_array[]=40;
				$speed_array[]=60;
			}
		}
		else
		{
			$speed_array[]=0;
			$speed_array[]=-1;
		}
		return $speed_array;
	}
	
	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	/*public static function findState($tags, $next_speed, $main_distance)
	{
		$state = "";
		if(isset($tags["railway:signal:main:states"]))
		{
			if ( $next_speed == 0 && strpos($tags["railway:signal:main:states"], "hp0" )) // signal at end of route
			{
				$state = "hp0";
			}
			elseif ( $main_distance < 600 && strpos($tags["railway:signal:main:states"], "kennlicht" ) )
			{
				$state = "kennlicht";
			}
			elseif ( $next_speed > 60 && strpos($tags["railway:signal:main:states"], "hp1" ) )
			{
				$state = "hp1";
			}
			elseif ( $next_speed <= 60 && strpos ( $tags["railway:signal:main:states"], "hp2" ) )
			{
				$state = "hp2";
			}
			elseif ( $next_speed > 60 && strpos ( $tags["railway:signal:main:states"], "hp2" ) )
			{
				$state = "hp2";
			}
		}
		return $state;
	}*/


	/**
	 * generate image
	 * @param $position int y-position of the signal image
	 */
	public static function generateImage($position)
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
	
				if( $_GET["railway:signal:main:form"] == "light" )
				{
					$geometry = "6,1 34,1 34,59 6,59";
					$r_main = 4;
					$r_minor = 1.5;
					$lights[] = Array(
							'id'        =>	'hp0',
							'colour'    => $colour_hp0,
							'cx'        => 13,
							'cy'        => 23,
							'r'         => $r_main,
					);
					$lights[] = Array(
							'id'        =>	'hp1',
							'colour'    => $colour_hp1,
							'cx'        => 13,
							'cy'        => 11,
							'r'         => $r_main,
					);
	
					$marker = false;
					if ( isset ( $_GET["railway:signal:main:states"] ) )
					{
						if ( strpos( $_GET["railway:signal:main:states"], "hp2" ) )
						{
							$lights[] = Array(
									'id'        =>	'hp2',
									'colour'    => $colour_hp2,
									'cx'        => 13,
									'cy'        => 50,
									'r'         => $r_main,
							);
						}
						if ( strpos( $_GET["railway:signal:main:states"], "kennlicht" ) )
						{
							$marker = true;
						}
					}
					else
					{
						$lights[] = Array(
								'id'        => 'hp2',
								'colour'    => $colour_hp2,
								'cx'        => 13,
								'cy'        => 50,
								'r'         => $r_main,
						);
					}
					if ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" )
					{
						$lights[] = Array(
								'id'        => 'hp00',
								'colour'    => $colour_hp00,
								'cx'        => 27,
								'cy'        => 23,
								'r'         => $r_main,
						);
						$lights[] = Array(
								'id'        => 'sh1_1',
								'colour'    => $colour_sh1,
								'cx'        => 20,
								'cy'        => 33,
								'r'         => $r_minor,
						);
						$lights[] = Array(
								'id'        => 'sh1_2',
								'colour'    => $colour_sh1,
								'cx'        => 12,
								'cy'        => 41,
								'r'         => $r_minor,
						);
					}
					if ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs1" )
					{
						$lights[] = Array(
								'id'        => 'zs1_1',
								'class'     => $class_zs1,
								'colour'    => $colour_zs1,
								'cx'        => 24,
								'cy'        => 33,
								'r'         => $r_minor,
						);
						$lights[] = Array(
								'id'        => 'zs1_2',
								'class'     => $class_zs1,
								'colour'    => $colour_zs1,
								'cx'        => 20,
								'cy'        => 41,
								'r'         => $r_minor,
						);
						$lights[] = Array(
								'id'        => 'zs1_3',
								'class'     => $class_zs1,
								'colour'    => $colour_zs1,
								'cx'        => 28,
								'cy'        => 41,
								'r'         => $r_minor,
						);
					}
					if ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs7" )
					{
						$lights[] = Array(
								'id'        => 'zs7_1',
								'colour'    => $colour_zs7,
								'cx'        => 24,
								'cy'        => 33,
								'r'         => $r_minor,
						);
						$lights[] = Array(
								'id'        => 'zs7_2',
								'colour'    => $colour_zs7,
								'cx'        => 20,
								'cy'        => 41,
								'r'         => $r_minor,
						);
					}
					if ( ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:db:zs7") || $marker)
					{
						$lights[] = Array(
								'id'        => 'marker',
								'colour'    => $colour_marker,
								'cx'        => 16,
								'cy'        => 33,
								'r'         => $r_minor,
						);
					}
					return Signal_Light::generateImage($position,60,$geometry,$lights);
				}
	}
}
