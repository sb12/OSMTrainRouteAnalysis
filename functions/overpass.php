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
 * Class for Requests to the Overpass API
 * 
 * This class has all functions and variables that are needed for getting data from the overpass api
 * 
 * @author steffen
 *
 */
Class Overpass 
{
	
	/**
	 * Variable to save error message
	 * @var String
	 */
	public static $error;
	
	/**
	 * Variable to save result of query
	 * @var String
	 */
	public static $result;
	
	/**
	 * function to send request
	 * @param String $query query for overpass api
	 * @return boolean true when request successful
	 */
	static function sendRequest($query)
	{
		$link = "http://overpass-api.de/api/interpreter?data=" . urlencode($query);
    		
		// get data from overpass api
		$content = @file_get_contents($link);
		
		// explanation about status codes of the overpass api can be found here: http://overpass-api.de/command_line.html
		if( isset($http_response_header[0]) )
		{
			$status_code = self::getStatusCode($http_response_header[0]);
			if( $status_code != 200 ) // 200 OK -> everything is ok
			{
				if( $status_code == 400 ) // 400 Bad Request -> syntax error
				{
					self::$error = Lang::l_("Invalid Overpass API query.");
					//log error to send a correct query next time:
					$msg = "Invalid Overpass API request. Query: " . $query;
					log_error($msg);
				}
				elseif( $status_code == 429 ) // 429 Too Many Requests -> too many requests from same ip
				{
					self::$error = Lang::l_("Too many requests to Overpass API at the same time.");
				}
				elseif( $status_code == 504 ) // 504 Gateway Timeout -> too much load on server
				{
					self::$error = Lang::l_("Overpass API currently overcrowded.");
				}
				else
				{
					self::$error = Lang::l_("Unknown Error.");
					//log error to show a proper error message next time:
					$msg = "Unknown Error when requesting overpass api: " . $http_response_header[0] . " | URI: " . $link;
					log_error($msg);
				}
				return false;
			}
		}
		else
		{
			self::$error = Lang::l_("Connection failed.");
			return false;
		}
		
		if( !$content )
		{
			self::$error = Lang::l_("Empty result.");
			return false;
		}
		
		self::$result = $content;
		return true;
	}


	/**
	 * extracts the status code from the http_response_header
	 * @param String $http_response_code
	 * @return int status code
	 */
	static function getStatusCode($http_response_code)
	{
		$matches = array();
		preg_match('#HTTP/\d+\.\d+ (\d+)#', $http_response_code, $matches);
		return $matches[1];
	}
}
