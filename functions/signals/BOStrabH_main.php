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
Class BOStrabH_main extends SignalPart
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
		$colour_h0 = "&red;";
		$colour_h1 = "&green;";
		$colour_h2 = "&yellow;";
	
		if(isset($_GET["state_main"]))
		{
			if($_GET["state_main"] == "h0")
			{
				$colour_h0 = "&red;";
				$colour_h1 = "&gray;";
				$colour_h2 = "&gray;";
			}
			if($_GET["state_main"] == "h1")
			{
				$colour_h0 = "&gray;";
				$colour_h1 = "&green;";
				$colour_h2 = "&gray;";
			}
			if($_GET["state_main"] == "h2")
			{
				$colour_h0 = "&gray;";
				$colour_h1 = "&green;";
				$colour_h2 = "&yellow;";
			}
		}
	
		if( $_GET["railway:signal:main:form"] == "light" )
		{
			$r_main = 4;

			$geometry = "12,1 28,1 28,33 12,33";
			$height = 34;
			$move = 0;
			if ( isset ( $_GET["railway:signal:main:states"] ) )
			{
				if ( strpos( $_GET["railway:signal:main:states"], "h2" ) )
				{
					$lights[] = Array(
						'id'        =>	'h2',
						'colour'    => $colour_h2,
						'cx'        => 20,
						'cy'        => 9,
						'r'         => $r_main,
					);
					$geometry = "12,1 28,1 28,49 12,49";
					$height = 50;
					$move = 16;
				}
			}
			$lights[] = Array(
				'id'        =>	'h0',
				'colour'    => $colour_h0,
				'cx'        => 20,
				'cy'        => 9+$move,
				'r'         => $r_main,
			);
			$lights[] = Array(
				'id'        =>	'h1',
				'colour'    => $colour_h1,
				'cx'        => 20,
				'cy'        => 25+$move,
				'r'         => $r_main,
			);
	
			return Signal_Light::generateImage($position,$height,$geometry,$lights);
		}
	}
}
