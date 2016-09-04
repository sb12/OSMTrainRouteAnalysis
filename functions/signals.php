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
include "signals/signalpart.php";
include "signals/speed.php";
include "signals/speed_distant.php";

include "signals/hv.php";

include "signals/ks.php";

include "signals/hl.php";

include "signals/ne1.php";
include "signals/ne2.php";

include "signals/speedlimit_zs3.php";
include "signals/speedlimit_zs3v.php";

include "signals/blockkennzeichen.php";
include "signals/ETCS_markerboard.php";

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
	 * maxspeed array
	 * @var array
	 */
	protected static $maxspeed_array;

	/**
	 * tags of this signal
	 * @var array
	 */
	protected $tags;

	/**
	 * position of signal in route
	 * @var double
	 */
	protected $pos;
	
	/**
	 * corresponding main signal
	 * @var Signals
	 */
	protected $mainSignal;
	
	/**
	 * next main signal
	 * @var Signals
	 */
	protected $nextMainSignal;
	
	/**
	 * corresponding distant signal
	 * @var Signals
	 */
	protected $distantSignal;


	/**
	 * corresponding repeater distant signal
	 * @var Signals
	 */
	protected $RepeaterDistantSignal;
	
	/**
	 * corresponding distant signal
	 * @var Signals
	 */
	protected $distant;

	/**
	 * maxspeed in array behind signal
	 * @var double
	 */
	protected $next_speed;

	/**
	 * Main Signal
	 * @var Main
	 */
	protected $SignalMain;

	/**
	 * Distant Signal
	 * @var Distant
	 */
	protected $SignalDistant;

	/**
	 * Speed Signal
	 * @var Speed
	 */
	protected $SignalSpeed;

	/**
	 * Distant Speed Signal
	 * @var Speed_Distant
	 */
	protected $SignalSpeedDistant;
	
	
	
	public function Signals($id, $node, $pos)
	{
		$this->tags = $node;
		$this->pos = $pos;
		$this->id = $id;
		
		//devide into signal parts:
		if(isset($this->tags["railway:signal:main"])) // is main signal
		{
			if($this->tags["railway:signal:main"] == "DE-ESO:hp") // German H/V
			{
				$this->SignalMain = new HV($this->tags);
			}
			elseif($this->tags["railway:signal:main"] == "DE-ESO:ks") // German Ks
			{
				$this->SignalMain = new KS($this->tags);
			}
			elseif($this->tags["railway:signal:main"] == "DE-ESO:hl") // German Hl
			{
				$this->SignalMain = new HL($this->tags);
			}
			elseif($this->tags["railway:signal:main"] == "DE-ESO:ne1") // German Hl
			{
				$this->SignalMain = new Ne1($this->tags);
			}
			else // unknown main signal
			{
				$this->SignalMain = new SignalPart($this->tags);
			}
		}
		if(isset($this->tags["railway:signal:distant"])) // is distant signal
		{
			if($this->tags["railway:signal:distant"] == "DE-ESO:vr") // German H/V
			{
				$this->SignalDistant = new HV($this->tags);
			}
			elseif($this->tags["railway:signal:distant"] == "DE-ESO:ks") // German Ks
			{
				$this->SignalDistant = new KS($this->tags);
			}
			elseif($this->tags["railway:signal:distant"] == "DE-ESO:hl") // German Hl
			{
				$this->SignalDistant = new HL($this->tags);
			}
			elseif($this->tags["railway:signal:distant"] == "DE-ESO:db:ne2") // German Hl
			{
				$this->SignalDistant = new Ne2($this->tags);
			}
			else // unknown distant signal
			{
				$this->SignalDistant = new SignalPart($this->tags);
			}
		}
		if(isset($this->tags["railway:signal:combined"])) // is combined signal
		{
			if($this->tags["railway:signal:combined"] == "DE-ESO:ks") // German Ks
			{
				$this->SignalCombined = new KS($this->tags);
				$this->SignalMain = $this->SignalCombined;
				$this->SignalDistant = $this->SignalCombined;
			}
			elseif($this->tags["railway:signal:combined"] == "DE-ESO:hl") // German Hl
			{
				$this->SignalCombined = new HL($this->tags);
				$this->SignalMain = $this->SignalCombined;
				$this->SignalDistant = $this->SignalCombined;
			}
			else // unknown distant signal
			{
				$this->SignalCombined = new SignalPart($this->tags);
				$this->SignalMain = $this->SignalCombined;
				$this->SignalDistant = $this->SignalCombined;
			}
		}
		if(isset($this->tags["railway:signal:speed_limit"])) // is speed limit signal
		{
			if($this->tags["railway:signal:speed_limit"] == "DE-ESO:zs3") // German Zs3
			{
				$this->SignalSpeed = new Speedlimit_zs3($this->tags);
			}
			else // unknown distant signal
			{
				$this->SignalSpeed = new Speed($this->tags);
			}
		}
		if(isset($this->tags["railway:signal:speed_limit_distant"])) // is speed limit signal
		{
			if($this->tags["railway:signal:speed_limit_distant"] == "DE-ESO:zs3v") // German Zs3v
			{
				$this->SignalSpeedDistant = new Speedlimit_zs3v($this->tags);
			}
			else // unknown distant signal
			{
				$this->SignalSpeedDistant = new Speed_Distant($this->tags);
			}
		}
		
	}

	/**
	 * is the signal a main signal?
	 * @return boolean
	 */
	public function is_main()
	{
		if( isset($this->tags["railway:signal:main"]) || isset($this->tags["railway:signal:combined"]))
				// TODO: || ( isset($this->tags["railway:signal:train_protection:type"]) && $this->tags["railway:signal:train_protection:type"] == "block_marker" ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * is the signal a distant signal?
	 * @return boolean
	 */
	public function is_distant()
	{
		if(isset($this->tags["railway:signal:distant"]) || isset($this->tags["railway:signal:combined"]) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * set corresponding main signal
	 * @param Signal $signal
	 */
	public function set_mainSignal($signal)
	{
		$this->mainSignal = $signal;
	}
	
	/**
	 * set next main signal
	 * @param Signal $signal
	 */
	public function set_nextMainSignal($signal)
	{
		$this->nextMainSignal = $signal;
	}
	
	/**
	 * set corresponding distant signal
	 * @param Signal $signal
	 */
	public function set_distantSignal($signal)
	{
		$this->distantSignal = $signal;
	}
	
	/**
	 * set corresponding repeater distant signal
	 * @param Signal $signal
	 */
	public function set_RepeaterDistantSignal($signal)
	{
		$this->RepeaterDistantSignal = $signal;
	}
	
	/**
	 * get speed in the area behind the signal
	 */
	public function getSpeed()
	{
		$dis = 0; // distance of start point of maxspeed area from start of route
		$last_maxspeed = 400; // maxspeed value of last area
		$next_speed = 0; // minimum maxspeed value of area after signal
		$outside_of_area = false; // the last maxspeed is outside the relevant area

		// go through maxspeed array
		foreach(self::$maxspeed_array as $maxspeed)
		{
			//outside of relevant area
			/*if( ( $dis - $this->pos ) > 1.5 )
			{
				break;
				$outside_of_area=true;
			}*/
			if( $maxspeed[1] > 0 )
			{
				//maxspeed is for area behind signal
				if ( $dis > $this->pos )
				{
					// area is relevant for this signal ( before next main signal and less than 1.5 km after signal)
					if ( ( $dis - $this->pos ) < 1.5 && ( !isset($this->nextMainSignal->pos) || ( $dis - $this->nextMainSignal->pos ) <= -0.02 ) )
					{
						//maxspeed in area before is relevant, when new maxspeed does not start near the signal
						if ( !$next_speed && $dis - $this->pos > 0.02 )
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
					else
					{
						break;
						$outside_of_area=true;
					}
				}
				elseif ( ( $this->pos - $dis ) < 0.02 ) // tolerance area before signal
				{
					$next_speed = $maxspeed[1];
				}
				$last_maxspeed = $maxspeed[1];
			}
			$dis += $maxspeed[0];
		}
				
		if( $next_speed == 0 && ( abs( $dis - $this->pos ) > 0.005 && !$outside_of_area ) ) //fallback if no speed was found and signal is not the last of the route
		{
			$next_speed = $last_maxspeed;
		}
		$this->next_speed = $next_speed;
	}
	
	/**
	 * get signal states of this signal
	 */
	public function getSignalState()
	{
		//signal is a main signal
		if($this->is_main())
		{
			$mainDist=0;
			if(isset($this->nextMainSignal->pos))
			{
				$mainDist=$this->pos - $this->nextMainSignal->pos;
			}
			
			//make distant speed available for main signal (needed for some combined signals)
			if( isset ($this->SignalDistant) )
			{
				$this->SignalMain->speed_distant = $this->SignalDistant->speed_distant;
			}
			
			$this->SignalMain->getStateMain($mainDist);
			if(isset($this->SignalSpeed))
			{
				$this->SignalSpeed->getSpeed();
			}
		}
		//signal is a distant signal
		if($this->is_distant())
		{
			$this->SignalDistant->getStateDistant();
			if(isset($this->SignalSpeedDistant))
			{
				$this->SignalSpeedDistant->getSpeedDistant();
			}
		}
	}
	
	public function getPossibleSpeedsMain()
	{
		$speed_array = Array();
		if( isset($this->SignalSpeed) )
		{
			$speed_array = array_merge($this->SignalSpeed->possibleSpeeds(), $speed_array); 
		}
		if( isset($this->SignalMain) )
		{
			$speed_array = array_merge($this->SignalMain->possibleSpeedsMain($this->next_speed), $speed_array); 
		}
		return $speed_array;
	}
	
	public function getPossibleSpeedsDistant()
	{
		$speed_array = Array();
		if( isset($this->SignalSpeedDistant) )
		{
			$speed_array = array_merge($this->SignalSpeedDistant->possibleSpeedsDistant(), $speed_array); 
		}
		if( isset($this->SignalDistant) )
		{
			$speed_array = array_merge($this->SignalDistant->possibleSpeedsDistant($this->next_speed), $speed_array); 
		}
		return $speed_array;
	}
	
	public function setSignalStateMain()
	{
		//get speed values
		$this->getSpeed();
		
		$possible_speeds = Array();
		$possible_speeds_main = $this->getPossibleSpeedsMain($this->next_speed);
		if(isset($this->distantSignal))
		{
			$possible_speeds_distant = $this->distantSignal->getPossibleSpeedsDistant($this->next_speed);
			
			$distSignal = $this->distantSignal;
			while(isset($distSignal->RepeaterDistantSignal))
			{
				$distSignal = $distSignal->RepeaterDistantSignal;
				$distSignal->getPossibleSpeedsDistant($this->next_speed);
				//FIXME: for now it only calls the function but does not use the values to compare
				
				//TODO: Compare values of all repeaters
			}
			if($possible_speeds_distant)
			{
				foreach($possible_speeds_main as $speed)
				{
					if(in_array($speed, $possible_speeds_distant))
					{
						$possible_speeds[] = $speed;
					}
				}
			}
			else
			{
				$possible_speeds = $possible_speeds_main;
			}
		}
		else
		{
			$possible_speeds = $possible_speeds_main;
		}
		sort($possible_speeds);
		$none = false;
		foreach($possible_speeds as $speed)
		{
			if($speed == "-1")
			{
				$none = true;
				continue;
			}
			if($speed > $this->next_speed)
			{
				$none = false;
				break;
			}
			$signal_speed = $speed;
		}
		if( !isset($signal_speed)  || $none) // case where signal can only show "proceed" and "stop"
		{
			$signal_speed = $this->next_speed;
		}

		if(isset($this->SignalMain))
		{
			$this->SignalMain->setSpeedMain($signal_speed);
		}
		if(isset($this->SignalSpeed))
		{
			$this->SignalSpeed->setSpeedMain($signal_speed);
		}
		if(isset($this->distantSignal))
		{
			if(isset($this->distantSignal->SignalDistant))
			{
				$this->distantSignal->SignalDistant->setSpeedDistant($signal_speed);
				$distSignal = $this->distantSignal;
				while(isset($distSignal->RepeaterDistantSignal))
				{
					$distSignal = $distSignal->RepeaterDistantSignal;
					$distSignal->SignalDistant->setSpeedDistant($signal_speed);
					if(isset($distSignal->SignalSpeedDistant))
					{
						
						$distSignal->SignalSpeedDistant->setSpeedDistant($signal_speed);
					}
				}
			}
			if(isset($this->distantSignal->SignalSpeedDistant))
			{
				$this->distantSignal->SignalSpeedDistant->setSpeedDistant($signal_speed);
			}
		}
		if( isset($this->SignalMain->state_main) && $this->SignalMain->state_main == "kennlicht")
		{
			return;
		}
		

		// there is no main signal for this distant signal and signal can be off
		if(isset($this->SignalDistant) && !isset($this->mainSignal) && in_array("off", $this->SignalDistant->states_distant))
		{
			// signal should be off
			$this->SignalDistant->state_distant = "off";
		}
		
		/* rules for signals with "kennlicht" */
		if( isset($this->nextMainSignal) && $this->nextMainSignal->pos - $this->pos < 0.7 )
		{
			/* by default the second possible signal is set to "kennlicht" */
			if( isset( $this->nextMainSignal->SignalMain->states_main ) && in_array("kennlicht", $this->nextMainSignal->SignalMain->states_main) )
			{
				$this->nextMainSignal->SignalMain->state_main = "kennlicht";
				if(isset($this->nextMainSignal->SignalDistant))
				{
					
					// set correct distant signal for the next main signal
					$this->nextMainSignal->mainSignal->distantSignal = $this;
					
					// use distant signal as repeater if distance between signals is at least 300 m
					if ( $this->nextMainSignal->pos - $this->pos > 0.3 )
					{
						$this->nextMainSignal->mainSignal->distantSignal->RepeaterDistantSignal = $this->nextMainSignal;
					}
					else
					{
						// turn off distant signal:
						$this->nextMainSignal->SignalDistant->state_distant = "off";	
					}
				}
			}
			elseif( isset($this->SignalMain->states_main) && in_array("kennlicht", $this->SignalMain->states_main) )
			{
				$this->SignalMain->state_main = "kennlicht";
				if(isset($this->SignalDistant))
				{
					// set correct distant signal for the next main signal
					$this->mainSignal->distantSignal = $this;
					
					// use distant signal as repeater if distance between signals is at least 300 m
					if ( $this->nextMainSignal->pos - $this->pos > 0.3 )
					{
						$this->mainSignal->distantSignal->RepeaterDistantSignal = $this;
					}
					else
					{
						// turn off distant signal:
						$this->SignalDistant->state_distant = "off";	
					}
				}
			}
		}
	}
	
	
	/**
	 * analyses signals
	 * @param $signals array signals
	 * @param $nodes array tags of nodes
	 * @param $maxspeed_array array maxspeeds along the route
	 */	
	public static function analyseSignals ($signals, $nodes, $maxspeed_array, $Route)
	{
		self::$maxspeed_array = $maxspeed_array;

		//no signals found on route
		if(!$signals)
		{
			return;
		}
		
		//construct signal elements
		foreach ($signals as $signal)
		{
			$Route->signal[$signal[1]]=new Signals($signal[1], $nodes[$signal[1]],  $signal[0]);
		}
		
		// construct arrays for main and distant signals
		foreach ($signals as $signal)
		{
			if( $Route->signal[$signal[1]]->is_main() ) 
			{
				$main_signals[] = $signal;
			}
			/* all distant signals (including combined): */
			if( $Route->signal[$signal[1]]->is_distant() )
			{
				$distant_signals[] = $signal;
			}
			//self::$signal_property[$signal[1]]["distance"] = $signal[0]; 
		}
		
		$i = 0;
		//attach main signals to distant signals
		$distant_signals = array_reverse($distant_signals); // reverse array
		foreach ($main_signals as $signal) // go through all main signals
		{
			$repeater = false;
			foreach ( $distant_signals as $distant) // go through all distant signals
			{
				if ( $signal[0] - $distant[0] > 0 && $signal[0] - $distant[0] < 1.8 && !isset($Route->signal[$distant[1]]->mainSignal)) // distant signal is between 0 and 1800m from main signal and there's no main signal set yet..
				{
					//set distant signal for main signal
					$Route->signal[$signal[1]]->set_distantSignal($Route->signal[$distant[1]]);
					self::$signal_property[$signal[1]]["distant"] = $distant[1];
					
					if($repeater) // last signal was a repeater
					{
						//set the non-repeater distant signal for main signal
						$Route->signal[$distant[1]]->set_RepeaterDistantSignal($Route->signal[$last_distant[1]]);
					}
					
					// set main signal for distant signal
					$Route->signal[$distant[1]]->set_mainSignal($Route->signal[$signal[1]]);
					self::$signal_property[$distant[1]]["main"] = $signal[1];

					if( isset($Route->signal[$distant[1]]->tags["railway:signal:distant:repeated"]) && $Route->signal[$distant[1]]->tags["railway:signal:distant:repeated"] == "yes") // signal is a repeater
					{
						$repeater = true;
						$last_distant = $distant;
					}
					else
					{
						$repeater = false;
					}
				}
			}
			$i++;
			if( isset( $main_signals[$i] ) )
			{
				$Route->signal[$signal[1]]->set_nextMainSignal($Route->signal[$main_signals[$i][1]]);
			}
		}
		foreach ($signals as $signal)
		{
			$Route->signal[$signal[1]]->setSignalStateMain();
		}
		
		//FIXME: This should not be entered in maxspeed array and should be fixed in the maxspeed array creation
		if(isset($maxspeed_array[-1]))
		{
			$maxspeed_array[-1][0]=0;
			$maxspeed_array[-1][1]=0;
		}
		
		
	}
	
	
	public function showSignal()
	{
		if( !$this->is_main() && !$this->is_distant() )
		{
			return;
		}
		$this->getSignalState();
		$result = "
			<tr>
				<td> km ".round($this->pos,2)."</td>
				<td> ";
		
		//write query for svg file
		$get = "?";
		$get_ref = $get_position = false;
		foreach($this->tags as $k => $v)
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
			// ref only needed for train_protection sign "blockkennzeichen"
			if( $k == "ref" )
			{
				$ref = $v;
			}
			if( $k == "railway:signal:train_protection" && $v == "DE-ESO:blockkennzeichen" )
			{
				$get_ref = true;
			}
			// position only needed for train_protection sign "ETCS marker board"
			if( $k == "railway:signal:position" )
			{
				$position = $v;
			}
			if( $k == "railway:signal:train_protection" && $v == "DE-ESO:ne14" )
			{
				$get_position = true;
			}
		}
		if($get_ref && isset($ref) )
		{
			$get .= "ref=" . urlencode($ref) . "&";
		}
		if($get_position && isset($position) )
		{
			$get .= "railway:signal:position=" . urlencode($position) . "&";
		}
		if( isset($this->SignalSpeed->speed) && $this->SignalSpeed->speed )
		{
			$get .= "&speed=".$this->SignalSpeed->speed;
		}
		if( isset($this->SignalSpeedDistant->speed_distant) && $this->SignalSpeedDistant->speed_distant )
		{
			$get .= "&speed_distant=".$this->SignalSpeedDistant->speed_distant;
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
		if(isset($this->SignalMain->state_main))
		{
			$get .= "&state_main=" . $this->SignalMain->state_main;
		}
		if(isset($this->SignalMain->state_combined))
		{
			$get .= "&state_combined=" . $this->SignalMain->state_combined;
		}
		if(isset($this->SignalDistant->state_distant))
		{
			$get .= "&state_distant=" . $this->SignalDistant->state_distant;
		}
		$result .='
				<object type="image/svg+xml" data="img/signals/signal.php' . $get . '" class="svg signal">
				</object>';
		// add ref
		if(isset($this->tags["ref"]))
		{
			// ref not needed for German Blockkennzeichen
			if( !isset($this->tags["railway:signal:train_protection"]) || $this->tags["railway:signal:train_protection"] != "DE-ESO:blockkennzeichen" )
			{
				$result.='
						<span class="signal_ref">' . $this->tags["ref"] . '</span>';
			}
		}
		$result.='</td>';
		
		//show position
		if(isset($this->tags["railway:signal:position"]))
		{
			$img_position = "signal_unknown_position.svg";
			if( ($this->tags["railway:signal:position"] == "right" && $this->tags["railway:signal:direction"] == "forward") || ($this->tags["railway:signal:position"] == "left" && $this->tags["railway:signal:direction"] == "backward") )
			{

				if( isset($this->tags["railway:signal:expected_position"]) && $this->tags["railway:signal:expected_position"] == "left")
				{
					$img_position = "signal_right_expected_left.svg";
				}
				else
				{
					$img_position = "signal_right.svg";
				}
			}
			elseif( ($this->tags["railway:signal:position"] == "left" && $this->tags["railway:signal:direction"] == "forward") || ($this->tags["railway:signal:position"] == "right" && $this->tags["railway:signal:direction"] == "backward") )
			{
				if( isset($this->tags["railway:signal:expected_position"]) && $this->tags["railway:signal:expected_position"] == "right")
				{
					$img_position = "signal_left_expected_right.svg";
				}
				else
				{
					$img_position = "signal_left.svg";
				}
			}
			elseif($this->tags["railway:signal:position"] == "bridge")
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


		$result .= '<td>';

		//show description of signal
		$description_set = false;
		if(isset($this->SignalMain))
		{
			$result .= $this->SignalMain->showDescription("","Main") . "<br />";
		}
		if(isset($this->SignalSpeed))
		{
			$result .= $this->SignalSpeed->showDescription("","Speed") . "<br />";
		}
		if(isset($this->SignalDistant))
		{
			$result .= $this->SignalDistant->showDescription("","Distant") . "<br />";
		}
		if(isset($this->SignalSpeedDistant))
		{
			$result .= $this->SignalSpeedDistant->showDescription("","SpeedDistant") . "<br />";
		}
		$result .= "Speed in area behind signal: " . $this->next_speed . " <br />";
		
		$distant_distance = $this->get_output_distant_distance();
		
		$result .= '<td>
				' . $distant_distance . '
				</td>';

		$main_distance = $this->get_output_main_distance();
		
		$result .= '<td>
				' . $main_distance . '
				</td>';
		$result .= '<td>
				<a href="http://www.openstreetmap.org/node/' . $this->id . '">' . Lang::l_("Show on map") . '</a>
				<br>' . $this->id . '
				</td>';
		$result .= "</td>
				</tr>
						";
		return $result;	
	}
	
	/**
	 * outputs styling for the distance between distant and main signal
	 * @return distance with styling
	 */
	public function get_output_distant_distance()
	{
		$class = $class_strong = "";
		if(!$this->is_distant())
		{
			$class = "text-muted";
			$value = "x";
		}
		if($this->is_distant())
		{
			if ($this->SignalDistant->state_distant == "off")
			{
				$class_strong = "text-info";
				$value = "x";
			}
			elseif ( isset( $this->mainSignal ) )
			{
				$distance = round( ( $this->mainSignal->pos - $this->pos ) * 1000 );
				$value = $distance . " m";
				if( isset($this->tags["railway:signal:distant:repeated"]) && $this->tags["railway:signal:distant:repeated"] == "yes" )
				{
					$class_strong = "text-info";
				}
				elseif ( // this is most likely an error
						( $this->next_speed <= 80 && $distance < (0.93 * 400) ) ||
						( $this->next_speed <= 120 && $distance < (0.93 * 700) ) ||
						( $this->next_speed > 120 && $distance < (0.93 * 1000) ) )
				{
					$class_strong = "text-danger";
				}
				elseif ( //warning area
						( $this->next_speed < 60 && $distance < (0.93 * 400) ) ||
						( $this->next_speed < 100 && $distance < (0.93 * 700) ) ||
						( $this->next_speed > 100 && $distance < (0.93 * 1000) ) )
				{
					$class_strong = "text-warning";
				}
			}
			else
			{
				$class_strong = "text-danger";
				$value = "?";
			}
		}
		$distant_distance = $value;
		if($class_strong)
		{
			$distant_distance = '<strong class="'.$class_strong.'">'.$distant_distance.'</strong>';
		}
		elseif($class)
		{
			$distant_distance = '<span class="'.$class.'">'.$distant_distance.'</span>';
		}
		return $distant_distance;
	}


	/**
	 * outputs styling for the distance between main signals
	 * @return distance with styling
	 */
	public function get_output_main_distance()
	{
		$class = $class_strong = "";
		if(!$this->is_main())
		{
			$class = "text-muted";
			$value = "x";
		}
		else
		{
			if(isset($this->nextMainSignal))
			{
				$distance = round( ( $this->nextMainSignal->pos - $this->pos ) * 1000 );
				$value = $distance . " m";
				if( $distance < 1000 && ( $this->SignalMain->state_main == "kennlicht" || $this->nextMainSignal->SignalMain->state_main == "kennlicht" ))
				{
					$class_strong = "text-info";
				}
				elseif ( // this is most likely an error
						( $this->next_speed <= 80 && $distance < (0.93 * 400) ) ||
						( $this->next_speed <= 120 && $distance < (0.93 * 700) ) ||
						( $this->next_speed > 120 && $distance < (0.93 * 1000) ) )
				{
					$class_strong = "text-danger";
				}
				elseif ( //warning area
						( $this->next_speed < 60 && $distance < (0.93 * 400) ) ||
						( $this->next_speed < 100 && $distance < (0.93 * 700) ) ||
						( $this->next_speed > 100 && $distance < (0.93 * 1000) ) )
				{
					$class_strong = "text-warning";
				}
				elseif($distance > 20000)
				{
					$class_strong = "text-danger";
				}
				elseif($distance > 10000)
				{
					$class_strong = "text-warning";
				}
			}
			else 
			{
				$class_strong = "text-danger";
				$value = "?";
			}
		}
		
		$main_distance = $value;
		if($class_strong)
		{
			$main_distance = '<strong class="'.$class_strong.'">'.$main_distance.'</strong>';
		}
		elseif($class)
		{
			$main_distance = '<span class="'.$class.'">'.$main_distance.'</span>';
		}
		return $main_distance;
	}
	
	
	public static function signalStates($states,$prefix,$strict=true)
	{
		$states = explode(";", $states);
		foreach($states as $state)
		{
			$state_parts = explode(":", $state);
			if(isset($state_parts[1]))
			{
				$namespace=$state_parts[0];
				if(!$strict || $namespace==$prefix)
				{
					$state = $state_parts[1];
				}
				else
				{
					continue;
				}
			}
			elseif(!$strict)
			{
				$namespace = "";
				$state = $state_parts[0];
				//FIXME: throw warning?
			}
			else
			{
				continue;
			}
			$states_array[]= $state;
		}
		return $states_array;
	}
}
