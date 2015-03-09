
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
 * initialize functions
 */
$(function() 
{
	// search functions
	$( '#searchform' ).on('submit', function( event ) 
	{
		event.preventDefault();
		$( '#search' ).modal();
		$( '#searchcontent' ).html("<span class=\"list-group-item\">Daten werden geladen...</span>");//FIXME: German
		$.get('ajax/search.php?' + $( this ).serialize(), function(data){
			$( '#searchcontent' ).html(data);
			$(window).trigger('resize');
		});
	});

	// josm links
	$( '#josmLink' ).on('click', function( event ) 
	{
		event.preventDefault();
		var jqxhr = $.get($( '#josmLink' ).attr('href'))
		.fail(function()
		{
			$( '#josmErrorDialog' ).modal(show=true);
		})
	});
	

	// changelog
	$( '#changelog' ).on('shown.bs.collapse', function () {
		$(window).trigger('resize');
	});	
	$( '#changelog' ).on('hidden.bs.collapse', function () {
		$(window).trigger('resize');
	});
	
	//default train
	if ( $( '#train_default' ))
	{
		var chosenTrain = $( '#train option:selected' ).val();
		$( '#train_default' ).change(function() 
		{
			if ( $( '#train_default:checked' ).length > 0 )
			{
				$( '#train_icon' ).removeClass( 'glyphicon-star-empty' );
				$( '#train_icon' ).addClass( 'glyphicon-hourglass' );

				$( '#train_default_group > div' ).addClass( 'disabled' );
				$( '#train_default' ).prop( 'disabled', true);
				
				$( '#train_default_text' ).text( $( '#text_default_loading' ).text() ); 
	
				$.get('ajax/defaultTrain.php?' + $( '#train_form' ).serialize(), function(data){
					if(data == "true")
					{
						$( '#train_icon' ).removeClass( 'glyphicon-hourglass' );
						$( '#train_icon' ).addClass( 'glyphicon-star' );

						$( '#train_default_group > div' ).removeClass( 'btn-default' );
						$( '#train_default_group > div' ).addClass( 'btn-info disabled' );
						$( '#train_default' ).prop( 'disabled', true);
					
						$( '#train_default_text' ).text($( '#text_default_train' ).text());
						
						//reload page with new train when train not already loaded
						if(chosenTrain != $( '#train option:selected' ).val())
						{
							window.location.href =window.location.pathname + '?' + $( '#train_form' ).serialize();
						}
						else
						{
							$( '#train > optgroup > option' ).removeClass('bg-info');
							$( '#train option:selected' ).addClass('bg-info');
						}
					}
					else
					{
						$( '#train_icon' ).removeClass( 'glyphicon-hourglass' );
						$( '#train_icon' ).addClass( 'glyphicon-exclamation-sign' );

						$( '#train_default' ).prop( 'disabled', true);
					
						$( '#train_default_text' ).text( $( '#text_default_error' ).text() );
					}
				});

				
			}		
			else
			{
				$( '#train_icon' ).removeClass( 'glyphicon-hourglass glyphicon-exclamation-sign' );
				$( '#train_icon' ).addClass( 'glyphicon-star-empty' );
				
				$( '#train_default_group > div' ).removeClass( 'btn-info disabled' );
				$( '#train_default_group > div' ).addClass( 'btn-default' );
				$( '#train_default' ).prop( 'disabled', false);
				if(chosenTrain == $( '#train option:selected' ).val())
				{
					$( '#train_submit' ).prop( 'disabled', true);
					var text = $( '#text_not_default_train1' ).text() + $( '#train option:selected' ).text() + $( '#text_not_default_train2' ).text();
				}
				else
				{
					$( '#train_submit' ).prop( 'disabled', false);
					var text = $( '#text_not_default_change_train1' ).text() + $( '#train option:selected' ).text() + $( '#text_not_default_train2' ).text();
				}

				$( '#train_default_text' ).text( text );
			}
		});

		$( '#train' ).change(function() 
		{
			if ( $( '#train option:selected' ).hasClass('bg-info') )
			{
				$( '#train_icon' ).removeClass( 'glyphicon-star-empty' );
				$( '#train_icon' ).addClass( 'glyphicon-star' );

				$( '#train_default_group > div' ).removeClass( 'btn-default' );
				$( '#train_default_group > div' ).addClass( 'btn-info disabled' );
				$( '#train_default' ).prop( 'checked', true);
				$( '#train_default' ).prop( 'disabled', true);
				if(chosenTrain == $( '#train option:selected' ).val())
				{
					$( '#train_submit' ).prop( 'disabled', true);
				}
				else
				{
					$( '#train_submit' ).prop( 'disabled', false);
				}
			
				$( '#train_default_text' ).text($( '#text_default_train' ).text());
			}
			else
			{
				$( '#train_default' ).prop( 'checked', false);
				$( '#train_default' ).trigger( 'change' );
			}
		});
		
	}
});