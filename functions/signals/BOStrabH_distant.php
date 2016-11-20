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
Class BOStrabH_distant extends SignalPart
{

	public function __construct($tags)
	{
		parent::__construct($tags);
	}

	/**
	 * generate image
	 * @param $position int y-position of the signal image
	 */
	public static function generateImage($position)
	{
		$colour_v0_1 = "&yellow;";
		$colour_v0_2 = "&yellow;";
		$colour_v1_1 = "&green;";
		$colour_v1_2 = "&green;";
	
		if(isset($_GET["state_distant"]))
		{
			if($_GET["state_distant"] == "v0")
			{
				$colour_v0_1 = "&yellow;";
				$colour_v0_2 = "&yellow;";
				$colour_v1_1 = "&gray;";
				$colour_v1_2 = "&gray;";
			}
			if($_GET["state_distant"] == "v1")
			{
				$colour_v0_1 = "&gray;";
				$colour_v0_2 = "&gray;";
				$colour_v1_1 = "&green;";
				$colour_v1_2 = "&green;";
			}
			if($_GET["state_distant"] == "v2")
			{
				$colour_v0_1 = "&gray;";
				$colour_v0_2 = "&yellow;";
				$colour_v1_1 = "&green;";
				$colour_v1_2 = "&gray;";
			}
		}
	
		if( $_GET["railway:signal:distant:form"] == "light" )
		{
			$geometry = "10,1 30,1 30,29 10,29";
			$r_main = 3;
			
			$lights[] = Array(
				'id'        =>	'v0_1',
				'colour'    => $colour_v0_1,
				'cx'        => 16,
				'cy'        => 15,
				'r'         => $r_main,
			);
			$lights[] = Array(
				'id'        =>	'v0_2',
				'colour'    => $colour_v0_2,
				'cx'        => 24,
				'cy'        => 7,
				'r'         => $r_main,
			);
			$lights[] = Array(
				'id'        =>	'v1_1',
				'colour'    => $colour_v1_1,
				'cx'        => 16,
				'cy'        => 23,
				'r'         => $r_main,
			);
			$lights[] = Array(
				'id'        =>	'v1_2',
				'colour'    => $colour_v1_2,
				'cx'        => 24,
				'cy'        => 15,
				'r'         => $r_main,
			);

			return Signal_Light::generateImage($position,36,$geometry,$lights);
		}
	}
}
