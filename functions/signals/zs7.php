<?php

// generate a Zs7 signal

Class Zs7
{

  public static function generateImage(int $center_x, int $center_y, $color = "")
  {
    $size = 4;
    $radius_lamp = 2.25;
    $upper_left_x = $center_x - $size;
    $upper_left_y = $center_y - $size;
    $upper_right_x = $center_x + $size;
    $upper_right_y = $center_y - $size;
    $lower_center_x = $center_x;
    $lower_center_y = $center_y + $size;
    
    if( !isset($color) )
    {
      $color = "&gray;";
    }
  
    $code = '<g id="zs7">
						<circle style="' . $color . '" cx="' . $upper_left_x . '" cy="' . $upper_left_y . '" r="' . $radius_lamp . '"/>
						<circle style="' . $color . '" cx="' . $upper_right_x . '" cy="' . $upper_right_y . '" r="' . $radius_lamp . '"/>
						<circle style="' . $color . '" cx="' . $lower_center_x . '" cy="' . $lower_center_y . '" r="' . $radius_lamp . '"/>
					</g>';
  
    return $code;
  }

}

?>
