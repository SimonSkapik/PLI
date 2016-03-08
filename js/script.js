/**********************
*
*    Web Crawler Script
*
**********************/

var links = [];
var base = ""
var page_ind = 0;
var page_max = 0;
var link_ind = 0;
var link_max = 0;
var XML_data

function Load_EVERY_FUCKIN_THING(b, start, stop){
	$('#result').html('&lt;?xml version="1.0" encoding="UTF-8"?&gt;<br>&lt;articles&gt;<br>');
	base = b;
	page_ind = start;
	page_max = stop;
	Load_page();
}

function Load_page(){
	Load_links(base+page_ind);
}

function Load_links(url){
	$.ajax({
		url: url,
		type: 'GET',
		success: function(res) {
			Parse_links($(res.responseText).find('div#content div.col-a div.art a:contains("celý článek")', 'div#content div.col-a div.art:not(:has(img))'));
		}
	});
}

function Parse_links(data){
	links = [];
	$.each(data, function(a,b){
		links.push($(b).attr('href'));
	})
	link_ind = 0;
	link_max = links.length;
	for(j = 0; j < links.length; j++){
		setTimeout(function(){
			Load_content(links[link_ind]);
			link_ind++;
			if(link_ind == link_max){
				setTimeout(function(){
					page_ind++;
					if(page_ind <= page_max){
						Load_links(base+page_ind);
					}else{
						$('#result').append('&lt;&#x2F;articles&gt;');
					}
				},200);
			}
		}, (j+1)*150);
	}
}

function Load_content(link){
	//Parse_content("", "", "<div>"+link+"</div>", "");
	$.ajax({
		url: link,
		type: 'GET',
		success: function(res) {
			Parse_content(
				$(res.responseText).find('span.time span.time-date'),
				$(res.responseText).find('div#content div.authors span[itemprop="author"] span[itemprop="name"]'),
				$(res.responseText).find('div#content h1[itemprop="name headline"]'),
				$(res.responseText).find('div#content div[itemprop="articleBody"] div.bbtext p')
			);
		}
	});
}

function Parse_content(datum, author, title, text){
	data = "<br>"+'&lt;article&gt;'+"<br>";
	data += '&nbsp;&nbsp;&lt;date&gt;' + $(datum).attr('content') + '&lt;&#x2F;date&gt;'+"<br>";
	data += '&nbsp;&nbsp;&lt;authors&gt;'+"<br>";
	$.each(author, function(a,b){
		data += '&nbsp;&nbsp;&nbsp;&nbsp;&lt;author&gt;'+$(b).text()+'&lt;&#x2F;author&gt;'+"<br>";
	});
	data += '&nbsp;&nbsp;&lt;&#x2F;authors&gt;'+"<br>";
	data += '&nbsp;&nbsp;&lt;title&gt;'+$(title).text()+'&lt;&#x2F;title&gt;'+"<br>";
	data += '&nbsp;&nbsp;&lt;text&gt;'+"<br>";
	$.each(text, function(a,b){
		data += '&nbsp;&nbsp;&nbsp;&nbsp;&lt;paragraph&gt;'+$(b).text()+'&lt;&#x2F;paragraph&gt;'+"<br>";
	})
	data += '&nbsp;&nbsp;&lt;&#x2F;text&gt;'+"<br>";
	data += "&lt;&#x2F;article&gt;"+"<br><br>";
	add_article(data);
}

function add_article(data){
	$('#result').append(data);
}