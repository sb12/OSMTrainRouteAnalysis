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
 * German H/V Distant Signal
 * @author sb12
 *
 */
Class HV extends SignalPart
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
			if( in_array("hp0", $this->states_main) )
			{
				$speed_array[] = 0;
			}
			if( in_array("hp1", $this->states_main) )
			{
				$speed_array[] = -1; // no limit
			}
			if( in_array("hp2", $this->states_main) )
			{
				$speed_array[] = 40;
				$speed_array[] = 60;
			}
		}
		if(!isset($speed_array))
		{
			$speed_array[]=0;
			$speed_array[]=-1;
		}
		if($next_speed<=60 && !in_array(60,$speed_array))
		{
			$speed_array=Array(0);
		}
		if($next_speed>60 && !in_array(-1,$speed_array))
		{
			$speed_array=Array(0);
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
			if( in_array("vr0", $this->states_distant) )
			{
				$speed_array[]=0;
			}
			if( in_array("vr1", $this->states_distant) )
			{
				$speed_array[]=-1; // no limit
			}
			if( in_array("vr2", $this->states_distant) )
			{
				$speed_array[]=40;
				$speed_array[]=60;
			}
		}
		if(!isset($speed_array))
		{
			$speed_array[]=0;
			$speed_array[]=-1;
		}
		if($next_speed<=60 && !in_array(60,$speed_array))
		{
			$speed_array=Array(0);
		}
		if($next_speed>60 && !in_array(-1,$speed_array))
		{
			$speed_array=Array(0);
			print_r($speed_array);
		}
		return $speed_array;
	}
	
	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 *//*
	public static function findState($tags, $next_speed_distant, $main_distance)
	{
		$state = "";
		if(isset($tags["railway:signal:distant:states"]))
		{
			if ( $next_speed_distant == 0 && strstr($tags["railway:signal:distant:states"], "vr0" )) // signal at end of route
			{
				$state = "vr0";
			}
			elseif ( $next_speed_distant > 60 && strstr($tags["railway:signal:distant:states"], "vr1" ) )
			{
				$state = "vr1"; 
			}
			elseif ( $next_speed_distant <= 60 && $next_speed_distant > 0 && strstr ( $tags["railway:signal:distant:states"], "vr2" ) )
			{
				$state = "vr2"; 
			}
			elseif ( $next_speed_distant > 60 && strstr ( $tags["railway:signal:distant:states"], "vr2" ) )
			{
				$state = "vr2"; 
			}
			elseif( strstr($tags["railway:signal:distant:states"], "vr0" ) ) // signal can not show vr2 or vr1
			{
				$state = "vr0";
			}
		}
		return $state;
	}
	*/
	
	/**
	 * returns description of the signals
	 * @return description for signal
	 */
	public function showDescription($description, $type)
	{
		return parent::showDescription(Lang::l_("German H/V"), $type);
	}
	

	public function getStateMain($main_distance)
	{
		/* state was already set by a more "intelligent" function */
		if($this->state_main)
		{
			return;
		}
		$state = "";
		if(isset($this->tags["railway:signal:main:states"]))
		{
			if ( $this->speed_main == 0 && strpos( $this->tags["railway:signal:main:states"], "hp0" ) ) // signal at end of route
			{
				$state = "hp0";
			}
			elseif ( $this->speed_main > 60 && strpos( $this->tags["railway:signal:main:states"], "hp1" ) )
			{
				$state = "hp1";
			}
			elseif ( $this->speed_main <= 60 && strpos ( $this->tags["railway:signal:main:states"], "hp2" ) )
			{
				$state = "hp2";
			}
			elseif ( $this->speed_main > 60 && strpos ( $this->tags["railway:signal:main:states"], "hp2" ) )
			{
				$state = "hp2";
			}
			else
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
			if ( $this->speed_distant == 0 && strpos( $this->tags["railway:signal:distant:states"], "vr0" ) ) // signal at end of route
			{
				$state = "vr0";
			}
			elseif ( $this->speed_distant > 60 && strpos( $this->tags["railway:signal:distant:states"], "vr1" ) )
			{
				$state = "vr1";
			}
			elseif ( $this->speed_distant <= 60 && strpos ( $this->tags["railway:signal:distant:states"], "vr2" ) )
			{
				$state = "vr2";
			}
			elseif ( $this->speed_distant > 60 && strpos ( $this->tags["railway:signal:distant:states"], "vr2" ) )
			{
				$state = "vr2";
			}
			else
			{
				$state = "vr0";
			}
		}
		$this->state_distant = $state;
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
