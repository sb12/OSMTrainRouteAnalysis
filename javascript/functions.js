
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

/**
 * initialize search function
 */
$(function() 
{
	$( '#searchform' ).on('submit', function( event ) 
	{
		event.preventDefault();
		$('#search').modal();
		$('#searchcontent').html("<span class=\"list-group-item\">Daten werden geladen...</span>");//FIXME: German
		$.get('ajax/search.php?' + $( this ).serialize(), function(data){
			$('#searchcontent').html(data);
			$(window).trigger('resize');
		});
	});
	
	$( '#josmLink' ).on('click', function( event ) 
	{
		event.preventDefault();
		var jqxhr = $.get($('#josmLink').attr('href'))
		.fail(function()
		{
			$('#josmErrorDialog').modal(show=true);
		})
	});
});