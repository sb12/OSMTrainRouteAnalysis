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
 * Ne2 Distant Signal
 * @author sb12
 *
 */
Class Ne2 extends SignalPart
{


	public function __construct($tags)
	{
		parent::__construct($tags);
	}
	
	/**
	 * return possible speeds the signal can show
	 * @return Array(int)
	 */
	public function possibleSpeedsDistant($next_speed)
	{
		// for now: assume that all ks signals can show hp0 and ks1/ks2
		$speed_array[]=0;
		$speed_array[]=-1;
		return $speed_array;
	}
	
	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed_distant, $main_distance)
	{
		$state = "";
		return $state;
	}
	
	
	/**
	 * returns description of the signals
	 * @return description for signal
	 */
	public function showDescription($description, $type)
	{
		return parent::showDescription(Lang::l_("German Ne2"), $type);
	}
	
	public function getStateDistant()
	{
		$this->state_main = "";
	}
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
			$image = '
			<g transform="translate(0 ' . $height . ')">
				<g>
					<polygon fill="white" stroke="black" stroke-width="1" points="12,2 28,2 28,28 12,28"/>
				</g>
				<g>
					<polygon fill="black" points="12,2 14,2 20,12 26,2 28,2 20,15"/>
				</g>
				<g>
					<polygon fill="black" points="12,28 14,28 20,18 26,28 28,28 20,15"/>
				</g>
			</g>';
		$height = 30;
		return array($image, $height);
	}
}