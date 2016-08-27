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
/**
 * Distant Speed Signal
 * @author sb12
 *
 */
Class Speed_Distant
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
	 * set speed for distant signal
	 * @var String
	 */
	public $speed_distant;
	
	public function __construct($tags)
	{
		$this->tags = $tags;
	}

	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeedsDistant()
	{
		if(isset($this->tags["railway:signal:speed_limit_distant:speed"]))
		{
			$speed_array = Signals::signalStates($this->tags["railway:signal:speed_limit_distant:speed"],"",false);
			$speed_array = str_replace("off", -1, $speed_array);
		}
		else
		{
			$speed_array[]=-1;
		}
		$this->states = $speed_array;
		return $speed_array;
	}
	
	public function setSpeedDistant($signal_speed)
	{
		$this->speed_distant = $signal_speed;
	}


	/**
	 * set shown speed for signal
	 */
	public function getSpeedDistant()
	{
		if(!$this->states) //Call function in case there is no main signal that called it.
		{
			$this->possibleSpeedsDistant();	
		}
		if(in_array($this->speed_distant, $this->states))
		{
			$this->speed_distant = $this->speed_distant;
		}
		else
		{
			$this->speed_distant = "off";
		}
	}
	

	/**
	 * returns description of the signals
	 * @return description for signal
	 */
	public function showDescription($signal,$type)
	{
		if( isset($this->tags["railway:signal:distant"]) || isset($this->tags["railway:signal:combined"]) )
		{
			$description = Lang::l_(" with ");
		}
		else
		{
			$description = "";
		}
		$description .= $signal;
		$description .= Lang::l_(" Distant Speed Signal");
		if($this->states)
		{
			$description .= " (";
			foreach($this->states as $speed)
			{
				$speed = str_replace(-1, "off", $speed);
				if($speed == $this->speed_distant)
				{
					$speed = "<b>" . $speed . "</b>";
				}
				$description .= $speed . ", ";
			}
			$description = substr($description,0, strlen($description)-2);
			$description .= ")";
		}
		else 
		{
			$description .= " (".Lang::l_("unknown speeds").")";
		}
		
		return $description;
	}
}
?>