// WEB ESSENTIALS LIBRARY 1.0 //
// DEVELOPED BY ABHISHEK CHALLA //

var windowWidth,windowHeight;
if(typeof $ != 'undefined'){

	windowWidth=$(window).width();
	windowHeight=$(window).height();

	window.settle=function(list){
		
	};

}
else{
	console.error("JQuery has not been sourced!");
}