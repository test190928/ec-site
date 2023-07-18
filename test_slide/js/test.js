
jQuery(function($){
    $('.slider').each(function(){
		$(this).slick({
			accessibility:true,
			slidesToShow:5
		});
	});
});