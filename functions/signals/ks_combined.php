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
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed, $next_speed_distant, $main_distance)
	{
		$state = ""; // start with unknown state
		
		// array with all states the signal can show
		$possible_states = array();
		
		// check for coded tags
		if(isset($tags["railway:signal:combined:states"]))
		{
			// explode possible states
			$possible_states_raw = explode(";", $tags["railway:signal:combined:states"]);
			foreach($possible_states as $curr_state)
			{
				$namespace = explode(":", $curr_state);
				// convert format "DE-ESO:state" to "state"
				if($namespace[0] == "DE-ESO")
				{
					$possible_states[] = $namespace[1];
				}
				else
				{
					// TODO: throw warning: No DE-ESO prefix
					$possible_states[] = $namespace[0];
				}
			}
		}
		else
		{
			// TODO: throw warning: No states in database, assuming Hp0 only
			// failsafe: every Ks combined can at least show Hp0
			$possible_states[] = "hp0";
		}
		
		// try to find state according to the given input speeds
		
		// speed at this signal = 0?
		if ( $next_speed == 0) // signal where the train shall stop
		{
			$state = "hp0";
		}
		
		// speed at next signal = 0?
		elseif ( $next_speed_distant == 0 ) // signal which is announcing a stop signal
		{
			// can the signal show Ks2, as it should?
			if(in_array("ks2", $possible_states))
			{
				$state = "ks2";
			}
			else
			{
				// TODO: warning: signal shall show Ks2, but not coded. Showing Hp0 instead!
				$state = "hp0";
			}
		}
		
		elseif( $next_speed_distant > 0 )
		{
			// TODO: check if Zs 3v is available
			// if yes, show Ks1
			// if not, show Ks2
			
			// can the signal show Ks1, as it should?
			if(in_array("ks1", $possible_states))
			{
				$state = "ks1";
			}
			else
			{
				// can the signal show Ks2 instead?
				if(in_array("ks1", $possible_states))
				{
					// TODO: warning: signal shall show Ks1, but only Ks2 coded!
					$state = "ks2";
				}
				else
				{
					// TODO: warning: signal shall show Ks1, but not coded, nor Ks2 coded. Showing Hp0 instead!
					$state = "hp0";
				}
			}
		}
		
		if($state == "")
		{
			// TODO: warning: No appropriate state found, check tagging! Showing Hp0!
			$state = "hp0"; // fail safe
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
