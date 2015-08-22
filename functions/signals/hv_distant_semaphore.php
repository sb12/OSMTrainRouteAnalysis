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
 * German H/V Distant Semaphore Signal
 * @author sb12
 *
 */
Class HV_distant_semaphore
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed_distant, $main_distance)
	{
		return HV_distant::findState($tags, $next_speed_distant, $main_distance);
	}
	
	
	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return HV_distant::showDescription();
	}
	
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
		$light_hp1 = '<circle transform="rotate(-60 16 29.5)" fill="red" cx="18.5" cy="29.5" r="2"/>';
		$light_vr0 =
		$light_vr1 =
		$rotate_vr2 =
		$rotate_vr1_light =
		$rotate_vr2_light =
		$show_vr0 =
		$show_vr1 = '';
		if( isset ( $_GET["state_distant"] ) && $_GET["state_distant"] == "vr1" )
		{
			$show_vr1 = ' display="none"';
			$light_vr2 = "&green;";
			$light_vr1 = "&green;";
			$rotate_vr1_light = ' transform="rotate(135 26.5 22.5)"';
			$rotate_vr2_light = ' transform="rotate(135 13.5 42.5)"';
		}
		else
		{
			$show_vr0 = ' display="none"';
			$light_vr1 = "&yellow;";
			$light_vr2 = "&yellow;";
		}
		if( isset ( $_GET["state_distant"] ) && $_GET["state_distant"] == "vr2")
		{
			$rotate_vr2 = ' transform="rotate(-45 20 36)"';
			$rotate_vr1_light = ' transform="rotate(135 26.5 22.5)"';
			$light_vr1 = "&green;";
		}
		$image = '
			<g transform="translate(0 ' . $height . ')">
			
				<g' . $rotate_vr1_light . '>
					<rect x="24" y="20" rx="2.5" ry="2.5" width="5" height="10" fill="#000000"/>
					<circle style="' . $light_vr1 . '" cx="26.5" cy="22.5" r="2"/>
				</g>
				<g' . $rotate_vr2_light . '>
					<rect x="11" y="35" rx="2.5" ry="2.5" width="5" height="10" fill="#000000"/>
					<circle style="' . $light_vr2 . '" cx="13.5" cy="42.5" r="2"/>
				</g>
				
				<g>
					<polygon fill="#000000" points="19,15 21,15 21,69 19,69"/>
				</g>
				<g ' . $show_vr1 . '>
					<circle fill="#FFFFFF" stroke="#000000" stroke-width="0.1" cx="20" cy="11" r="10"/>
					<circle fill="orange" stroke="#000000" stroke-width="1" cx="20" cy="11" r="7"/>
				</g>
				<g ' . $show_vr0 . '>
					<rect fill="#00000" stroke="#000000" stroke-width="0.1" x="10" y="10" width="20" height="2"/>
				</g>';
		
		if( !isset($_GET["railway:signal:distant:states"]) || strpos( $_GET["railway:signal:distant:states"], "vr2" ))
		{
			$image .= '
				<g' . $rotate_vr2 . '>
					<polygon fill="#FFFFFF" stroke="#000000" stroke-width="0.1" points="17,24 23,24 23,45.5 20,49 17,45.5"/>
					<polygon fill="orange" stroke="#000000" stroke-width="1" points="18.5,25.5 21.5,25.5 21.5,44.5 20,47 18.5,44.5"/>
				</g>';
		}
		
		$image .= '
			</g>';
		$height = 70;
		return array($image, $height);
	}
}