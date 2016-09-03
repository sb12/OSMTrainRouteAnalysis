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
Class HL extends SignalPart
{

	public function __construct($tags)
	{
		parent::__construct($tags);
	}
	
	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeedsMain($next_speed)
	{
		if( count($this->states_main) > 0)
		{	
			if(in_array("hp0",$this->states_main))
			{
				$speed_array[]=0;
			}
			if( in_array("hl1",$this->states_main) || in_array("hl4",$this->states_main) || in_array("hl7",$this->states_main) || in_array("hl10",$this->states_main) )
			{
				$speed_array[]=-1; // no limit
			}
			if( in_array("hl2",$this->states_main) || in_array("hl5",$this->states_main) || in_array("hl8",$this->states_main) || in_array("hl11",$this->states_main) )
			{
				$speed_array[]=100; 
			}
			if( in_array("hl3a",$this->states_main) || in_array("hl6a",$this->states_main) || in_array("hl9a",$this->states_main) || in_array("hl12a",$this->states_main) )
			{
				$speed_array[]=40;
			}
			if( in_array("hl3b",$this->states_main) || in_array("hl6b",$this->states_main) || in_array("hl9b",$this->states_main) || in_array("hl12b",$this->states_main) )
			{
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
	 * return possible distant speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeedsDistant($next_speed)
	{
		if( count($this->states_distant) > 0)
		{
			if( in_array("hl1",$this->states_distant) || in_array("hl2",$this->states_distant) || in_array("hl3a",$this->states_distant) || in_array("hl3b",$this->states_distant) )
			{
				$speed_array[]=-1; // no limit
			}
			if( in_array("hl4",$this->states_distant) || in_array("hl5",$this->states_distant) || in_array("hl6a",$this->states_distant) || in_array("hl6b",$this->states_distant) )
			{
				$speed_array[]=100;
			}
			if( in_array("hl7",$this->states_distant) || in_array("hl8",$this->states_distant) || in_array("hl9a",$this->states_distant) || in_array("hl9b",$this->states_distant) )
			{
				$speed_array[]=60;
				$speed_array[]=40;
			}
			if( in_array("hl10",$this->states_distant) || in_array("hl11",$this->states_distant) || in_array("hl12a",$this->states_distant) || in_array("hl12b",$this->states_distant) )
			{
				$speed_array[]=0;
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
			if( ( $next_speed == 100 || $main_distance < 700 ) && strpos($tags["railway:signal:main:states"], "hl2" ))
			{
				$state = "hl2";
			}
			elseif( $next_speed == 40 && strpos($tags["railway:signal:main:states"], "hl3a" ))
			{
				$state = "hl3a";
			}
			elseif( $next_speed == 60 && strpos($tags["railway:signal:main:states"], "hl3b" ))
			{
				$state = "hl3b";
			}
			elseif( strpos($tags["railway:signal:main:states"], "hl1" ) )
			{
				$state = "hl1";
			}
			elseif( ( $next_speed == 100 || $main_distance < 700 ) && strpos($tags["railway:signal:main:states"], "hl5" ))
			{
				$state = "hl5";
			}
			elseif( $next_speed == 40 && strpos($tags["railway:signal:main:states"], "hl6a" ))
			{
				$state = "hl6a";
			}
			elseif( $next_speed == 60 && strpos($tags["railway:signal:main:states"], "hl6b" ))
			{
				$state = "hl6b";
			}
			elseif ( strpos($tags["railway:signal:main:states"], "hp0" ) ) // signal can only show hp0
			{
				$state = "hp0";
			}
		}
		return $state;
	}
	
	
	/**
	 * returns description of the signals
	 * @return description for signal
	 */
	public function showDescription($description,$type)
	{
		return parent::showDescription(Lang::l_("German Hl"),$type);
	}


	public function getStateMain($main_distance)
	{
		/* state was already set by a more "intelligent" function */
		if($this->state_main)
		{
			return;
		}
		$state = "";
		if(isset($this->tags["railway:signal:combined:states"]) && !isset($this->tags["railway:signal:main:states"]))
		{
			$this->getStateCombined($main_distance);
			return;
		}
	
		if(isset($this->tags["railway:signal:main:states"]))
		{
			$states = Signals::signalStates($this->tags["railway:signal:main:states"], "DE-ESO");
			if ( $this->speed_main == 0 && in_array("hp0", $states)) // signal at end of route
			{
				$state = "hp0";
			}
			if( ( $this->speed_main == 100 || $main_distance < 700 ) && in_array("hl2", $states ))
			{
				$state = "hl2";
			}
			elseif( $this->speed_main == 40 && in_array("hl3a", $states))
			{
				$state = "hl3a";
			}
			elseif( $this->speed_main == 60 && in_array("hl3b", $states))
			{
				$state = "hl3b";
			}
			elseif( in_array("hl1", $states) )
			{
				$state = "hl1";
			}
			elseif( ( $this->speed_main == 100 || $main_distance < 700 ) && in_array("hl5", $states))
			{
				$state = "hl5";
			}
			elseif( $this->speed_main == 40 && in_array("hl6a", $states))
			{
				$state = "hl6a";
			}
			elseif( $this->speed_main == 60 && in_array("hl6b", $states))
			{
				$state = "hl6b";
			}
			elseif ( in_array("hp0", $states) ) // signal can only show hp0
			{
				$state = "hp0";
			}
		}
		$this->state_main = $state;
	}
	

	public function getStateDistant()
	{
		/* state was already set by a more "intelligent" function */
		if($this->state_distant)
		{
			return;
		}
		$state = "";
		if(isset($this->tags["railway:signal:distant:states"]))
		{
			$states = Signals::signalStates($this->tags["railway:signal:distant:states"], "DE-ESO");
		
			// last distant signal of route
			if ( $this->speed_distant == 0  &&
					in_array( "hl10", $states ) )
			{
				$state = "hl10";
			}
			elseif ( $this->speed_distant == 100  &&
					in_array( "hl4", $states ) )
			{
				$state = "hl4";
			}
			elseif ( ( $this->speed_distant == 40 || $this->speed_distant == 60 ) &&
					in_array( "hl7", $states ) )
			{
				$state = "hl7";
			}
			elseif ( in_array( "hl1", $states ) )
			{
				$state = "hl1";
			}
			elseif ( in_array( "hl10", $states ) )
			{
				$state = "hl10";
			}
		}
		$this->state_distant = $state;
	}

	public function getStateCombined($main_distance)
	{
		/* state was already set by a more "intelligent" function */
		if($this->state_combined)
		{
			return;
		}
		$state = "";
		
		if(isset($this->tags["railway:signal:combined:states"]))
		{
			$states = Signals::signalStates($this->tags["railway:signal:combined:states"], "DE-ESO");
			if ( $this->speed_main == 0 && in_array("hp0", $states)) // signal at end of route
			{
				$state = "hp0";
			}
			if( ( $this->speed_main == 100 || $main_distance < 700 ) && (in_array("hl2", $states ) || in_array("hl11", $states) || in_array("hl8", $states) || in_array("hl5", $states) ) )
			{
				if(in_array("hl2", $states))
				{
					$state = "hl2";
				}
				if ( $this->speed_distant == 0 && in_array("hl11", $states))
				{
					$state = "hl11";
				}
				elseif ( ( $this->speed_distant == 40 || $this->speed_distant == 60 ) && in_array("hl8", $states) )
				{
					$state = "hl8";
				}
				elseif ( $this->speed_distant == 100  && in_array("hl5", $states) )
				{
					$state = "hl5";
				}
			}
			elseif( $this->speed_main == 40 && (in_array("hl3a", $states) || in_array("hl12a", $states) || in_array("hl9a", $states) || in_array("hl6a", $states) ) )
			{
				if(in_array("hl3a", $states))
				{
					$state = "hl3a";
				}
				if ( $this->speed_distant == 0 && in_array("hl12a", $states))
				{
					$state = "hl12a";
				}
				elseif ( ( $this->speed_distant == 40 || $this->speed_distant == 60 ) && in_array("hl9a", $states))
				{
					$state = "hl9a";
				}
				elseif ( $this->speed_distant == 100 && in_array("hl6a", $states) )
				{
					$state = "hl6a";
				}
			}
			elseif( $this->speed_main == 60 && ( in_array("hl3b", $states) || in_array("hl12b", $states) || in_array("hl9b", $states) || in_array("hl6b", $states) ) )
			{
				if( in_array("hl3b", $states) )
				{
					$state = "hl3b";
				}
				if ( $this->speed_distant == 0 && in_array("hl12b", $states) )
				{
					$state = "hl12b";
				}
				elseif ( ( $this->speed_distant == 40 || $this->speed_distant == 60 ) && in_array("hl9b", $states))
				{
					$state = "hl9b";
				}
				elseif ( $this->speed_distant == 100 && in_array("hl6b", $states))
				{
					$state = "hl6b";
				}
			}
			elseif( in_array("hl1", $states) || in_array("hl10", $states) || in_array("hl7", $states) || in_array("hl4", $states) )
			{
				if(in_array("hl1", $states))
				{
					$state = "hl1";
				}
				elseif ( $this->speed_distant == 0 && in_array("hl10", $states))
				{
					$state = "hl10";
				}
				elseif ( ( $this->speed_distant == 40 || $this->speed_distant == 60 ) && in_array("hl7", $states))
				{
					$state = "hl7";
				}
				elseif ( $this->speed_distant == 100  && in_array("hl4", $states))
				{
					$state = "hl4";
				}
			}
			elseif( ( $this->speed_main == 100 || $main_distance < 700 ) && in_array("hl5", $states))
			{
				$state = "hl5";
			}
			elseif( $this->speed_main == 40 && in_array("hl6a", $states))
			{
				$state = "hl6a";
			}
			elseif( $this->speed_main == 60 && in_array("hl6b", $states))
			{
				$state = "hl6b";
			}
			elseif ( in_array("hp0", $states) ) // signal can only show hp0
			{
				$state = "hp0";
			}
		}
		$this->state_main = $state;
		if(isset($this->tags["railway:signal:combined"]))
		{
			$this->state_combined = $state;
		}
	}
	
	
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage()
	{
		return; // not needed
	}
	
}