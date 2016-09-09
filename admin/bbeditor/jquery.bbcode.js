/*
 * Plugin jQuery.BBCode
 * Version 0.2 
 *
 * Based on jQuery.BBCode plugin (http://www.kamaikinproject.ru)
 */
(function($){
  $.fn.bbcode = function(options){
		// default settings
    var options = $.extend({
      tag_bold: true,
      tag_italic: true,
      tag_underline: true,
      tag_link: false,
      tag_image: true,
      button_image: true,
      image_url: 'bbeditor/bbimage/'
    },options||{});
    //  panel 
    var text = '<div id="bbcode_bb_bar">'
    if(options.tag_bold) { text = text + '<a href="#" id="b" title=""> <img src="' + options.image_url + 'bold.png" /> </a>'; }
    if(options.tag_italic) { text = text + '<a href="#" id="i" title=""> <img src="' + options.image_url + 'italic.png" /> </a>'; }
    if(options.tag_underline) { text = text + '<a href="#" id="u" title=""> <img src="' + options.image_url + 'underline.png" /> </a>'; }
    if(options.tag_link) { text = text + '<a href="#" id="a" title=""> <img src="' + options.image_url + 'link.png" border="0" /> </a>'; }
    if(options.tag_image) { text = text + '<a href="#" id="img" title=""> <img src="' + options.image_url + 'image.png" border="0" /> </a>'; }
	text = text + '<a href="#" id="ip" title=""> Žaidėjo IP </a> | ';
	text = text + '<a href="#" id="nr" title=""> Trumpasis </a> | ';
	text = text + '<a href="#" id="price" title=""> Kaina </a> | ';
	text = text + '<a href="#" id="price_type" title=""> Kainos tipas </a> | ';
	text = text + '<a href="#" id="time" title=""> Trukme </a> | ';
	text = text + '<a href="#" id="key" title=""> Raktažodis </a>';
	
    text = text + '</div>';
    
    $(this).wrap('<div id="bbcode_container"></div>');
    $("#bbcode_container").prepend(text);
    $("#bbcode_bb_bar a img").css("border", "none");
    var id = '#' + $(this).attr("id");
    var e = $(id).get(0);
    
	$('#bbcode_bb_bar a').click(function() {
		var button_id = $(this).attr("id");
		var start = '<'+button_id+'>';
		var end = '</'+button_id+'>';

		var param="";
		
		switch(button_id)
		{
			case 'img':
			{
				param=prompt("Iveskite paveiksliuko URL adresa","http://");
				if (param)
				start = '<img src=' + param + '>';
				break;
			}
			case 'a':
			{
				param=prompt("Iveskite URL adresa","http://");
				if (param) 
				start = '<a href=' + param + '>';
				break;
			}
			case 'ip':
			{
				start = '%' + button_id + '';
				end = '%';
				break;
			}
			case 'nr':
			{
				start = '%' + button_id + '';
				end = '%';
				break;
			}
			case 'price':
			{
				start = '%' + button_id + '';
				end = '%';
				break;
			}
			case 'price_type':
			{
				start = '%' + button_id + '';
				end = '%';
				break;
			}
			case 'time':
			{
				start = '%' + button_id + '';
				end = '%';
				break;
			}
			case 'key':
			{
				start = '%' + button_id + '';
				end = '%';
				break;
			}
		}
		insert(start, end, e);
		return false;
	});
	}
	
  function insert(start, end, element) {
    if (document.selection) {
       element.focus();
       sel = document.selection.createRange();
       sel.text = start + sel.text + end;
    } else if (element.selectionStart || element.selectionStart == '0') {
       element.focus();
       var startPos = element.selectionStart;
       var endPos = element.selectionEnd;
       element.value = element.value.substring(0, startPos) + start + element.value.substring(startPos, endPos) + end + element.value.substring(endPos, element.value.length);
    } else {
      element.value += start + end;
    }
  }
 
// hotkeys 
$(document).keyup(function (e) 
{ if(e.which == 17) isCtrl=false; }).keydown(function (e) 
{ if(e.which == 17) isCtrl=true; 
if (e.which == 66 && isCtrl == true) // CTRL + B, bold
{ 
	$("#b").click();
	return false;
} 
else if (e.which == 73 && isCtrl == true) // CTRL + I, italic
{ 
	$("#i").click();
	return false;
} 
else if (e.which == 85 && isCtrl == true) // CTRL + U, underline
{ 
	$("#u").click();
	return false;
}
})
  
})(jQuery)