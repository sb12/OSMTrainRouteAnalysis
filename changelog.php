<?php echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';?> 
<rss version="2.0">
<channel>  

    <title>OSMTrainRouteAnalysis</title>  

    <link>http://osmtrainroutes.bplaced.net/</link>  

    <description> 
    Changelog of OSMTrainRouteAnalysis
    </description>
<?php
include "functions/start.php";
$changelog = parseChangelog();

foreach($changelog as $changelogi)
{
	?>
    <item>
      <title><?php echo $changelogi["heading"];?></title>
      <link>http://osmtrainroutes.bplaced.net/#about</link>
      <description>
      <![CDATA[
            <ul>
		<?php 
		foreach($changelogi["content"] as $changelogcontent)
		{
			?>
				<li><?php echo $changelogcontent;?></li>
			<?php 
		}
		?>
            </ul>
      ]]>
      </description>
    </item>
		<?php
		$i++;
	}
?>
            
</channel>
</rss>