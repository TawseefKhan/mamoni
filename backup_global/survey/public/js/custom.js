$(document).ready(function() {
	//make all dialog class dialog
    $( ".dialog" ).dialog({
		autoOpen: false,
		width: ($( document ).width()>767?500:$( document ).width()-50)
	});

    $( ".open-dialog" ).click(function(e) {
    	e.preventDefault();

		$(".dialog").dialog("close");
		$(".edit-form .item").css("display", "none");
		$("#" + $(this).attr("href") ).dialog("open");

		var idName="#" + $(this).attr("href");
		var source = $(this).closest("tr").find("[label-name]");
		var destination = $( "#" + $(this).attr("href") ).find("[label-name]");

		for (var i = 0; i <source.length ; i++) {
			if($(destination[i]).is("input")  ||  $(destination[i]).is("textarea")){
				$(destination[i]).val($(source[i]).text());
			}
			else if($(destination[i]).is("select"))
			{
				if($(destination[i]).hasClass("input-tags"))
				{
					var sel = $(destination[i])[0].selectize;
					sel.addItem($(source[i]).text(), false);
				}
				else
					$(destination[i]).find("option[value='"+$(source[i]).text()+"']").prop('selected', 'selected').change();

			}
		};
	});

	 $( ".close-dialog" ).click(function(e) {
		$(".dialog").dialog("close");
	  	e.preventDefault();
	});
	


	$(".input-tags").each(function( ) {
	  $(this).selectize({
			create: true,
			sortField: 'text'
		});

	});

	$(".column_value_names option").css("display", "none");
	$(".column_value_names option[data-rel='"+$(".column_names").val()+"']").css("display", "block");
	$( ".column_names" ).change(function() {
	  	$(".column_value_names option").css("display", "none");
		$(".column_value_names option[data-rel='"+$(this).val()+"']").css("display", "block");
	});
	

    
});