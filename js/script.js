/**********************
*
*    Web Crawler Script
*
**********************/

var links = [];
var alphabet = [];
var base = ""
var page_ind = 0;
var page_max = 0;
var link_ind = 0;
var link_max = 0;
var XML_data

function Load_EVERY_FUCKIN_THING(b, start, stop){
	//$('#result').html('&lt;?xml version="1.0" encoding="UTF-8"?&gt;<br>&lt;articles&gt;<br>');
	$('#result').html('');
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
				if(page_ind <= page_max){
					setTimeout(function(){
						page_ind++;
						Load_links(base+page_ind);					
					},200);
				}else{
					setTimeout(function(){
						//$('#result').append('&lt;&#x2F;articles&gt;');
						//alphabet.sort();
						//$('#alpha').append(alphabet.join('<br>'));
						alert('Done!');
					},15000);
				}
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
	data = "\n"+'&lt;article&gt;'+"\n";
	data += '&nbsp;&nbsp;&lt;date&gt;' + $(datum).attr('content') + '&lt;&#x2F;date&gt;'+"\n";
	data += '&nbsp;&nbsp;&lt;authors&gt;'+"\n";
	$.each(author, function(a,b){
		data += '&nbsp;&nbsp;&nbsp;&nbsp;&lt;author&gt;'+$(b).text()+'&lt;&#x2F;author&gt;'+"\n";
	});
	data += '&nbsp;&nbsp;&lt;&#x2F;authors&gt;'+"\n";
	data += '&nbsp;&nbsp;&lt;title&gt;'+clean_up($(title).text())+'&lt;&#x2F;title&gt;'+"\n";
	data += '&nbsp;&nbsp;&lt;text&gt;'+"\n";
	$.each(text, function(a,b){
		clean_text = clean_up($(b).text());
		data += '&nbsp;&nbsp;&nbsp;&nbsp;&lt;paragraph&gt;'+clean_text+'&lt;&#x2F;paragraph&gt;'+"\n";
		$('#result_text').append(" "+clean_text);
		for (var x = 0; x < clean_text.length; x++){
			var c = clean_text.charAt(x);			
			if(jQuery.inArray(c,alphabet) == (-1)){
				alphabet.push(c);
			}
		}
	})
	data += '&nbsp;&nbsp;&lt;&#x2F;text&gt;'+"\n";
	data += "&lt;&#x2F;article&gt;"+"\n\n";
	add_article(data);
}

function add_article(data){
	$('#result').append(data);
}

function clean_up(dirty_text){
	return dirty_text.toLowerCase().replace(/á/g,'a').replace(/č/g,'c').replace(/ď/g,'d').replace(/é/g,'e').replace(/ě/g,'e').replace(/í/g,'i').replace(/ň/g,'n').replace(/ó/g,'o').replace(/ř/g,'r').replace(/š/g,'s').replace(/ť/g,'t').replace(/ú/g,'u').replace(/ů/g,'u').replace(/ý/g,'y').replace(/ž/g,'z').replace(/ś/g,'s').replace(/ć/g,'c').replace(/ĺ/g,'l').replace(/ń/g,'n').replace(/ŕ/g,'r').replace(/ź/g,'z').replace(/ä/g,'a').replace(/ë/g,'e').replace(/ï/g,'i').replace(/ö/g,'o').replace(/ü/g,'u').replace(/ÿ/g,'y').replace(/[^a-z ]/g,' ');   // .replace(/[„“",\.\[\]0-9,\?\!\;\:_'\\\/°@#%\+\|\*\:\(\)\[\]\{\}]*/g,'');
}