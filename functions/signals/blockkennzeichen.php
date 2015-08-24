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
 * German Blockkennzeichen
 * @author sb12
 *
 */
Class Blockkennzeichen
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed, $main_distance)
	{
		return; //not needed
	}
	
	
	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return Lang::l_("German Blockkennzeichen");
	}
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
		$ref = "";
		if( isset($_GET["ref"]) )
		{
			$ref = $_GET["ref"];
		}
		$show_ref = "";
		$font_size = 20;
		$y = 27;
		if ( strlen($ref) <= 5 && $ref > 0 && !strstr($ref, " ") ) // number with 5 digits or less and no spaces
		{
			$show_ref = $ref;
			if ( strlen($ref) == 5 )
			{
				$font_size = 12;
				$y = 25;
			}
			elseif ( strlen($ref) == 4 )
			{
				$font_size = 13;
				$y = 25;
			}
		}
		else
		{
			$refs = explode(" ", $ref);
			if( count($refs) == 2 && $refs[0] > 0 && $refs[1] > 0 && strlen ( $refs[0] ) <= 4 && strlen ( $refs[1] ) <= 4 ) // 2 numbers with space in between with 4 digits or less each
			{
				$show_ref = '<tspan x="20" y="18" font-size="14">' . $refs[0] . '</tspan><tspan x="20" y="32" font-size="14">' . $refs[1] . '</tspan>';
			}
		}
		$image = '
			<g transform="translate(0 ' . $height . ')">
				<circle stroke="#000000" fill="#FFFFFF" cx="20" cy="20" r="15"/>
    		
    			<text x="20" y="' . $y . '" fill="#000000" text-anchor="middle" font-size="' . $font_size . '" style="font-family:\'DIN 1451 Engschrift\', Impact, Sans Serif">' . $show_ref . '</text>
			</g>';
		$height = 40;
		return array($image, $height);
	}
}