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
Class SignalPart
{
	/**
	 * tags of signal
	 * @var Array
	 */
	protected $tags;

	/**
	 * possible states of main signal
	 * @var String
	 */
	public $states_main;

	/**
	 * possible states of distant signal
	 * @var String
	 */
	public $states_distant;
	
	/**
	 * possible states of combined signal
	 * @var String
	 */
	public $states_combined;
	
	/**
	 * set state of main signal
	 * @var String
	 */
	public $state_main;
	
	/**
	 * set state of distant signal
	 * @var String
	 */
	public $state_distant;
	
	/**
	 * set state of combined signal
	 * @var String
	 */
	public $state_combined;
	
	/**
	 * set speed for main signal
	 * @var String
	 */
	public $speed_main;
	
	/**
	 * speed at main signal is track speed
	 * @var String
	 */
	public $speed_main_none;
	
	/**
	 * set speed for distant signal
	 * @var String
	 */
	public $speed_distant;
	
	/**
	 * speed at distant signal is track speed
	 * @var String
	 */
	public $speed_distant_none;
	
	public function __construct($tags)
	{
		$this->tags = $tags;

		if(isset($tags["railway:signal:distant:states"]))
		{
			$this->states_distant = Signals::signalStates($tags["railway:signal:distant:states"],"",false);
		}
		if(isset($tags["railway:signal:main:states"]))
		{
			$this->states_main = Signals::signalStates($tags["railway:signal:main:states"],"",false);
		}
		if(isset($tags["railway:signal:combined:states"]))
		{
			$this->states_combined = Signals::signalStates($tags["railway:signal:combined:states"],"",false);
			$this->states_main = $this->states_combined;
			$this->states_distant = $this->states_combined;
		}
	}

	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeedsMain($next_speed)
	{
		$speed_array[]=0;
		$speed_array[]=-1;
		return $speed_array;
	}

	/**
	 * return possible distant speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeedsDistant($next_speed)
	{
		$speed_array[]=0;
		$speed_array[]=-1;
		return $speed_array;
	}

	/**
	 * set State of signal
	 * @var speed speed of signal
	 */
	public function setSpeedMain($speed, $speed_none)
	{
		$this->speed_main = $speed;
		$this->speed_main_none = $speed_none;
	}

	/**
	 * set State of signal
	 * @var speed speed of signal
	 */
	public function setSpeedDistant($speed, $speed_none)
	{
		$this->speed_distant = $speed;
		$this->speed_distant_none = $speed_none;
	}
	
	
	/**
	 * returns description of the signals
	 * @param description of signal system
	 * @return description for signal
	 */
	public function showDescription($signal, $type)
	{
		$description = "";
		if(!$signal)
		{
			$signal = Lang::l_("Unknown ");
		}
		if($type == "Main")
		{
			$description .= $signal;
			if(isset($this->tags["railway:signal:combined:function"]))
			{
				$this->tags["railway:signal:main:function"] = $this->tags["railway:signal:combined:function"];
			}
			if(isset($this->tags["railway:signal:main:function"]))
			{
				if($this->tags["railway:signal:main:function"] == "entry")
				{
					$description .= Lang::l_(" Entry Signal");
				}
				elseif($this->tags["railway:signal:main:function"] == "intermediate")
				{
					$description .= Lang::l_(" Intermediate Signal");
				}
				elseif($this->tags["railway:signal:main:function"] == "exit")
				{
					$description .= Lang::l_(" Exit Signal");
				}
				elseif($this->tags["railway:signal:main:function"] == "block")
				{
					$description .= Lang::l_(" Block Signal");
				}
				else
				{
					$description .= Lang::l_(" Main Signal");
				}
			}
			else
			{
			
				$description .= Lang::l_(" Main Signal");
			}
		}
		if($type == "Distant") // for distant signals
		{
			if(isset($this->tags["railway:signal:combined"]))
			{
				$description .= Lang::l_("combined with ");
				if( isset($this->tags["railway:signal:combined:repeated"]) )
				{
					$this->tags["railway:signal:distant:repeated"] = $this->tags["railway:signal:combined:repeated"];
				}
				if( isset($this->tags["railway:signal:combined:shortened"]) )
				{
					$this->tags["railway:signal:distant:shortened"] = $this->tags["railway:signal:combined:shortened"];
				}
			}
			$description .= $signal;

			if(isset($this->tags["railway:signal:distant:repeated"]) && $this->tags["railway:signal:distant:repeated"] == "yes")
			{
				$description .= Lang::l_(" Repeated");
			}
			$description .= Lang::l_(" Distant Signal");
		}
		return $description;
	}

	public function getStateMain($main_distance)
	{
		$state = "";
		$this->state_main = $state;
		if(isset($this->tags["railway:signal:combined:states"]))
		{
			$this->state_combined = $state;
		}
	}

	public function getStateDistant()
	{
		$state = "";
		$this->state_distant = $state;
		if(isset($this->tags["railway:signal:combined:states"]))
		{
			$this->state_combined = $state;
		}
	}
}
?>