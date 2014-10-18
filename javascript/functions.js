
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

/** functions for about box **/

/**
 * deselect link
 * @param e element
 */
function deselect(e) 
{
	e.removeClass('selected');
  	$('.about').slideFadeToggle();
}

/**
 * initialize onclick function for button
 */
$(function() 
{
	$('#about_link').on('click', function() 
	{
		if($(this).hasClass('selected')) 
		{
			deselect($(this));               
		} 
		else 
		{
			$(this).addClass('selected');
			$('.about').slideFadeToggle();
		}
		return false;
	});

	$('.close').on('click', function() 
	{
		deselect($('#about_link'));
		return false;
	});
});

/*
 * animation for window and background
 */
$.fn.slideFadeToggle = function(easing, callback) 
{
	if($('#about_link').hasClass('selected'))
	{
		var opacity = 0.2;
	}
	else
	{
		var opacity = 1.0;
	}
	$('#header').animate({ opacity: opacity}, 'fast', easing, callback);
	$('#main').animate({ opacity: opacity}, 'fast', easing, callback);
	$('#footer').animate({ opacity: opacity}, 'fast', easing, callback);
  	return this.animate({ opacity: 'toggle', height: 'toggle' }, 'fast', easing, callback);
};

/**
 * hide element and add class when loading page.
 */
$( document ).ready(function() 
{
	$('.about').hide();
	$('.about').addClass('about_box');
});