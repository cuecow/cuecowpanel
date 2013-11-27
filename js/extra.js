function FindRelatedUrl(url,from)
{
	var site_url = $('#site_url').val();

	if($('#locid').val()!='')
		var id = $('#locid').val();
	else
		var id = 0;
		
	$.post(site_url+'/index.php/location/searchurl', {'url':url, 'from':from, 'id':id}, function(data){
		$('#'+from+'urlinfo').show();
		$('#'+from+'urlinfo').html(data);
	});
}

function EditSpecContent(content_id, row, lang)
{
	var website_url = $('#website_url').val();
	
	$.post(website_url+'/index.php/content/editcontent', {'website_url':website_url, 'content_id':content_id, 'row':row, 'lang':lang}, function(data)
	{
		$('#contenttext_'+row).html(data);
	});
}

function SaveText(txt, content_id, row, lang)
{
	var website_url = $('#website_url').val();

	$.post(website_url+'/index.php/content/savecontents', {'content_id':content_id, 'row':row, 'txt':txt, 'lang':lang}, function(data)
	{
		$('#contenttext_'+row).html(data);
	});
}
