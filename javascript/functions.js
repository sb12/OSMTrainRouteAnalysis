
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
 * define elements that can be shown in box
 */

var set = new Array();
var element = new Array();
var button = new Array();

element[0]=$('.about');
element[1]=$('#search');

set[0]=false;
set[1]=false;


/**
 * deselect link
 * @param e element
 */ 

function deselect(e) 
{
	e.fadeOut();
	fadeInBackground();
}

/**
 * select link
 * @param e element
 */ 

function select(e) 
{
	$('#search').fadeOut();
	$('.about').fadeOut();
	set[$('#search')]=false;
	set[$('.about')]=false;
	e.fadeIn();
	fadeOutBackground();
}

function close()
{
	$('#search').fadeOut();
	$('.about').fadeOut();
	set[0]=false;
	set[1]=false;
	fadeInBackground();
}
/**
 * initialize onclick function for button
 */
$(function() 
{
	$('#about_link').on('click', function() 
	{
		if(set[0])
		{
			deselect($('.about'));      
			set[0]=false;
		} 
		else 
		{
			select($('.about'));        
			set[0]=true;
		}
		return false;
	});

	$('.close').on('click', function() 
	{
		close();
		return false;
	});

	$( '#searchform' ).on('submit', function( event ) 
	{
		event.preventDefault();
		if(!set[1])
		{
			select($('#search'));      
			set[1]=true;
		}
		$('#searchcontent').text("Daten werden geladen...");
		$.get('ajax/search.php?' + $( this ).serialize(), function(data){
			$('#searchcontent').html(data);
			
			});

		});
});

/*
 * animation for background
 */
function fadeOutBackground() 
{
	var opacity = 0.2;
	$('#header').animate({ opacity: opacity}, 'fast');
	$('#main').animate({ opacity: opacity}, 'fast');
	$('#footer').animate({ opacity: opacity}, 'fast');
}
function fadeInBackground() 
{
	var opacity = 1;
	$('#header').animate({ opacity: opacity}, 'fast');
	$('#main').animate({ opacity: opacity}, 'fast');
	$('#footer').animate({ opacity: opacity}, 'fast');
}


/**
 * hide element and add class when loading page.
 */
$( document ).ready(function() 
{
	$('.about').hide();
	$('.about').addClass('about_box');
	
	$('#search').hide();
});