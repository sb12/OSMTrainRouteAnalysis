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
Class HL_combined
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed, $next_speed_distant, $main_distance)
	{
		$state = "";
		if(isset($tags["railway:signal:combined:states"]))
		{
			if ( $next_speed == 0 && strpos($tags["railway:signal:combined:states"], "hp0" )) // signal at end of route
			{
				$state = "hp0";
			}
			// last distant signal of route
			elseif ( $next_speed_distant == 0  && (
					 strpos($tags["railway:signal:combined:states"], "hl10")
					|| ( strpos($tags["railway:signal:combined:states"], "hl11") &&  $next_speed == 100 )
					|| ( strpos($tags["railway:signal:combined:states"], "hl12a") &&  $next_speed == 40 )
					|| ( strpos($tags["railway:signal:combined:states"], "hl12b") &&  $next_speed == 60 ) ) )
			{
				if( ( $next_speed == 100 || $main_distance < 700 ) && strpos($tags["railway:signal:combined:states"], "hl11" ))
				{
					$state = "hl11";
				}
				elseif( $next_speed == 40 && strpos($tags["railway:signal:combined:states"], "hl12a" ))
				{
					$state = "hl12a";
				}
				elseif( $next_speed == 60 && strpos($tags["railway:signal:combined:states"], "hl12b" ))
				{
					$state = "hl12b";
				}
				elseif( strpos($tags["railway:signal:combined:states"], "hl10" ) )
				{
					$state = "hl10";
				}
			}
			elseif ( ( $next_speed_distant == 40 || $next_speed_distant == 60 ) && (
					 strpos($tags["railway:signal:combined:states"], "hl7")
					|| ( strpos($tags["railway:signal:combined:states"], "hl8") &&  ( $next_speed == 100 || $main_distance < 700 ) )
					|| ( strpos($tags["railway:signal:combined:states"], "hl9a") &&  $next_speed == 40 )
					|| ( strpos($tags["railway:signal:combined:states"], "hl9b") &&  $next_speed == 60 ) ) )
			{
				if( ( $next_speed == 100 || $main_distance < 700 ) && strpos($tags["railway:signal:combined:states"], "hl8" ))
				{
					$state = "hl8";
				}
				elseif( $next_speed == 40 && strpos($tags["railway:signal:combined:states"], "hl9a" ))
				{
					$state = "hl9a";
				}
				elseif( $next_speed == 60 && strpos($tags["railway:signal:combined:states"], "hl9b" ))
				{
					$state = "hl9b";
				}
				elseif( strpos($tags["railway:signal:combined:states"], "hl7" ) )
				{
					$state = "hl7";
				}
			}
			elseif ( $next_speed_distant == 100 && (
					 strpos($tags["railway:signal:combined:states"], "hl4")
					|| ( strpos($tags["railway:signal:combined:states"], "hl5") &&  $next_speed == 100 )
					|| ( strpos($tags["railway:signal:combined:states"], "hl6a") &&  $next_speed == 40 )
					|| ( strpos($tags["railway:signal:combined:states"], "hl6b") &&  $next_speed == 60 ) ) )
			{
				if( ( $next_speed == 100 || $main_distance < 700 ) && strpos($tags["railway:signal:combined:states"], "hl5" ))
				{
					$state = "hl5";
				}
				elseif( $next_speed == 40 && strpos($tags["railway:signal:combined:states"], "hl6a" ))
				{
					$state = "hl6a";
				}
				elseif( $next_speed == 60 && strpos($tags["railway:signal:combined:states"], "hl6b" ))
				{
					$state = "hl6b";
				}
				elseif( strpos($tags["railway:signal:combined:states"], "hl4" ) )
				{
					$state = "hl4";
				}
			}
			elseif (  strpos($tags["railway:signal:combined:states"], "hl1")
					|| ( strpos($tags["railway:signal:combined:states"], "hl2") &&  $next_speed == 100 )
					|| ( strpos($tags["railway:signal:combined:states"], "hl3a") &&  $next_speed == 40 )
					|| ( strpos($tags["railway:signal:combined:states"], "hl3b") &&  $next_speed == 60 ) ) 
			{
				if( ( $next_speed == 100 || $main_distance < 700 ) && strpos($tags["railway:signal:combined:states"], "hl2" ))
				{
					$state = "hl2";
				}
				elseif( $next_speed == 40 && strpos($tags["railway:signal:combined:states"], "hl3a" ))
				{
					$state = "hl3a";
				}
				elseif( $next_speed == 60 && strpos($tags["railway:signal:combined:states"], "hl3b" ))
				{
					$state = "hl3b";
				}
				elseif( strpos($tags["railway:signal:combined:states"], "hl1" ) )
				{
					$state = "hl1";
				}
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
		return Lang::l_("German Hl");
	}
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
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
			$show_rot = $show_gruen = $show_gelb1 = $show_gelb2 = $show_stripes1 = $show_stripes2 = false;
			
			if( strpos($_GET["railway:signal:combined:states"], "hp0"))
			{
				$show_rot = true;
			}
			
			if( strpos($_GET["railway:signal:combined:states"], "hl1")
					|| strpos($_GET["railway:signal:combined:states"], "hl2")
					|| strpos($_GET["railway:signal:combined:states"], "hl3a")
					|| strpos($_GET["railway:signal:combined:states"], "hl3b")
					|| strpos($_GET["railway:signal:combined:states"], "hl4")
					|| strpos($_GET["railway:signal:combined:states"], "hl5")
					|| strpos($_GET["railway:signal:combined:states"], "hl6a")
					|| strpos($_GET["railway:signal:combined:states"], "hl6b")
					)
			{
				$show_gruen = true;
			}
			
			if( strpos($_GET["railway:signal:combined:states"], "hl7")
					|| strpos($_GET["railway:signal:combined:states"], "hl8")
					|| strpos($_GET["railway:signal:combined:states"], "hl9a")
					|| strpos($_GET["railway:signal:combined:states"], "hl9b")
					|| strpos($_GET["railway:signal:combined:states"], "hl10")
					|| strpos($_GET["railway:signal:combined:states"], "hl11")
					|| strpos($_GET["railway:signal:combined:states"], "hl12a")
					|| strpos($_GET["railway:signal:combined:states"], "hl12b")
					)
			{
				$show_gelb1 = true;
			}
			
			if( strpos($_GET["railway:signal:combined:states"], "hl2")
					|| strpos($_GET["railway:signal:combined:states"], "hl3a")
					|| strpos($_GET["railway:signal:combined:states"], "hl3b")
					|| strpos($_GET["railway:signal:combined:states"], "hl5")
					|| strpos($_GET["railway:signal:combined:states"], "hl6a")
					|| strpos($_GET["railway:signal:combined:states"], "hl6b")
					|| strpos($_GET["railway:signal:combined:states"], "hl8")
					|| strpos($_GET["railway:signal:combined:states"], "hl9a")
					|| strpos($_GET["railway:signal:combined:states"], "hl9b")
					|| strpos($_GET["railway:signal:combined:states"], "hl11")
					|| strpos($_GET["railway:signal:combined:states"], "hl12a")
					|| strpos($_GET["railway:signal:combined:states"], "hl12b")
					)
			{
				$show_gelb2 = true;
			}
			
			if( strpos($_GET["railway:signal:combined:states"], "hl3b")
					|| strpos($_GET["railway:signal:combined:states"], "hl6b")
					|| strpos($_GET["railway:signal:combined:states"], "hl9b")
					|| strpos($_GET["railway:signal:combined:states"], "hl12b")
					)
			{
				$show_stripes1 = true;
			}
			
			if( strpos($_GET["railway:signal:combined:states"], "hl2")
					|| strpos($_GET["railway:signal:combined:states"], "hl5")
					|| strpos($_GET["railway:signal:combined:states"], "hl8")
					|| strpos($_GET["railway:signal:combined:states"], "hl11")
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
		
		$image = '
			<g transform="translate(0 ' . $height . ')">
				<g>
					<polygon style="&background;" points="6,6 11,1 29,1 34,6 34,55 6,55"/>
				</g>
					';
		if($show_gelb1)
		{
			$image .= '
				<g id="gelb1">
					<circle style="&gray;" cx="12" cy="12" r="4"/>
					<circle class="' . $class_gelb1 . '" style="' . $colour_gelb1 . '" cx="12" cy="12" r="4"/>
				</g>
					';
		}
		if($show_gruen)
		{
			$image .= '
				<g id="gruen">
					<circle style="&gray;" cx="28" cy="12" r="4"/>
					<circle class="' . $class_gruen . '" style="' . $colour_gruen . '" cx="28" cy="12" r="4"/>
				</g>
					
					';
		}
		if($show_rot)
		{
			$image .= '
				<g id="rot">
					<circle style="' . $colour_rot1 . '" cx="20" cy="29" r="4"/>
				</g>
					
					';
		}
		if($show_gelb2)
		{
			$image .= '
				<g id="gelb2">
					<circle style="' . $colour_gelb2 . '" cx="12" cy="46" r="4"/>
				</g>
					';
		}
		if($show_rot)
		{
			$image .= '
				<g id="rot2">
					<circle style="' . $colour_rot2 . '" cx="28" cy="46" r="4"/>
				</g>
					';
		}
		$image .= '
						
				<g id="ra12">';
		if ( ( isset($_GET["railway:signal:combined:substitute_signal"]) && $_GET["railway:signal:combined:substitute_signal"] == "DE-ESO:dr:zs1" ) || ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" ) )
		{
			$image .= '
					<circle style="&gray;" cx="12" cy="37" r="2"/>
					<circle class="' . $class_zs1 . '" style="' . $colour_zs1 . '" cx="12" cy="37" r="2"/>';
		}
		if ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" )
		{
			$image .= '
					<circle style="' . $colour_ra12 . '" cx="28" cy="21" r="2"/>';
		}
		$image .= '
				</g>';
		$height = 55;
		if ( $show_stripes1 || $show_stripes2 )
		{
			$image .= '
				<g>
					<polygon style="&background;" points="6,57 34,57 34,68 6,68"/>
						';
			if( $show_stripes1 )
			{
				$image .= '
					<circle style="' . $colour_stripes1 . '" cx="11" cy="60" r="2"/>
					<circle style="' . $colour_stripes1 . '" cx="17" cy="60" r="2"/>
					<circle style="' . $colour_stripes1 . '" cx="23" cy="60" r="2"/>
					<circle style="' . $colour_stripes1 . '" cx="29" cy="60" r="2"/>
						';
			}
			if( $show_stripes2 )
			{
				$image .= '
					<circle style="' . $colour_stripes2 . '" cx="11" cy="65" r="2"/>
					<circle style="' . $colour_stripes2 . '" cx="17" cy="65" r="2"/>
					<circle style="' . $colour_stripes2 . '" cx="23" cy="65" r="2"/>
					<circle style="' . $colour_stripes2 . '" cx="29" cy="65" r="2"/>
							';
			}
			$image .= '
				</g>
							';
			$height = 68;
		}
		$image .= '
		</g>';
		return array($image, $height);
	}
}
