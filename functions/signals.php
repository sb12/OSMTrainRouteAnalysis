<?php 
    /**
    
    OSMTrainRouteAnalysis Copyright © 2014 sb12 osm.mapper999@gmail.com
    
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
include "signals/distant_light.php";
include "signals/main_light.php";

include "signals/hv_main.php";
include "signals/hv_distant.php";

include "signals/ks_main.php";
include "signals/ks_combined.php";
include "signals/ks_distant.php";

include "signals/hl_main.php";
include "signals/hl_combined.php";
include "signals/hl_distant.php";

include "signals/speedlimit_zs3.php";
include "signals/speedlimit_zs3v.php";

include "signals/lzb_blockkennzeichen.php";

/**
 * describes a signal on the route
 * @author sb12
 *
 */
Class Signals
{

	/**
	 * property of a signal
	 * @var array
	 */
	protected static $signal_property = array(array(),array());

	/**
	 * analyses signals
	 * @param $signals array signals
	 * @param $nodes array tags of nodes
	 * @param $maxspeed_array array maxspeeds along the route
	 */	
	public static function analyseSignals ($signals,$nodes,$maxspeed_array)
	{
		foreach ($signals as $signal)
		{
			/* all main signals (including combined and block markers): */
			if(isset($nodes[$signal[1]]["railway:signal:main"]) || isset($nodes[$signal[1]]["railway:signal:combined"])
					 || ( isset($nodes[$signal[1]]["railway:signal:train_protection:type"]) && $nodes[$signal[1]]["railway:signal:train_protection:type"] == "block_marker" ) ) 
			{
				$main_signals[] = $signal;
			}
			/* all distant signals (including combined): */
			if(isset($nodes[$signal[1]]["railway:signal:distant"]) || isset($nodes[$signal[1]]["railway:signal:combined"]))
			{
				$distant_signals[] = $signal;
			}
			self::$signal_property[$signal[1]]["distance"] = $signal[0]; 
		}
		
		$i = 0;
		//attach main signals to distant signals
		foreach ($main_signals as $signal)
		{
			foreach ( $distant_signals as $distant)
			{
				if ( $signal[0] - $distant[0] > 0 && $signal[0] - $distant[0] < 1.6)
				{
					// do not override previous entries
					if( !isset(self::$signal_property[$distant[1]]["main"]))
					{
						self::$signal_property[$signal[1]]["distant"] = $distant[1];
						self::$signal_property[$distant[1]]["main"] = $signal[1];
					} 
				}
			}
			$i++;
			if( isset( $main_signals[$i] ) )
			{
				self::$signal_property[$signal[1]]["next_main"] = $main_signals[$i][1];
			}
		}
		
		// guess speed for signal
		foreach ($signals as $signal) // go through all signals
		{
			$distance = $signal[0]; // distance of signal from start of route
			$dis = 0; // distance of start point of maxspeed area from start of route
			$last_maxspeed = 300; // maxspeed value of last area
			$next_speed = 0; // minimum maxspeed value of area after signal
			
			// go through maxspeed array
			foreach($maxspeed_array as $maxspeed)
			{
				//outside of relevant area
				if( ( $dis - $distance ) > 1 )
				{
					break;
				}
				if(  $maxspeed[1] > 0)
				{
					//maxspeed is for area behind signal
					if ( $dis > $distance )
					{
						// area is relevant for this signal ( < 1 km after signal)
						if ( ( $dis - $distance ) < 1 )
						{

							//maxspeed in area before is relevant, when new maxspeed does not start near the signal
							if ( !$next_speed && $dis - $distance > 0.02 )
							{
								$next_speed = min( $maxspeed[1], $last_maxspeed );
							}
							//next speed is set (more than one maxspeed change in area)
							if ( $next_speed > 0 )
							{
								$next_speed = min( $maxspeed[1], $next_speed );
							}
							else
							{
								$next_speed = $maxspeed[1];
							}
						}
					}
					elseif ( ( $distance - $dis ) < 0.02 ) // tolerance area before signal
					{
						$next_speed = $maxspeed[1];
					}
					$last_maxspeed = $maxspeed[1];
				}
				$dis += $maxspeed[0];
			}
			
			if($next_speed == 0) //fallback if no speed was found
			{
				$next_speed = $last_maxspeed;
			}
			self::$signal_property[$signal[1]]["next_speed"] = $next_speed;
		}
	}
	
	
	public static function getSignal($id,$tags,$maxspeed_array,$distance)
	{
		//find out speed for speed signal
		$next_speed_distant = "";
		if(isset(self::$signal_property[$id]["next_speed"]))
		{
			$next_speed = self::$signal_property[$id]["next_speed"];
		}
		if(isset(self::$signal_property[$id]["main"]))
		{
			if(isset(self::$signal_property[self::$signal_property[$id]["main"]]["next_speed"]))
			{
				$next_speed_distant = self::$signal_property[self::$signal_property[$id]["main"]]["next_speed"];
			}
		}
		
		//find distance to main signal
		$distant_distance = "";
		if ( isset($tags["railway:signal:distant"] ) || isset ( $tags["railway:signal:combined"] ) )
		{
			if ( isset( self::$signal_property[$id]["main"] ) )
			{
				$distant_distance = round(self::$signal_property[self::$signal_property[$id]["main"]]["distance"] - self::$signal_property[$id]["distance"],2)*1000;
			}
		}

		//find distance between main signals
		$main_distance = "";
		if ( isset($tags["railway:signal:main"] ) || isset ( $tags["railway:signal:combined"] )  || ( isset ( $tags["railway:signal:train_protection:type"] ) && $tags["railway:signal:train_protection:type"] == "block_marker" ) )
		{
			if(isset(self::$signal_property[$id]["next_main"]))
			{
				$main_distance = round(self::$signal_property[self::$signal_property[$id]["next_main"]]["distance"] - self::$signal_property[$id]["distance"],2)*1000;
			}
		}
		
		//find state of speed limit signal
		if(isset($tags["railway:signal:speed_limit"]))
		{
			if($tags["railway:signal:speed_limit"] == "DE-ESO:zs3")
			{
				$speed = Speedlimit_zs3::findState($tags, $next_speed);
			}
		}
		
		//find speed for distant speed limit signals
		if(isset($tags["railway:signal:speed_limit_distant"]))
		{
			if($tags["railway:signal:speed_limit_distant"] == "DE-ESO:zs3v")
			{
				$speed_distant = Speedlimit_zs3v::findState($tags, $next_speed_distant);
			}
		}
		
		//find state for main signals
		if(isset($tags["railway:signal:main"]))
		{
			//German Hp signals
			if($tags["railway:signal:main"] == "DE-ESO:hp")
			{
				$state_main = HV_main::findState($tags, $next_speed, $main_distance);
			}
			// German Ks signals
			elseif($tags["railway:signal:main"] == "DE-ESO:ks")
			{
				$state_main = KS_main::findState($tags, $next_speed, $main_distance);
			}
			elseif($tags["railway:signal:main"] == "DE-ESO:hl")
			{
				$state_main = HL_main::findState($tags, $next_speed, $main_distance);
			}
		}
		//German combined ks signals
		if(isset($tags["railway:signal:combined"]) )
		{
			if($tags["railway:signal:combined"]=="DE-ESO:ks")
			{
				$state_combined = KS_combined::findState($tags, $next_speed, $next_speed_distant, $main_distance);	
			}
			if($tags["railway:signal:combined"]=="DE-ESO:hl")
			{
				$state_combined = HL_combined::findState($tags, $next_speed, $next_speed_distant, $main_distance);	
			}
		}
		//Find state for distant signals
		if(isset($tags["railway:signal:distant"]))
		{
			//German vr signals
			if($tags["railway:signal:distant"] == "DE-ESO:vr")
			{
				$state_distant = HV_distant::findState($tags, $next_speed_distant, $main_distance);
			}
			//German ks signals
			elseif($tags["railway:signal:distant"] == "DE-ESO:ks")
			{
				$state_distant = KS_distant::findState($tags, $next_speed_distant, $main_distance);
			}
			//German hl signals
			elseif($tags["railway:signal:distant"] == "DE-ESO:hl")
			{
				$state_distant = HL_distant::findState($tags, $next_speed_distant, $main_distance);
			}
		}
		
		if(!isset($tags["railway:signal:main"])
			&& !isset($tags["railway:signal:combined"]) 
			&& !isset($tags["railway:signal:distant"]) 
			&& !isset($tags["railway:signal:speed"]) 
			&& !isset($tags["railway:signal:speed_distant"])
			&& !( isset ( $tags["railway:signal:train_protection:type"] ) && $tags["railway:signal:train_protection:type"] == "block_marker" )
				)
		{
			return;
		}
		$result = "
			<tr>
				<td> km ".round($distance,2)."</td>
				<td> ";
		
		//write query for svg file
		$get = "?";
		$get_ref = false;
		foreach($tags as $k => $v)
		{
			if( 
			$k == "railway:signal:main" || 
			$k == "railway:signal:main:states" || 
			$k == "railway:signal:main:substitute_signal" || 
			$k == "railway:signal:main:form" ||
			$k == "railway:signal:combined" || 
			$k == "railway:signal:combined:states" || 
			$k == "railway:signal:combined:substitute_signal" || 
			$k == "railway:signal:combined:shortened" ||
			$k == "railway:signal:combined:form" ||
			$k == "railway:signal:distant" || 
			$k == "railway:signal:distant:states" || 
			$k == "railway:signal:distant:repeated" || 
			$k == "railway:signal:distant:form" || 
			$k == "railway:signal:distant:shortened" ||
			$k == "railway:signal:speed_limit" ||
			$k == "railway:signal:speed_limit:form" ||
			$k == "railway:signal:speed_limit:speed" ||
			$k == "railway:signal:speed_limit_distant" ||
			$k == "railway:signal:speed_limit_distant:form" ||
			$k == "railway:signal:speed_limit_distant:speed" ||
			$k == "railway:signal:train_protection" ||
			$k == "railway:signal:minor" )
			{
				$get .= urlencode($k) . "=" . urlencode($v) . "&";
			}
			// ref only needed for train_protection sign
			if( $k == "ref" )
			{
				$ref = $v;
			}
			if( $k == "railway:signal:train_protection" )
			{
				$get_ref = true;
			}
		}
		if($get_ref && isset($ref) )
		{
			$get .= "ref=" . urlencode($ref) . "&";
		}
		if( isset($speed) && $speed )
		{
			$get .= "&speed=".$speed;
		}
		if( isset($speed_distant) && $speed_distant )
		{
			$get .= "&speed_distant=".$speed_distant;
		}
		/* not needed yet
		if(isset($route))
		{
			$get .= "&route=".$route;
		}
		if(isset($route_distant))
		{
			$get .= "&route_distant=".$route_distant;
		}*/
		if(isset($state_main))
		{
			$get .= "&state_main=".$state_main;
		}
		if(isset($state_combined))
		{
			$get .= "&state_combined=".$state_combined;
		}
		if(isset($state_distant))
		{
			$get .= "&state_distant=".$state_distant;
		}
		$result .='
				<object type="image/svg+xml" data="img/signals/signal.php'.$get.'" class="svg signal">
				</object>';
		// add ref
		if(isset($tags["ref"]))
		{
			// ref not needed for German LZB Blockkennzeichen
			if( !isset($tags["railway:signal:train_protection"]) || !$tags["railway:signal:train_protection"] == "DE-ESO:blockkennzeichen" )
			{
				$result.='
						<span class="signal_ref">'.$tags["ref"].'</span>';
			}
		}
		$result.='</td>';
		
		//show position
		if(isset($tags["railway:signal:position"]))
		{
			$img_position = "signal_unknown_position.svg";
			if($tags["railway:signal:position"] == "right")
			{

				if( isset($tags["railway:signal:expected_position"]) && $tags["railway:signal:expected_position"] == "left")
				{
					$img_position = "signal_right_expected_left.svg";
				}
				else
				{
					$img_position = "signal_right.svg";
				}
			}
			elseif($tags["railway:signal:position"] == "left")
			{
				if( isset($tags["railway:signal:expected_position"]) && $tags["railway:signal:expected_position"] == "right")
				{
					$img_position = "signal_left_expected_right.svg";
				}
				else
				{
					$img_position = "signal_left.svg";
				}
			}
			if($tags["railway:signal:position"] == "bridge")
			{
				$img_position = "signal_bridge.svg";
			}
		}
		else
		{
				$img_position = "signal_unknown_position.svg";
		}
		$result .= '<td>
				<img src="img/signals/'.$img_position.'" width = "40">
				</td>';



		//show description of signal
		$result.='<td>';
		if(isset($tags["railway:signal:main"]) || isset($tags["railway:signal:combined"]))
		{

			if( isset($tags["railway:signal:combined"]))
			{
				$tags["railway:signal:main"] = $tags["railway:signal:combined"];
			}
			if($tags["railway:signal:main"] == "DE-ESO:ks")
			{
				$result .= KS_main::showDescription();
			}
			elseif($tags["railway:signal:main"] == "DE-ESO:hp")
			{
				$result .= HV_main::showDescription();
			}
			elseif($tags["railway:signal:main"] == "DE-ESO:hl")
			{
				$result .= HL_main::showDescription();
			}
			else
			{
				$result.=main_light::showDescription();
			}
			if( isset($tags["railway:signal:combined:function"]))
			{
				$tags["railway:signal:main:function"] = $tags["railway:signal:combined:function"];
			}
			if(isset($tags["railway:signal:main:function"]))
			{
				if($tags["railway:signal:main:function"] == "entry")
				{
					$result .= Lang::l_(" Entry Signal");
				}
				elseif($tags["railway:signal:main:function"] == "intermediate")
				{
					$result .= Lang::l_(" Intermediate Signal");
				}
				elseif($tags["railway:signal:main:function"] == "exit")
				{
					$result .= Lang::l_(" Exit Signal");
				}
				elseif($tags["railway:signal:main:function"] == "block")
				{
					$result .= Lang::l_(" Block Signal");
				}
				else
				{
					$result .= Lang::l_(" Main Signal");
				}
			}
			else
			{

				$result .= Lang::l_(" Main Signal");
			}
		}
		if(isset($tags["railway:signal:speed_limit"]))
		{
			$result.="<br>";
			if( isset($tags["railway:signal:main"]) || isset($tags["railway:signal:combined"]) )
			{
				$result .= Lang::l_("with ");
			}
			if($tags["railway:signal:speed_limit"]=="DE-ESO:zs3")
			{
				$result .= Speedlimit_zs3::showDescription();
			}
			elseif($tags["railway:signal:speed_limit"]=="DE-ESO:lf7")
			{
				$result .= Lang::l_("German Lf7 Speed signal");
			}
			else
			{
				$result .= Lang::l_("Unknown Speed signal");
			}
			// Show available speed limits
			if( isset($tags["railway:signal:speed_limit:speed"]))
			{
				$speeds = explode(";",$tags["railway:signal:speed_limit:speed"]);
				$result .= " (";
				$i = 0;
				foreach ($speeds as $speed)
				{
					if($i>0)
					{
						$result.=", ";
					}
					if($speed > 0)
					{
						$result.=$speed." km/h";
					}
					elseif($speed == "off")
					{
						$result.=Lang::l_("off");
					}
					elseif($speed == "?")
					{
						$result.=Lang::l_("...");
					}
					else
					{
						$result.=Lang::l_("unknown");
					}
					$i++;
				}
				$result .= ")";
			}
		}
		if(isset($tags["railway:signal:distant"]) || isset($tags["railway:signal:combined"]))
		{
			if(isset($tags["railway:signal:main"]) || isset($tags["railway:signal:speed_limit"]) || isset($tags["railway:signal:combined"]))
			{
				$result .= "<br>";
			}
			if(isset($tags["railway:signal:combined"]))
			{
				$result .= Lang::l_("combined with ");
				$tags["railway:signal:distant"] = $tags["railway:signal:combined"];
			}

			if($tags["railway:signal:distant"] == "DE-ESO:ks")
			{
				$result .= KS_distant::showDescription();
			}
			elseif($tags["railway:signal:distant"] == "DE-ESO:vr")
			{
				$result .= HV_distant::showDescription();
			}
			elseif($tags["railway:signal:distant"] == "DE-ESO:hl")
			{
				$result .= HL_distant::showDescription();
			}
			else
			{
				$result .= distant_light::showDescription();
			}

			if(isset($tags["railway:signal:distant:repeated"]) && $tags["railway:signal:distant:repeated"] == "yes")
			{
				$result .= Lang::l_(" Repeated");
			}
			
			$result .= Lang::l_(" Distant Signal");
			
		}
		if(isset($tags["railway:signal:speed_limit_distant"]))
		{
			$result .= "<br>";
			if(isset($tags["railway:signal:distant"]))
			{
				$result .= Lang::l_("with ");
			}
			if($tags["railway:signal:speed_limit_distant"]=="DE-ESO:zs3v")
			{
				$result .=  Speedlimit_zs3v::showDescription();
			}
			elseif($tags["railway:signal:speed_limit_distant"]=="DE-ESO:lf6")
			{
				$result .= Lang::l_("German Lf6 Distant Speed signal");
			}
			else
			{
				$result .= Lang::l_("Unknown Distant Speed signal");
			}
			if( isset($tags["railway:signal:speed_limit_distant:speed"]))
			{
				$speeds = explode(";",$tags["railway:signal:speed_limit_distant:speed"]);
				$result .=" (";
				$i = 0;
				foreach ($speeds as $speed)
				{
					if($i>0)
					{
						$result.=", ";
					}
					if($speed > 0)
					{
						$result.=$speed." km/h";
					}
					elseif($speed == "off")
					{
						$result.=Lang::l_("off");
					}
					elseif($speed == "?")
					{
						$result.=Lang::l_("...");
					}
					else
					{
						$result.=Lang::l_("unknown");
					}
					$i++;
				}
				$result .=")";
			}
		}
		if( isset($tags["railway:signal:train_protection"]) )
		{
			if( $tags["railway:signal:train_protection"] == "DE-ESO:blockkennzeichen" )
			{
				$result .=  LZB_blockkennzeichen::showDescription();
			}
			else
			{
				$result .= Lang::l_("Unknown train protection sign");
			}
		}
		$result.='</td>';
		
		
		if(isset($tags["railway:signal:main"]) && !isset($tags["railway:signal:distant"]))
		{
			$distant_distance = '<span class="text-muted">x</span>';
		}
		if ( isset($tags["railway:signal:distant"] ) || isset ( $tags["railway:signal:combined"] ) )
		{
			if ( isset( self::$signal_property[$id]["main"] ) )
			{
				if($distant_distance < 300 && ( !isset($tags["railway:signal:distant:repeated"]) || $tags["railway:signal:distant:repeated"] != "yes" ) )
				{
					$distant_distance = '<strong class="text-danger">'.$distant_distance.' m</strong>';
				}
				else
				{
					$distant_distance = $distant_distance . ' m';
				}
			}
			else
			{
				$distant_distance = '<strong class="text-danger">?</strong>';
			}
		}
		$result .= '<td>
				'.$distant_distance.'
				</td>';

		if(isset($tags["railway:signal:distant"]) && !isset($tags["railway:signal:main"]))
		{
			$main_distance = '<span class="text-muted">x</span>';
		}
		if ( isset($tags["railway:signal:main"] ) || isset ( $tags["railway:signal:combined"] ) 
			|| ( isset ( $tags["railway:signal:train_protection:type"] ) && $tags["railway:signal:train_protection:type"] == "block_marker" )
				)
		{
			if(isset(self::$signal_property[$id]["next_main"]))
			{
				if($main_distance < 600 && isset($tags["railway:signal:main:states"]) && strpos($tags["railway:signal:main:states"], "kennlicht" ))
				{
					$main_distance = '<strong class="text-info">'.$main_distance.' m</strong>';
				}
				elseif($main_distance < 300)
				{
					$main_distance = '<strong class="text-danger">'.$main_distance.' m</strong>';
				}
				elseif($main_distance < 600)
				{
					$main_distance = '<strong class="text-warning">'.$main_distance.' m</strong>';
				}
				elseif($main_distance > 20000)
				{
					$main_distance = '<strong class="text-danger">'.$main_distance.' m</strong>';
				}
				elseif($main_distance > 10000)
				{
					$main_distance = '<strong class="text-warning">'.$main_distance.' m</strong>';
				}
				else 
				{
					$main_distance = $main_distance.' m';
				}
			}
			else 
			{
				$main_distance = '<strong class="text-danger">?</strong>';
			}
		}
		$result .= '<td>
				'.$main_distance.'
				</td>';
		$result .= '<td>
				<a href="http://www.openstreetmap.org/node/'.$id.'">'.Lang::l_("Show on map").'</a>
				<br>' . $id . '
				</td>';
		$result .= "</td>
				</tr>
						";
		return $result;	
	}
}
