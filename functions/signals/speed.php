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
 * Speed Signal
 * @author sb12
 *
 */
Class Speed
{
	/**
	 * tags of signal
	 * @var Array
	 */
	protected $tags;
	
	/**
	 * possible states of signal
	 * @var String
	 */
	protected $states;
	
	/**
	 * shown speed of signal
	 * @var String
	 */
	public $speed;
	
	/**
	 * set speed for main signal
	 * @var String
	 */
	protected $speed_main;
	
	/**
	 * set speed for main signal
	 * @var String
	 */
	public $state_main;
	
	public function __construct($tags)
	{
		$this->tags = $tags;
	}

	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeedsMain($speed)
	{
		return $this->possibleSpeeds();
	}

	public function getStateMain()
	{
		$this->state_main = "";
	}

	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeeds()
	{
		if(isset($this->tags["railway:signal:speed_limit:speed"]))
		{
			$speed_array = Signals::signalStates($this->tags["railway:signal:speed_limit:speed"],"",false);
			$speed_array = str_replace("off", -1, $speed_array);
		}
		else
		{
			$speed_array[]=-1;
		}
		$this->states = $speed_array; 
		return $speed_array;
	}

	/**
	 * set Speed for signal
	 * @var speed speed of signal
	 */
	public function setSpeedMain($speed)
	{
		$this->speed_main = $speed;
	}

	/**
	 * set shown speed for signal
	 */
	public function getSpeed()
	{
		if(in_array($this->speed_main, $this->states))
		{
			$this->speed = $this->speed_main;
		}
		else 
		{
			$this->speed = "off";
		}
	}


	/**
	 * returns description of the signals
	 * @return description for signal
	 */
	public function showDescription($signal,$type)
	{
		if( isset($this->tags["railway:signal:main"]) || isset($this->tags["railway:signal:combined"]) )
		{
			$description = Lang::l_(" with ");
		}
		else
		{
			$description = "";
		}
		$description .= $signal;
		$description .= Lang::l_(" Speed Signal");
		if($this->states)
		{
			$description .= " (";
			foreach($this->states as $speed)
			{
				$speed = str_replace(-1, "off", $speed);
				if($speed == $this->speed)
				{
					$speed = "<b>" . $speed . "</b>";
				}
				$description .= $speed . ", ";
			}
			$description = substr($description,0, strlen($description)-2); // remove commata
			$description .= ")";
		}
		
		return $description;
	}
}
?>