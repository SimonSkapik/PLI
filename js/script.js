/**********************
*
*    Web Crawler Script
*
**********************/

function Load_content(url){
	$.ajax({
		url: url,
		type: 'GET',
		success: function(res) {
			Parse_content(res.responseText);
		}
	});
}

function Parse_content(data){
	console.log(data);
}