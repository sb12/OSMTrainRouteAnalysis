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
Class BOStrabH extends SignalPart
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
			if( in_array("h0", $this->states_main) )
			{
				$speed_array[] = 0;
			}
			if( in_array("h1", $this->states_main) || in_array("h2", $this->states_main) )
			{
				$speed_array[] = -1; // no limit
			}
			// FIXME: support for H3?
		}
		if(!isset($speed_array))
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
			if( in_array("v0", $this->states_distant) )
			{
				$speed_array[]=0;
			}
			if( in_array("v1", $this->states_distant) || in_array("v2", $this->states_distant))
			{
				$speed_array[]=-1; // no limit
			}
			// FIXME: support for V3?
		}
		if(!isset($speed_array))
		{
			$speed_array[]=0;
			$speed_array[]=-1;
		}
		return $speed_array;
	}
	
	/**
	 * returns description of the signals
	 * @return description for signal
	 */
	public function showDescription($description, $type)
	{
		return parent::showDescription(Lang::l_("German BOStrab H"), $type);
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
			if ( $this->speed_main == 0 && strpos( $this->tags["railway:signal:main:states"], "h0" ) ) // signal at end of route
			{
				$state = "h0";
			}
			elseif ( isset($this->tags["railway:signal:speed_limit:speed"]) && strpos($this->tags["railway:signal:speed_limit:speed"], $this->speed_main)  && strpos( $this->tags["railway:signal:main:states"], "h2" ) )
			{
				$state = "h2";
			}
			elseif ( strpos ( $this->tags["railway:signal:main:states"], "h1" ) )
			{
				$state = "h1";
			}
			elseif ( strpos ( $this->tags["railway:signal:main:states"], "h2" ) )
			{
				$state = "h2";
			}
			else
			{
				$state = "h0";
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
			if ( $this->speed_distant == 0 && strpos( $this->tags["railway:signal:distant:states"], "v0" ) ) // signal at end of route
			{
				$state = "v0";
			}
			elseif ( isset($this->tags["railway:signal:speed_limit_distant:speed"]) && strpos($this->tags["railway:signal:speed_limit_distant:speed"], $this->speed_main)  && strpos( $this->tags["railway:signal:distant:states"], "v1" ) )
			{
				$state = "v2";
			}
			elseif ( strpos ( $this->tags["railway:signal:distant:states"], "v1" ) )
			{
				$state = "v1";
			}
			elseif ( strpos ( $this->tags["railway:signal:distant:states"], "v2" ) )
			{
				$state = "v2";
			}
			else
			{
				$state = "v0";
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
