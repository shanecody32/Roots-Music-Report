/* 
 * Author: Shane Cody
 * Company: Crooked Comma Designs - crookedcomma.com
 */

$(document).ready(function(){
    var id = $("input[id^=RadioStationType]:checked").attr('id');
    if(id != 'RadioStationTypeInternet'){
	   $('div.internet').toggle('fast','linear');
    }
    if(id != 'RadioStationTypeSyndicated'){
	   $('div.syndicated').toggle('fast','linear');
    }
    if(id != 'RadioStationTypeTerrestrial'){
	   $('div.terrestrial').toggle('fast','linear');
    }
    if(id != 'RadioStationTypeSatellite'){
	   $('div.satellite').toggle('fast','linear');
    }
});

$(document).ready(function(){
    $('input[id^=RadioStationType]').click(function() {
	   div = $(this).attr('id');
	   div = div.substring(16).toLowerCase();
	   $('.toggle').hide('slow','linear');
	   $('.'+div).toggle('slow','linear');
	   
    });
});

$(document).ready(function(){
		$country = $("select[id$='CountryId']");
		$state = $('input[name*="state"]');
		if($country.val() != '225' && $country.val() != '39'){
			$state.parent().removeClass('required');
		} else {
			$state.parent().addClass('required');
		}
		$country.change(function(){
			if($country.val() != '225' && $country.val() != '39'){
				$state.parent().removeClass('required');
			} else {
				$state.parent().addClass('required');
			}
		});
});

$(document).ready(function(){
	var $radio_same = $('input[id$="SameAsRadio"]');
	$radio_same.click(function(){
		$('#contact').slideToggle('slow');
	});	
	if($radio_same.attr('checked') == true){
		$('#contact').slideUp('fast');
	}
});

$(document).ready(function(){
	$( "#ReviewCreated" ).datepicker();
});
