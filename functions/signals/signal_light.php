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
 * Unknown Main Light Signal
 * @author sb12
 *
 */
Class Signal_light
{
	
	/**
	 * generate image
	 * @param $position int y-position of the signal image
	 * @param $height int height of the signal image
	 * @param $geometry String geometry of the signal
	 * @param $lights array position and color of lights
	 */
	public static function generateImage($position, $height, $geometry, $lights)
	{
		$image = '
				<g transform="translate(0 ' . $position . ')">
					<g>
						<polygon fill="&background;" points="' . $geometry . '"/>
					</g>
					';	
		foreach($lights as $light)
		{
			if(isset($light["id"]))
			{
				$image .= '
    		<g id="' . $light["id"] . '">
    		';
			}
			if(isset($light["cx"]))
			{
				$cx = $light["cx"];
			}
			if(isset($light["cy"]))
			{
				$cy = $light["cy"];
			}
			if(isset($light["r"]))
			{
				$r = $light["r"];
			}
			$class = "";
			if(isset($light["class"]))
			{
				$class = " class=\"".$light["class"]."\"";
			}
			if(isset($light["colour"]))
			{
				$colour = $light["colour"];
			}
				$image .= '
    		<circle'.$class.' style="' . $colour . '" cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '"/>
    			';
			if(isset($light["id"]))
			{
				$image .= '
    		</g>
    		';
			}
		}
		$image .= '
				</g>';
		return array($image, $height);
	}
}