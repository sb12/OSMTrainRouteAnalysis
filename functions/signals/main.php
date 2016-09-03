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
 * Main Signal
 * @author sb12
 *
 */
Class Main
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
	public $states;
	
	public function __construct($tags)
	{
		$this->tags = $tags;
		if(isset($tags["railway:signal:combined:states"]))
		{
			$tags["railway:signal:main:states"] = $tags["railway:signal:combined:states"];
		}
		
		if(isset($tags["railway:signal:main:states"]))
		{
			$this->states = Signals::signalStates($tags["railway:signal:main:states"],"",false);
		}
	}

	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeeds()
	{
		$speed_array[]=0;
		$speed_array[]=-1;
		return $speed_array;
	}
}
?>