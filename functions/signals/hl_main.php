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
Class HL_Main extends SignalPart
{

	public function __construct($tags)
	{
		parent::__construct($tags);
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
		$colour_sh1 = "&gray;";
		$colour_zs1 = "&gray;";
		$class_zs1 = "";
		$class_gruen = "";

		$show_rot = $show_gruen = $show_gelb2 = $show_stripes1 = $show_stripes2 = true;
		if( isset($_GET["railway:signal:main:states"]) )
		{
			$show_rot = $show_gruen = $show_gelb2 = $show_stripes1 = $show_stripes2 = false;
			
			if( strpos($_GET["railway:signal:main:states"], "hp0"))
			{
				$show_rot = true;
			}
			
			if( strpos($_GET["railway:signal:main:states"], "hl1")
					|| strpos($_GET["railway:signal:main:states"], "hl2")
					|| strpos($_GET["railway:signal:main:states"], "hl3a")
					|| strpos($_GET["railway:signal:main:states"], "hl3b")
					|| strpos($_GET["railway:signal:main:states"], "hl4")
					|| strpos($_GET["railway:signal:main:states"], "hl5")
					|| strpos($_GET["railway:signal:main:states"], "hl6a")
					|| strpos($_GET["railway:signal:main:states"], "hl6b")
					)
			{
				$show_gruen = true;
			}
			
			if( strpos($_GET["railway:signal:main:states"], "hl2")
					|| strpos($_GET["railway:signal:main:states"], "hl3a")
					|| strpos($_GET["railway:signal:main:states"], "hl3b")
					|| strpos($_GET["railway:signal:main:states"], "hl5")
					|| strpos($_GET["railway:signal:main:states"], "hl6a")
					|| strpos($_GET["railway:signal:main:states"], "hl6b")
					)
			{
				$show_gelb2 = true;
			}
			
			if( strpos($_GET["railway:signal:main:states"], "hl3b")
					|| strpos($_GET["railway:signal:main:states"], "hl6b")
					)
			{
				$show_stripes1 = true;
			}
			
			if( strpos($_GET["railway:signal:main:states"], "hl2")
					|| strpos($_GET["railway:signal:main:states"], "hl5")
					)
			{
				$show_stripes2 = true;
			}
		}
		
		if( isset($_GET["state_main"]) )
		{
			if($_GET["state_main"] == "hp0")
			{
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&red;";	
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";	
			}
			if($_GET["state_main"] == "hl1")
			{
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
			}
			if($_GET["state_main"] == "hl2")
			{
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&green;";	
			}
			if($_GET["state_main"] == "hl3a")
			{
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
			}
			if($_GET["state_main"] == "hl3b")
			{
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&yellow;";
				$colour_stripes2 = "&gray;";
			}
			if($_GET["state_main"] == "hl4")
			{
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";	
				$class_gruen = "signal_blink";
			}
			if($_GET["state_main"] == "hl5")
			{
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&green;";
				$class_gruen = "signal_blink";
			}
			if($_GET["state_main"] == "hl6a")
			{
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
				$class_gruen = "signal_blink";
			}
			if($_GET["state_main"] == "hl6b")
			{
				$colour_gelb2 = "&yellow;";
				$colour_gruen = "&green;";
				$colour_rot1 = "&gray;";
				$colour_stripes1 = "&yellow;";
				$colour_stripes2 = "&gray;";
				$class_gruen = "signal_blink";
			}
			if($_GET["state_main"] == "sh1" && isset( $_GET["railway:signal:minor"] ) && $_GET["railway:signal:minor"] == "DE-ESO:dr:ra12")
			{
				$colour_gelb2 = "&gray;";
				$colour_gruen = "&gray;";
				$colour_rot1 = "&red;";	
				$colour_stripes1 = "&gray;";
				$colour_stripes2 = "&gray;";
				$colour_sh1 = "&white;";
				$colour_zs1 = "&white;";
			}
			if($_GET["state_main"] == "zs1" && isset( $_GET["railway:signal:main:substitute_signal"] ) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:dr:zs1")
			{
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
						
				<g id="sh1">';
		if ( ( isset($_GET["railway:signal:main:substitute_signal"]) && $_GET["railway:signal:main:substitute_signal"] == "DE-ESO:dr:zs1" ) || ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" ) )
		{
			$image .= '
					<circle style="&gray;" cx="12" cy="37" r="2"/>
					<circle class="' . $class_zs1 . '" style="' . $colour_zs1 . '" cx="12" cy="37" r="2"/>';
		}
		if ( isset($_GET["railway:signal:minor"]) && $_GET["railway:signal:minor"] == "DE-ESO:sh1" )
		{
			$image .= '
					<circle style="' . $colour_sh1 . '" cx="28" cy="21" r="2"/>';
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