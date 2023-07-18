
jQuery(function($){

    $('.slider').each(function(){
		$(this).slick({
			accessibility:true,
			slidesToShow:5
		});
	});

	$(".header-slider").each(function(){
		$(this).slick({
			accessibility:true,
			autoplay:true,
		    autoplaySpeed:5000,
		    dots:true,
		});
	});
});