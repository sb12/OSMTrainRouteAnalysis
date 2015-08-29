<?php
header("Content-type: image/svg+xml");

include "../../functions/signals/main_light.php";
include "../../functions/signals/main_semaphore.php";
include "../../functions/signals/distant_light.php";
include "../../functions/signals/distant_semaphore.php";
include "../../functions/signals/combined_light.php";

include "../../functions/signals/hv_main.php";
include "../../functions/signals/hv_main_light.php";
include "../../functions/signals/hv_main_semaphore.php";
include "../../functions/signals/hv_distant.php";
include "../../functions/signals/hv_distant_light.php";
include "../../functions/signals/hv_distant_semaphore.php";

include "../../functions/signals/ks_main.php";
include "../../functions/signals/ks_combined.php";
include "../../functions/signals/ks_distant.php";

include "../../functions/signals/hl_main.php";
include "../../functions/signals/hl_combined.php";
include "../../functions/signals/hl_distant.php";

include "../../functions/signals/signal_matrix.php";
include "../../functions/signals/signal_path.php";

include "../../functions/signals/speedlimit_zs3.php";
include "../../functions/signals/speedlimit_zs3_light.php";
include "../../functions/signals/speedlimit_zs3_sign.php";
include "../../functions/signals/speedlimit_zs3v.php";
include "../../functions/signals/speedlimit_zs3v_light.php";
include "../../functions/signals/speedlimit_zs3v_sign.php";

include "../../functions/signals/blockkennzeichen.php";
include "../../functions/signals/ETCS_markerboard.php";


$s = 0;
$height = 0;
if ( isset ( $_GET["railway:signal:speed_limit"] ) )
{
	$valid_signal = false;
	if ( $_GET["railway:signal:speed_limit"] == "DE-ESO:zs3" )
	{
		if ( isset($_GET["railway:signal:speed_limit:form"]) ) 
		{
			if ( $_GET["railway:signal:speed_limit:form"] == "light" )
			{
				$result = Speedlimit_zs3_light::generateImage($height);
				$valid_signal = true;
			}
			elseif ( $_GET["railway:signal:speed_limit:form"] == "sign" )
			{
				$result = Speedlimit_zs3_sign::generateImage($height);
				$valid_signal = true;
			}
		}
	}

	if($valid_signal)
	{
		$signal[$s] = $result[0];
		$height += $result[1];
		$s++;
	}
}
if(isset($_GET["railway:signal:main"]))
{
	$valid_signal = false;
	if($_GET["railway:signal:main"] == "DE-ESO:hp")
	{
		if( isset($_GET["railway:signal:main:form"]) )
		{
			if($_GET["railway:signal:main:form"] == "light")
			{
				$result = HV_main_light::generateImage($height);
				$valid_signal = true;
			}
			elseif($_GET["railway:signal:main:form"] == "semaphore")
			{
				$result = HV_main_semaphore::generateImage($height);
				$valid_signal = true;
			}
		}
	}
	elseif($_GET["railway:signal:main"] == "DE-ESO:ks")
	{
		$result = KS_main::generateImage($height);
		$valid_signal = true;
	}
	elseif($_GET["railway:signal:main"] == "DE-ESO:hl")
	{
		$result = HL_main::generateImage($height);
		$valid_signal = true;
	}
	else //fallback for unknown signals
	{
		if($_GET["railway:signal:main:form"] == "semaphore")
		{
			$result = Main_semaphore::generateImage($height);
			$valid_signal = true;
		}
		else
		{
			$result = Main_light::generateImage($height);
			$valid_signal = true;
		}	
	}

	if($valid_signal)
	{
		$signal[$s] = $result[0];
		$height += $result[1];
		$s++;
	}
}
if(isset($_GET["railway:signal:combined"]))
{
	$valid_signal = false;
	if($_GET["railway:signal:combined"] == "DE-ESO:ks")
	{
		$result = KS_combined::generateImage($height);
		$valid_signal = true;
	}
	elseif($_GET["railway:signal:combined"] == "DE-ESO:hl")
	{
		$result = HL_combined::generateImage($height);
		$valid_signal = true;
	}
	else //fallback for unknown signals
	{
		$result = Combined_light::generateImage($height);
		$valid_signal = true;
	}

	if($valid_signal)
	{
		$signal[$s] = $result[0];
		$height += $result[1];
		$s++;
	}
		
}
if(isset($_GET["railway:signal:distant"]))
{
	$valid_signal = false;
	if($_GET["railway:signal:distant"] == "DE-ESO:vr")
	{
		if( isset($_GET["railway:signal:distant:form"]) )
		{
			if($_GET["railway:signal:distant:form"] == "light")
			{
				$result = HV_distant_light::generateImage($height);
				$valid_signal = true;
			}
			elseif($_GET["railway:signal:distant:form"] == "semaphore")
			{
				$result = HV_distant_semaphore::generateImage($height);
				$valid_signal = true;
			}
		}
	}
	elseif($_GET["railway:signal:distant"] == "DE-ESO:ks")
	{
		$result = KS_distant::generateImage($height);
		$valid_signal = true;
	}
	elseif($_GET["railway:signal:distant"] == "DE-ESO:hl")
	{
		$result = HL_distant::generateImage($height);
		$valid_signal = true;
	}
	else //fallback for unknown signals
	{
		if( isset($_GET["railway:signal:distant:form"]) && $_GET["railway:signal:distant:form"] == "semaphore")
		{
			$result = Distant_semaphore::generateImage($height);
			$valid_signal = true;
		}
		else
		{
			$result = Distant_light::generateImage($height);
			$valid_signal = true;
		}
	}

	if($valid_signal)
	{
		$signal[$s] = $result[0];
		$height += $result[1];
		$s++;
	}
	
}
if( isset($_GET["railway:signal:speed_limit_distant"]) )
{
	$valid_signal = false;
	if( urldecode($_GET["railway:signal:speed_limit_distant"]) == "DE-ESO:zs3v" )
	{
		if( isset($_GET["railway:signal:speed_limit_distant:form"]) )
		{
			if( $_GET["railway:signal:speed_limit_distant:form"] == "light")
			{
				$result = Speedlimit_zs3v_light::generateImage($height);
				$valid_signal = true;
			}
			elseif($_GET["railway:signal:speed_limit_distant:form"] == "sign")
			{
				$result = Speedlimit_zs3v_sign::generateImage($height);
				$valid_signal = true;
			}
		}
	}

	if($valid_signal)
	{
		$signal[$s] = $result[0];
		$height += $result[1];
		$s++;
	}
}
if( isset($_GET["railway:signal:train_protection"]) )
{
	$valid_signal = false;
	if( urldecode($_GET["railway:signal:train_protection"]) == "DE-ESO:blockkennzeichen" )
	{
		$result = Blockkennzeichen::generateImage($height);
		$valid_signal = true;
	}
	elseif( urldecode($_GET["railway:signal:train_protection"]) == "DE-ESO:ne14" )
	{
		$result = ETCS_markerboard::generateImage($height);
		$valid_signal = true;
	}
	
	if($valid_signal)
	{
		$signal[$s] = $result[0];
		$height += $result[1];
		$s++;
	}
}

echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd" [
	<!ENTITY ns_svg "http://www.w3.org/2000/svg">
	<!ENTITY ns_xlink "http://www.w3.org/1999/xlink">	
	<!ENTITY background "fill:#000000;">	
	<!ENTITY white "fill:#FFFFFF;">	
	<!ENTITY gray "fill:#444444;">	
	<!ENTITY red "fill:red;">	
	<!ENTITY yellow "fill:yellow;">	
	<!ENTITY green "fill:#38FFF5;">
		
	<!ENTITY st1 "fill:#FFFFFF;">
	<!ENTITY stv1 "fill:yellow;">
	<!ENTITY st0 "fill:none;stroke:none">
	<!ENTITY stv0 "fill:none;stroke:none">
	<!ENTITY st2 "fill:#444444;">
	<!ENTITY stv2 "fill:#444444;">

]>
<svg  version="1.1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" width="40" height="<?php echo $height;?>" viewBox="0 0 40 <?php echo $height;?>"
	 overflow="visible" enable-background="new 0 0 40 <?php echo $height;?>" xml:space="preserve">
	 
<style>
@keyframes blink {
  0%, 40%   {opacity: 0}
  50%, 90%  {opacity: 1}
}

.signal_blink
{
	-moz-animation: blink 1s linear infinite;
}

</style>

<?php 
foreach( $signal as $output)
{
	echo $output;
}
?>
</svg>
