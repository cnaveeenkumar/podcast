/*jQuery(document).ready(function(){
	alert("ok");
});
(function( $ ) {
	alert("ok1");
})(jQuery);*/

function podcastajaxPagination(pnumber,plimit){
	var nth  = pnumber;
	var lmt  = plimit;
	var ajax_url = ajax_params.ajax_url;
	var podcasttype = jQuery("#post").attr('data-posttype');
	var pthumb = jQuery("#post").attr('data-thumb');
	//alert(ajax_url);
	jQuery.ajax({
		url		:ajax_url,
		type	:'POST',
		data	:{ 'action':'podcastpaginationCallback','number':nth,'limit':lmt,'podcastpost':podcasttype, 'pthumb':pthumb },
		/*beforeSend	: function(){
			jQuery(".all-podcast-girds").html("<p style='text-align:center;'>Loading please wait...!</p>");
		},*/
		success :function(pvalue){
			//alert(pvalue);
			jQuery(".all-podcast-girds").html(pvalue);
		}
	});
}