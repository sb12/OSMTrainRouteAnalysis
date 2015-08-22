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
 * German H/V Main Semaphore Signal
 * @author sb12
 *
 */
Class HV_main_semaphore
{

	/**
	 * returns the state of the signals
	 * @param $tags array tags of the signal
	 * @param $next_speed int speed which is relevant for the signal
	 * @param $main_distance int distance to next main signal
	 */
	public static function findState($tags, $next_speed, $main_distance)
	{
		return HV_main::findState($tags, $next_speed, $main_distance);
	}
	

	/**
	 * returns description of the signals
	 * @param $tags array tags of the signal
	 */
	public static function showDescription()
	{
		return HV_main::showDescription();
	}
	
	
	/**
	 * generate image
	 * @param $tags array tags of the signal
	 */
	public static function generateImage($height)
	{
				
		$light_hp1 = '<circle transform="rotate(-60 16 29.5)" style="&red;" cx="18.5" cy="29.5" r="2"/>';
		$rotate_hp1 = $rotate_hp2_light = "";
		$light_hp2 = '';
		$rotate_hp2 = ' transform="rotate(-90 9 57)"';
		if( isset ( $_GET["state_main"] ) && ( $_GET["state_main"] == "hp1" || $_GET["state_main"] == "hp2" ) ) 
		{
			$rotate_hp1 = ' transform="rotate(-45 9 22)"';
			$light_hp1 = '<circle transform="rotate(-60 16 29.5)" style="&green;" cx="13.5" cy="29.5" r="2"/>';
		}
		if( isset ( $_GET["state_main"] ) && $_GET["state_main"] == "hp2")
		{
			$rotate_hp2 = ' transform="rotate(-45 9 57)"';
			$rotate_hp2_light = ' transform="rotate(-45 9 57)"';
			$light_hp2 = '<circle transform="rotate(-60 16 64.5)" style="&yellow;" cx="13.5" cy="64.5" r="2"/>';
		}
		
		$image = '
			<g transform="translate(0 '.$height.')">
				<g>
					<polygon fill="#000000" points="8,15 10,15 10,69 8,69"/>
				</g>
				<g' . $rotate_hp1 . '>				
					<polygon fill="#FFFFFF" stroke="red" stroke-width="1" points="0.5,20.5 30.5,20.5 30.5,23.5 0.5,23.5"/>
					<circle fill="#FFFFFF" stroke="red" stroke-width="1" cx="31" cy="22" r="3.5"/>
					<rect transform="rotate(-60 16 29.5)" x="11" y="27" rx="2.5" ry="2.5" width="10" height="5" fill="#000000"/>
					' . $light_hp1 . '
					
				</g>';
		if( isset($_GET["railway:signal:main:states"]) && strpos( $_GET["railway:signal:main:states"], "hp2" ))
		{
			$image .= '	
				<g' . $rotate_hp2 . '>				
					<polygon fill="#FFFFFF" stroke="red" stroke-width="1" points="0.5,55.5 30.5,55.5 30.5,58.5 0.5,58.5"/>
					<circle fill="#FFFFFF" stroke="red" stroke-width="1" cx="31" cy="57" r="3.5"/>
				</g>
				
				<g' . $rotate_hp2_light . '>	
					<rect transform="rotate(-60 16 64.5)" x="11" y="62" rx="2.5" ry="2.5" width="10" height="5" fill="#000000"/>
					' . $light_hp2 . '
					
				</g>';
		}
		$image .= '
			</g>';
		$height = 70;
		return array($image, $height);
	}
}
