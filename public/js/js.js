$(document).ready (function()
    {
		$('.amsg').click(function(){
       $('.qery-form').show();
	   $( ".qery-form .form" ).fadeTo( "slow" , 1, function() {});
    });
    $('.open').click(function(){    
       $('.login-page').show();
	   $('.reg-page').hide();
	   $( ".login-page .form" ).fadeTo( "slow" , 1, function() {});
    });
	$('.FormClose').click(function(){    
       $('.login-page').hide();
	   $('.reg-page').hide();
	   $('.qery-form').hide();
    });
	$('.register').click(function(){
	   $('.login-page').hide();
	   $( ".reg-page .form" ).fadeTo( "slow" , 1, function() {});
    });
	
	$('.mainmenu').click(function(){
       $('.whit').show();
	   $('.login-page').hide();
	   $('.reg-page').hide();
	   $('.qery-form').hide();
	   $('.workslide').hide();
	   $( ".left-menu" ).fadeTo( "slow" , 1, function() {});
    });
	$('.MenuClose').click(function(){
       $('.whit').hide();
    });
	
	$('.works').click(function(){ 	
       $('.workslide').show();
	   $('.login-page').hide();
	   $('.reg-page').hide();
	   $('.qery-form').hide();
	   $('.whit').hide();
    });
	$('.SliderClose').click(function(){ 
       $('.workslide').hide();
	   
    });

});	



