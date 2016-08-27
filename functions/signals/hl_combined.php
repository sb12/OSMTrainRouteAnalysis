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
 * German Hl Combined Signal
 * @author sb12
 *
 */
Class HL_combined extends Signals
{

	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */

	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($position)
	{

		$colour_gelb1 = "&yellow;";
		$colour_gelb2 = "&yellow;";
		$colour_gruen = "&green;";
		$colour_rot1 = "&red;";
		$colour_rot2 = "&gray;";
		$colour_stripes1 = "&yellow;";
		$colour_stripes2 = "&green;";
		$colour_ra12 = "&gray;";
		$colour_zs1 = "&gray;";
		$class_zs1 = "";
		$class_gelb1 = "";
		$class_gruen = "";
	
		$show_rot = $show_gruen = $show_gelb1 = $show_gelb2 = $show_stripes1 = $show_stripes2 = true;
		if( isset($_GET["railway:signal:combined:states"]) )
		{
			$states = self::signalStates($_GET["railway:signal:combined:states"], "DE-ESO");
		
			$show_rot = $show_gruen = $show_gelb1 = $show_gelb2 = $show_stripes1 = $show_stripes2 = false;
			
			if( strpos($_GET["railway:signal:combined:states"], "hp0"))
			{
				$show_rot = true;
			}
			
			if( in_array("hl1", $states)
					|| in_array("hl2", $states)
					|| in_array("hl3a", $states)
					|| in_array("hl3b", $states)
					|| in_array("hl4", $states)
					|| in_array("hl5", $states)
					|| in_array("hl6a", $states)
					|| in_array("hl6b", $states)
					)
			{
				$show_gruen = true;
			}
			
			if( in_array("hl7", $states)
					|| in_array("hl8", $states)
					|| in_array("hl9a", $states)
					|| in_array("hl9b", $states)
					|| in_array("hl10", $states)
					|| in_array("hl11", $states)
					|| in_array("hl12a", $states)
					|| in_array("hl12b", $states)
					)
			{
				$show_gelb1 = true;
			}
			
			if( in_array("hl2", $states)
					|| in_array("hl3a", $states)
					|| in_array("hl3b", $states)
					|| in_array("hl5", $states)
					|| in_array("hl6a", $states)
					|| in_array("hl6b", $states)
					|| in_array("hl8", $states)
					|| in_array("hl9a", $states)
					|| in_array("hl9b", $states)
					|| in_array("hl11", $states)
					|| in_array("hl12a", $states)
					|| in_array("hl12b", $states)
					)
			{
				$show_gelb2 = true;
			}
			
			if( in_array("hl3b", $states)
					|| in_array("hl6b", $states)
					|| in_array("hl9b", $states)
					|| in_array("hl12b", $states)
					)
			{
				$show_stripes1 = true;
			}
			
			if( in_array("hl2", $states)
					|| in_array("hl5", $states)
					|| in_array("hl8", $states)
					|| in_array("hl11", $states)
					)
			{
				$show_stripes2 = true;
			}
		}
		
		if( isset($_GET["state_combined"]) )
		{
			if($_GET["state_combined"] == "hp0")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&red;";	
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";	
			}
			if($_GET["state_combined"] == "hl1")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
			}
			if($_GET["state_combined"] == "hl2")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&green;";	
			}
			if($_GET["state_combined"] == "hl3a")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
			}
			if($_GET["state_combined"] == "hl3b")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&yellow;";
				$colour_stripes2 = "&gray;";
			}
			if($_GET["state_combined"] == "hl4")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";	
				$class_gruen = "signal_blink";
			}
			if($_GET["state_combined"] == "hl5")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&green;";
				$class_gruen = "signal_blink";
			}
			if($_GET["state_combined"] == "hl6a")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
				$class_gruen = "signal_blink";
			}
			if($_GET["state_combined"] == "hl6b")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&yellow;";
				$colour_stripes2 = "&gray;";
				$class_gruen = "signal_blink";
			}
			if($_GET["state_combined"] == "hl7")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";	
				$class_gelb1 = "signal_blink";
			}
			if($_GET["state_combined"] == "hl8")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&green;";	
				$class_gelb1 = "signal_blink";
			}
			if($_GET["state_combined"] == "hl9a")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";	
				$class_gelb1 = "signal_blink";
			}
			if($_GET["state_combined"] == "hl9b")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&yellow;";
				$colour_stripes2 = "&gray;";	
				$class_gelb1 = "signal_blink";
			}
			if($_GET["state_combined"] == "hl10")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
			}
			if($_GET["state_combined"] == "hl11")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&green;";	
			}
			if($_GET["state_combined"] == "hl12a")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";	
			}
			if($_GET["state_combined"] == "hl12b")
			{
				$colour_gelb1 = "&yellow;";
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&yellow;";
				$colour_stripes2 = "&gray;";	
			}
			if($_GET["state_combined"] == "sh1" && isset( $_GET["railway:signal:minor"] ) && $_GET["railway:signal:minor"] == "DE-ESO:dr:ra12")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&red;";	
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
				$colour_ra12 = "&white;";
				$colour_zs1 = "&white;";
			}
			if($_GET["state_combined"] == "zs1" && isset( $_GET["railway:signal:combined:substitute_signal"] ) && $_GET["railway:signal:combined:substitute_signal"] == "DE-ESO:dr:zs1")
			{
				$colour_gelb1 = "&gray;";
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&red;";	
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
				$colour_zs1 = "&white;";
				$class_zs1 = "signal_blink";
			}
		}
	
	
		$geometry = "6,6 11,1 29,1 34,6 34,55 6,55";
		$r_main = 4;
		$r_minor = 1.5;
	
		if($show_gelb1)
		{
			$lights[] = Array(
					'id'        => 'gelb1',
					'colour'    => '&gray;',
					'cx'        => 12,
					'cy'        => 12,
					'r'         => $r_main
			);
			$lights[] = Array(
					'id'        => 'gelb1',
					'colour'    => $colour_gelb1,
					'class'		=> $class_gelb1,
					'cx'        => 12,
					'cy'        => 12,
					'r'         => $r_main
			);
		}
		if($show_gruen)
		{
			$lights[] = Array(
					'id'        => 'gruen',
					'colour'    => '&gray;',
					'cx'        => 28,
					'cy'        => 12,
					'r'         => $r_main
			);
			$lights[] = Array(
					'id'        => 'gruen',
					'colour'    => $colour_gruen,
					'class'		=> $class_gruen,
					'cx'        => 28,
					'cy'        => 12,
					'r'         => $r_main
			);
		}
		if($show_rot)
		{
			$lights[] = Array(
					'id'        => 'rot',
					'colour'    => $colour_rot1,
					'cx'        => 20,
					'cy'        => 29,
					'r'         => $r_main
			);
			$lights[] = Array(
					'id'        => 'rot2',
					'colour'    => $colour_rot2,
					'cx'        => 28,
					'cy'        => 46,
					'r'         => $r_main
			);
		}
		if($show_gelb2)
		{
			$lights[] = Array(
					'id'        => 'gelb2',
					'colour'    => $colour_gelb2,
					'cx'        => 12,
					'cy'        => 46,
					'r'         => $r_main
			);
		}

		if ( ( isset($_GET["railway:signal:combined:substitute_signal"]) && $_GET["railway:signal:combined:substitute_signal"] == "DE-ESO:dr:zs1" ) || ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" ) )
		{
			$lights[] = Array(
					'id'        => 'zs1',
					'colour'    => '&gray;',
					'cx'        => 12,
					'cy'        => 37,
					'r'         => $r_minor
			);
			$lights[] = Array(
					'id'        => 'zs1',
					'colour'    => $colour_zs1,
					'class'    	=> $class_zs1,
					'cx'        => 12,
					'cy'        => 37,
					'r'         => $r_minor
			);
		}
		if ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" )
		{
			$lights[] = Array(
					'id'        => 'ra12',
					'colour'    => $colour_ra12,
					'cx'        => 28,
					'cy'        => 21,
					'r'         => $r_minor
			);
		}
		$image1 = Signal_Light::generateImage($position,55,$geometry,$lights);
		
		//delete lights
		$lights = Array();
		
		$geometry = "6,2 34,2 34,13 6,13";
		
		if ( $show_stripes1 || $show_stripes2 )
		{
			if( $show_stripes1 )
			{
				$lights[] = Array(
						'id'        => 'stripes1_1',
						'colour'    => $colour_stripes1,
						'cx'        => 11,
						'cy'        => 5,
						'r'         => $r_minor
				);
				$lights[] = Array(
						'id'        => 'stripes1_2',
						'colour'    => $colour_stripes1,
						'cx'        => 17,
						'cy'        => 5,
						'r'         => $r_minor
				);
				$lights[] = Array(
						'id'        => 'stripes1_3',
						'colour'    => $colour_stripes1,
						'cx'        => 23,
						'cy'        => 5,
						'r'         => $r_minor
				);
				$lights[] = Array(
						'id'        => 'stripes1_4',
						'colour'    => $colour_stripes1,
						'cx'        => 29,
						'cy'        => 5,
						'r'         => $r_minor
				);
			}
			if( $show_stripes2 )
			{
				$lights[] = Array(
						'id'        => 'stripes2_1',
						'colour'    => $colour_stripes2,
						'cx'        => 11,
						'cy'        => 10,
						'r'         => $r_minor
				);
				$lights[] = Array(
						'id'        => 'stripes2_2',
						'colour'    => $colour_stripes2,
						'cx'        => 17,
						'cy'        => 10,
						'r'         => $r_minor
				);
				$lights[] = Array(
						'id'        => 'stripes2_3',
						'colour'    => $colour_stripes2,
						'cx'        => 23,
						'cy'        => 10,
						'r'         => $r_minor
				);
				$lights[] = Array(
						'id'        => 'stripes2_4',
						'colour'    => $colour_stripes2,
						'cx'        => 29,
						'cy'        => 10,
						'r'         => $r_minor
				);
			}
			$image2 = Signal_Light::generateImage($position+55,13,$geometry,$lights);
			return array($image1[0].$image2[0], $image1[1]+$image2[1]);
		}
		else
		{
			return $image1;
		}
	}
}
