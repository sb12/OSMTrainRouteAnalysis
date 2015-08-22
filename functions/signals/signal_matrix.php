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
 * German Zs3 Speed signal
 * @author sb12
 *
 */
Class Signal_matrix
{

	/**
	 * returns the matric for the signal
	 * @param $value String value which is shown on signal
	 * @param $vlist array list of possible values
	 */
	public static function getMatrix($value, $vlist, $colour = "&st")
	{

		// off
		$matrix[""][]=Array(
				"0","0","0","0","0");
		$matrix[""][]=Array(
				"0","0","0","0","0");
		$matrix[""][]=Array(
				"0","0","0","0","0");
		$matrix[""][]=Array(
				"0","0","0","0","0");
		$matrix[""][]=Array(
				"0","0","0","0","0");
		$matrix[""][]=Array(
				"0","0","0","0","0");
		$matrix[""][]=Array(
				"0","0","0","0","0");
		// A
		$matrix["A"][]=Array(
				"0","1","1","1","0");
		$matrix["A"][]=Array(
				"1","0","0","0","1");
		$matrix["A"][]=Array(
				"1","0","0","0","1");
		$matrix["A"][]=Array(
				"1","1","1","1","1");
		$matrix["A"][]=Array(
				"1","0","0","0","1");
		$matrix["A"][]=Array(
				"1","0","0","0","1");
		$matrix["A"][]=Array(
				"1","0","0","0","1");
		
		
		// B
		$matrix["B"][]=Array(
				"1","1","1","1","0");
		$matrix["B"][]=Array(
				"1","0","0","0","1");
		$matrix["B"][]=Array(
				"1","0","0","0","1");
		$matrix["B"][]=Array(
				"1","1","1","1","1");
		$matrix["B"][]=Array(
				"1","0","0","0","1");
		$matrix["B"][]=Array(
				"1","0","0","0","1");
		$matrix["B"][]=Array(
				"1","1","1","1","0");
		
		
		// C
		$matrix["C"][]=Array(
				"0","1","1","1","1");
		$matrix["C"][]=Array(
				"1","0","0","0","0");
		$matrix["C"][]=Array(
				"1","0","0","0","0");
		$matrix["C"][]=Array(
				"1","0","0","0","0");
		$matrix["C"][]=Array(
				"1","0","0","0","0");
		$matrix["C"][]=Array(
				"1","0","0","0","0");
		$matrix["C"][]=Array(
				"0","1","1","1","1");
		
		
		// D
		$matrix["D"][]=Array(
				"1","1","1","1","0");
		$matrix["D"][]=Array(
				"1","0","0","0","1");
		$matrix["D"][]=Array(
				"1","0","0","0","1");
		$matrix["D"][]=Array(
				"1","0","0","0","1");
		$matrix["D"][]=Array(
				"1","0","0","0","1");
		$matrix["D"][]=Array(
				"1","0","0","0","1");
		$matrix["D"][]=Array(
				"1","1","1","1","0");
		
		
		// E
		$matrix["E"][]=Array(
				"1","1","1","1","1");
		$matrix["E"][]=Array(
				"1","0","0","0","0");
		$matrix["E"][]=Array(
				"1","0","0","0","0");
		$matrix["E"][]=Array(
				"1","1","1","1","0");
		$matrix["E"][]=Array(
				"1","0","0","0","0");
		$matrix["E"][]=Array(
				"1","0","0","0","0");
		$matrix["E"][]=Array(
				"1","1","1","1","1");
		
		
		// F
		$matrix["F"][]=Array(
				"1","1","1","1","1");
		$matrix["F"][]=Array(
				"1","0","0","0","0");
		$matrix["F"][]=Array(
				"1","0","0","0","0");
		$matrix["F"][]=Array(
				"1","1","1","1","0");
		$matrix["F"][]=Array(
				"1","0","0","0","0");
		$matrix["F"][]=Array(
				"1","0","0","0","0");
		$matrix["F"][]=Array(
				"1","0","0","0","0");
		
		
		// G
		$matrix["G"][]=Array(
				"0","1","1","1","0");
		$matrix["G"][]=Array(
				"1","0","0","0","1");
		$matrix["G"][]=Array(
				"1","0","0","0","0");
		$matrix["G"][]=Array(
				"1","0","0","0","0");
		$matrix["G"][]=Array(
				"1","0","0","1","1");
		$matrix["G"][]=Array(
				"1","0","0","0","1");
		$matrix["G"][]=Array(
				"0","1","1","1","0");
		
		
		// H
		$matrix["H"][]=Array(
				"1","0","0","0","1");
		$matrix["H"][]=Array(
				"1","0","0","0","1");
		$matrix["H"][]=Array(
				"1","0","0","0","1");
		$matrix["H"][]=Array(
				"1","1","1","1","1");
		$matrix["H"][]=Array(
				"1","0","0","0","1");
		$matrix["H"][]=Array(
				"1","0","0","0","1");
		$matrix["H"][]=Array(
				"1","0","0","0","1");
		
		
		// I
		$matrix["I"][]=Array(
				"0","1","1","1","0");
		$matrix["I"][]=Array(
				"0","0","1","0","0");
		$matrix["I"][]=Array(
				"0","0","1","0","0");
		$matrix["I"][]=Array(
				"0","0","1","0","0");
		$matrix["I"][]=Array(
				"0","0","1","0","0");
		$matrix["I"][]=Array(
				"0","0","1","0","0");
		$matrix["I"][]=Array(
				"0","1","1","1","0");
		
		
		// J
		$matrix["J"][]=Array(
				"1","1","1","1","0");
		$matrix["J"][]=Array(
				"0","0","0","1","0");
		$matrix["J"][]=Array(
				"0","0","0","1","0");
		$matrix["J"][]=Array(
				"0","0","0","1","0");
		$matrix["J"][]=Array(
				"0","0","0","1","0");
		$matrix["J"][]=Array(
				"1","0","0","1","0");
		$matrix["J"][]=Array(
				"0","1","1","0","0");
		
		
		// K
		$matrix["K"][]=Array(
				"1","0","0","0","1");
		$matrix["K"][]=Array(
				"1","0","0","1","0");
		$matrix["K"][]=Array(
				"1","0","1","0","0");
		$matrix["K"][]=Array(
				"1","1","0","0","0");
		$matrix["K"][]=Array(
				"1","0","1","0","0");
		$matrix["K"][]=Array(
				"1","0","0","1","0");
		$matrix["K"][]=Array(
				"1","0","0","0","1");
		
		
		// L
		$matrix["L"][]=Array(
				"1","0","0","0","0");
		$matrix["L"][]=Array(
				"1","0","0","0","0");
		$matrix["L"][]=Array(
				"1","0","0","0","0");
		$matrix["L"][]=Array(
				"1","0","0","0","0");
		$matrix["L"][]=Array(
				"1","0","0","0","0");
		$matrix["L"][]=Array(
				"1","0","0","0","0");
		$matrix["L"][]=Array(
				"1","1","1","1","1");
		
		
		// M
		$matrix["M"][]=Array(
				"1","0","0","0","1");
		$matrix["M"][]=Array(
				"1","1","0","1","1");
		$matrix["M"][]=Array(
				"1","0","1","0","1");
		$matrix["M"][]=Array(
				"1","0","0","0","1");
		$matrix["M"][]=Array(
				"1","0","0","0","1");
		$matrix["M"][]=Array(
				"1","0","0","0","1");
		$matrix["M"][]=Array(
				"1","0","0","0","1");
		
		
		// N
		$matrix["N"][]=Array(
				"1","0","0","0","1");
		$matrix["N"][]=Array(
				"1","0","0","0","1");
		$matrix["N"][]=Array(
				"1","1","0","0","1");
		$matrix["N"][]=Array(
				"1","0","1","0","1");
		$matrix["N"][]=Array(
				"1","0","0","1","1");
		$matrix["N"][]=Array(
				"1","0","0","0","1");
		$matrix["N"][]=Array(
				"1","0","0","0","1");
		
		
		// O
		$matrix["O"][]=Array(
				"0","1","1","1","0");
		$matrix["O"][]=Array(
				"1","0","0","0","1");
		$matrix["O"][]=Array(
				"1","0","0","0","1");
		$matrix["O"][]=Array(
				"1","0","0","0","1");
		$matrix["O"][]=Array(
				"1","0","0","0","1");
		$matrix["O"][]=Array(
				"1","0","0","0","1");
		$matrix["O"][]=Array(
				"0","1","1","1","0");
		
		
		// P
		$matrix["P"][]=Array(
				"1","1","1","1","0");
		$matrix["P"][]=Array(
				"1","0","0","0","1");
		$matrix["P"][]=Array(
				"1","0","0","0","1");
		$matrix["P"][]=Array(
				"1","1","1","1","0");
		$matrix["P"][]=Array(
				"1","0","0","0","0");
		$matrix["P"][]=Array(
				"1","0","0","0","0");
		$matrix["P"][]=Array(
				"1","0","0","0","0");
		
		
		// Q
		$matrix["Q"][]=Array(
				"0","1","1","1","0");
		$matrix["Q"][]=Array(
				"1","0","0","0","1");
		$matrix["Q"][]=Array(
				"1","0","0","0","1");
		$matrix["Q"][]=Array(
				"1","0","0","0","1");
		$matrix["Q"][]=Array(
				"1","0","0","0","1");
		$matrix["Q"][]=Array(
				"0","1","1","1","0");
		$matrix["Q"][]=Array(
				"0","0","0","0","1");
		
		
		// R
		$matrix["R"][]=Array(
				"1","1","1","1","0");
		$matrix["R"][]=Array(
				"1","0","0","0","1");
		$matrix["R"][]=Array(
				"1","0","0","0","1");
		$matrix["R"][]=Array(
				"1","1","1","1","0");
		$matrix["R"][]=Array(
				"1","0","1","0","0");
		$matrix["R"][]=Array(
				"1","0","0","1","0");
		$matrix["R"][]=Array(
				"1","0","0","0","1");
		
		
		// S
		$matrix["S"][]=Array(
				"0","1","1","1","1");
		$matrix["S"][]=Array(
				"1","0","0","0","0");
		$matrix["S"][]=Array(
				"1","0","0","0","0");
		$matrix["S"][]=Array(
				"0","1","1","1","0");
		$matrix["S"][]=Array(
				"0","0","0","0","1");
		$matrix["S"][]=Array(
				"0","0","0","0","1");
		$matrix["S"][]=Array(
				"1","1","1","1","0");
		
		
		// T
		$matrix["T"][]=Array(
				"1","1","1","1","1");
		$matrix["T"][]=Array(
				"0","0","1","0","0");
		$matrix["T"][]=Array(
				"0","0","1","0","0");
		$matrix["T"][]=Array(
				"0","0","1","0","0");
		$matrix["T"][]=Array(
				"0","0","1","0","0");
		$matrix["T"][]=Array(
				"0","0","1","0","0");
		$matrix["T"][]=Array(
				"0","0","1","0","0");
		
		
		// U
		$matrix["U"][]=Array(
				"1","0","0","0","1");
		$matrix["U"][]=Array(
				"1","0","0","0","1");
		$matrix["U"][]=Array(
				"1","0","0","0","1");
		$matrix["U"][]=Array(
				"1","0","0","0","1");
		$matrix["U"][]=Array(
				"1","0","0","0","1");
		$matrix["U"][]=Array(
				"1","0","0","0","1");
		$matrix["U"][]=Array(
				"0","1","1","1","0");
		
		
		// V
		$matrix["V"][]=Array(
				"1","0","0","0","1");
		$matrix["V"][]=Array(
				"1","0","0","0","1");
		$matrix["V"][]=Array(
				"1","0","0","0","1");
		$matrix["V"][]=Array(
				"0","1","0","1","0");
		$matrix["V"][]=Array(
				"0","1","0","1","0");
		$matrix["V"][]=Array(
				"0","0","1","0","0");
		$matrix["V"][]=Array(
				"0","0","1","0","0");
		
		
		// W
		$matrix["W"][]=Array(
				"1","0","0","0","1");
		$matrix["W"][]=Array(
				"1","0","0","0","1");
		$matrix["W"][]=Array(
				"1","0","0","0","1");
		$matrix["W"][]=Array(
				"1","0","1","0","1");
		$matrix["W"][]=Array(
				"1","0","1","0","1");
		$matrix["W"][]=Array(
				"0","1","0","1","0");
		$matrix["W"][]=Array(
				"0","1","0","1","0");
		
		
		// X
		$matrix["X"][]=Array(
				"1","0","0","0","1");
		$matrix["X"][]=Array(
				"1","0","0","0","1");
		$matrix["X"][]=Array(
				"0","1","0","1","0");
		$matrix["X"][]=Array(
				"0","0","1","0","0");
		$matrix["X"][]=Array(
				"0","1","0","1","0");
		$matrix["X"][]=Array(
				"1","0","0","0","1");
		$matrix["X"][]=Array(
				"1","0","0","0","1");
		
		
		// Y
		$matrix["Y"][]=Array(
				"1","0","0","0","1");
		$matrix["Y"][]=Array(
				"1","0","0","0","1");
		$matrix["Y"][]=Array(
				"0","1","0","1","0");
		$matrix["Y"][]=Array(
				"0","0","1","0","0");
		$matrix["Y"][]=Array(
				"0","0","1","0","0");
		$matrix["Y"][]=Array(
				"0","0","1","0","0");
		$matrix["Y"][]=Array(
				"0","0","1","0","0");
		
		
		// Z
		$matrix["Z"][]=Array(
				"1","1","1","1","1");
		$matrix["Z"][]=Array(
				"0","0","0","0","1");
		$matrix["Z"][]=Array(
				"0","0","0","1","0");
		$matrix["Z"][]=Array(
				"0","0","1","0","0");
		$matrix["Z"][]=Array(
				"0","1","0","0","0");
		$matrix["Z"][]=Array(
				"1","0","0","0","0");
		$matrix["Z"][]=Array(
				"1","1","1","1","1");
		
		
		// 10
		$matrix["10"][]=Array(
				"0","0","0","1","0");
		$matrix["10"][]=Array(
				"0","0","1","1","0");
		$matrix["10"][]=Array(
				"0","0","0","1","0");
		$matrix["10"][]=Array(
				"0","0","0","1","0");
		$matrix["10"][]=Array(
				"0","0","0","1","0");
		$matrix["10"][]=Array(
				"0","0","0","1","0");
		$matrix["10"][]=Array(
				"0","0","0","1","0");
		
		
		// 20
		$matrix["20"][]=Array(
				"0","1","1","1","0");
		$matrix["20"][]=Array(
				"1","0","0","0","1");
		$matrix["20"][]=Array(
				"0","0","0","0","1");
		$matrix["20"][]=Array(
				"0","0","0","1","0");
		$matrix["20"][]=Array(
				"0","0","1","0","0");
		$matrix["20"][]=Array(
				"0","1","0","0","0");
		$matrix["20"][]=Array(
				"1","1","1","1","1");
		
		
		// 30
		$matrix["30"][]=Array(
				"1","1","1","1","0");
		$matrix["30"][]=Array(
				"0","0","0","0","1");
		$matrix["30"][]=Array(
				"0","0","0","0","1");
		$matrix["30"][]=Array(
				"0","1","1","1","0");
		$matrix["30"][]=Array(
				"0","0","0","0","1");
		$matrix["30"][]=Array(
				"0","0","0","0","1");
		$matrix["30"][]=Array(
				"1","1","1","1","0");
		
		
		// 40
		$matrix["40"][]=Array(
				"1","0","0","0","0");
		$matrix["40"][]=Array(
				"1","0","0","1","0");
		$matrix["40"][]=Array(
				"1","0","0","1","0");
		$matrix["40"][]=Array(
				"1","1","1","1","1");
		$matrix["40"][]=Array(
				"0","0","0","1","0");
		$matrix["40"][]=Array(
				"0","0","0","1","0");
		$matrix["40"][]=Array(
				"0","0","0","1","0");
		
		
		// 50
		$matrix["50"][]=Array(
				"1","1","1","1","1");
		$matrix["50"][]=Array(
				"1","0","0","0","0");
		$matrix["50"][]=Array(
				"1","0","0","0","0");
		$matrix["50"][]=Array(
				"1","1","1","1","0");
		$matrix["50"][]=Array(
				"0","0","0","0","1");
		$matrix["50"][]=Array(
				"0","0","0","0","1");
		$matrix["50"][]=Array(
				"0","1","1","1","0");
		
		
		// 60
		$matrix["60"][]=Array(
				"0","1","1","1","0");
		$matrix["60"][]=Array(
				"1","0","0","0","0");
		$matrix["60"][]=Array(
				"1","0","0","0","0");
		$matrix["60"][]=Array(
				"1","1","1","1","0");
		$matrix["60"][]=Array(
				"1","0","0","0","1");
		$matrix["60"][]=Array(
				"1","0","0","0","1");
		$matrix["60"][]=Array(
				"0","1","1","1","0");
		
		
		// 70
		$matrix["70"][]=Array(
				"1","1","1","1","1");
		$matrix["70"][]=Array(
				"0","0","0","0","1");
		$matrix["70"][]=Array(
				"0","0","0","1","0");
		$matrix["70"][]=Array(
				"0","0","1","0","0");
		$matrix["70"][]=Array(
				"0","1","0","0","0");
		$matrix["70"][]=Array(
				"1","0","0","0","0");
		$matrix["70"][]=Array(
				"1","0","0","0","0");
		
		
		// 80
		$matrix["80"][]=Array(
				"0","1","1","1","0");
		$matrix["80"][]=Array(
				"1","0","0","0","1");
		$matrix["80"][]=Array(
				"1","0","0","0","1");
		$matrix["80"][]=Array(
				"0","1","1","1","0");
		$matrix["80"][]=Array(
				"1","0","0","0","1");
		$matrix["80"][]=Array(
				"1","0","0","0","1");
		$matrix["80"][]=Array(
				"0","1","1","1","0");
		
		
		// 90
		$matrix["90"][]=Array(
				"0","1","1","1","0");
		$matrix["90"][]=Array(
				"1","0","0","0","1");
		$matrix["90"][]=Array(
				"1","0","0","0","1");
		$matrix["90"][]=Array(
				"0","1","1","1","1");
		$matrix["90"][]=Array(
				"0","0","0","0","1");
		$matrix["90"][]=Array(
				"0","0","0","0","1");
		$matrix["90"][]=Array(
				"0","1","1","1","0");
		
		
		// 100
		$matrix["100"][]=Array(
				"1","0","0","1","0");
		$matrix["100"][]=Array(
				"1","0","1","0","1");
		$matrix["100"][]=Array(
				"1","0","1","0","1");
		$matrix["100"][]=Array(
				"1","0","1","0","1");
		$matrix["100"][]=Array(
				"1","0","1","0","1");
		$matrix["100"][]=Array(
				"1","0","1","0","1");
		$matrix["100"][]=Array(
				"1","0","0","1","0");
		
		// 110
		$matrix["110"][]=Array(
				"1","1","0","1","1");
		$matrix["110"][]=Array(
				"0","1","0","0","1");
		$matrix["110"][]=Array(
				"0","1","0","0","1");
		$matrix["110"][]=Array(
				"0","1","0","0","1");
		$matrix["110"][]=Array(
				"0","1","0","0","1");
		$matrix["110"][]=Array(
				"0","1","0","0","1");
		$matrix["110"][]=Array(
				"0","1","0","0","1");
		
		// 120
		$matrix["120"][]=Array(
				"1","0","1","1","0");
		$matrix["120"][]=Array(
				"1","0","0","0","1");
		$matrix["120"][]=Array(
				"1","0","0","0","1");
		$matrix["120"][]=Array(
				"1","0","0","1","0");
		$matrix["120"][]=Array(
				"1","0","1","0","0");
		$matrix["120"][]=Array(
				"1","0","1","0","0");
		$matrix["120"][]=Array(
				"1","0","1","1","1");
		
		// 130
		$matrix["130"][]=Array(
				"1","0","1","1","0");
		$matrix["130"][]=Array(
				"1","0","0","0","1");
		$matrix["130"][]=Array(
				"1","0","0","0","1");
		$matrix["130"][]=Array(
				"1","0","1","1","0");
		$matrix["130"][]=Array(
				"1","0","0","0","1");
		$matrix["130"][]=Array(
				"1","0","0","0","1");
		$matrix["130"][]=Array(
				"1","0","1","1","0");
		
		// 140
		$matrix["140"][]=Array(
				"1","0","1","0","0");
		$matrix["140"][]=Array(
				"1","0","1","0","0");
		$matrix["140"][]=Array(
				"1","0","1","0","0");
		$matrix["140"][]=Array(
				"1","0","1","0","1");
		$matrix["140"][]=Array(
				"1","0","1","1","1");
		$matrix["140"][]=Array(
				"1","0","0","0","1");
		$matrix["140"][]=Array(
				"1","0","0","0","1");

		foreach($vlist as $v)
		{
			if ( $v > 0 && $v != $value )
			{
				for( $i = 0; $i < 5; $i++)
				{
					for( $j = 0; $j < 7; $j++)
					{
						if(isset($matrix[$v][$j][$i]) && $matrix[$v][$j][$i]==1 && $matrix[$value][$j][$i]==0)
						{
							$matrix[$value][$j][$i] = 2;
						}
					}
				}
			}
		}
		$r = 0.7;
		$xstart = 2.5;
		$xstep = 2;
		$xmax = 5;
		$ystart = 2.5;
		$ystep = 2;
		$ymax = 7;
		$image = "";
		for( $i = 0; $i < $xmax; $i++)
		{
			for( $j = 0; $j < $ymax; $j++)
			{
				$image .= '<circle style="' . $colour . $matrix[$value][$j][$i] . ';" cx="' . ( $xstart + $i * $xstep ) . '" cy="'.($ystart+$j*$ystep).'" r="' . $r . '"/>';
			}
		}
		return $image;
	}
}
