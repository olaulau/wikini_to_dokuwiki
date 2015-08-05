$(function(){

	// auto submit changes to the select (go to page on click)
	$("select").change(function(){
		$("form").submit();
	});

});
