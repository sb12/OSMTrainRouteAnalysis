<?php 
    /**
    
    OSMTrainRouteAnalysis Copyright © 2014 sb12 osm.mapper999@gmail.com
    
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
use Sepia\PoParser;
/**
 * Class for localization
 * 
 * @author steffen
 *
 */
Class Lang
{
	/**
	 * @var Array array for localizations
	 */
	protected static $lang_output;
	
	/**
	 * function define language and parse PO file
	 * 
	 * @param String $lang language code
	 */
	public static function defineLanguage($lang="")
	{		
		//get language from browser if not set
		if ( !$lang )
		{
			$lang = Lang::getLanguage();
		}
		
		$poparser = new PoParser();

		// path to lang file
		$filePath["en"] = PATH . "lang/en.po";
		$filePath["de"] = PATH . "lang/de.po";
		
		// set default language if language is not available
		if ( !isset($filePath[$lang]) )
		{
			$lang = "en";
		}
		
		// returns array
		$po_output = $poparser->parse($filePath[$lang]);
		
		// convert array to $l_ array
		foreach ( $po_output as $po_o )
		{
			if ( isset($po_o["msgid"]) && isset($po_o["msgstr"]) )
			{
				Lang::$lang_output[$po_o["msgid"][0]] = "";
				foreach ( $po_o["msgstr"] as $msg_str )
				{
					Lang::$lang_output[$po_o["msgid"][0]] .= $msg_str;
				}
			}
		}
	}
	
	/**
	 * get Language String
	 * 
	 * @param String $msgid 
	 * @return String language string
	 */
	public static function l_($msgid)
	{
		if ( isset(Lang::$lang_output[$msgid]) )
		{
			return Lang::$lang_output[$msgid];
		}
		else
		{
			return $msgid;
		}
	}
	
	/**
	 * get default browser language
	 * 
	 * @return String language
	 */
	private static function getLanguage()
	{
		/* code adapted from http://www.paulund.co.uk/auto-detect-browser-language-in-php */
		$supportedLangs = array("en", "de");
		
		$languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

		foreach ( $languages as $lang )
		{
			foreach ( $supportedLangs as $slang )
			{
				if ( strstr($lang, $slang) )
				{
					// Set the page locale to the first supported language found
					return $slang;
				}
			}
		}
		//language not supported -> set to default english language
		return "en";
	}
}
?>