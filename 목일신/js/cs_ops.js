function toggleSplitBar(){
	jQuery(".snb_area").toggle();
	if(jQuery(".snb_area").css("display")=="block"){
		jQuery(".slide_bar").removeClass("closed")
		jQuery(".slide_bar").removeClass("slide_bar_out");
		jQuery(".topall").removeClass("bg_none");
		jQuery("#content_all_full").attr("id", "content_all");
	}else{
		jQuery(".slide_bar").addClass("closed");
		jQuery(".slide_bar").addClass("slide_bar_out");
		jQuery(".topall").addClass("bg_none");
		jQuery("#content_all").attr("id", "content_all_full");
	}
}