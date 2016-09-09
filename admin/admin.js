$(document).ready(function() {
			window.onload = (function(){
				$("#comments-box1").load('ajax/flags_list.php');
				$("#comments-box2").load('ajax/sms_list.php');
				$("#comments-box3").load('ajax/types_list.php');
				$("#comments-box4").load('ajax/servers_list.php');
				$("#comments-box5").load('ajax/links_list.php');
				$("#comments-box6").load('ajax/priv_list.php');
				$("#comments-box7").load('ajax/makro_list.php');
				
				if($("select[name='sistema']").val() == '0')
				{
					$("#mokejimailt").css("display", "block");
					$("#vpsnet").css("display", "none");
				}
				else if($("select[name='sistema']").val() == '1')
				{
					$("#mokejimailt").css("display", "none");
					$("#vpsnet").css("display", "block");
				}
				
				if($("select[name='message_type']").val() == 'unban')
				{
					$("#unban_no1").css("display", "none");
					$("#unban_no2").css("display", "none");
				}
				else if($("select[name='message_type']").val() != 'unban')
				{
					$("#unban_no1").css("display", "inline");
					$("#unban_no2").css("display", "inline");
				}
			});
			
			$("#add").click(function(){
				setTimeout(function(){
					$("#comments-box1").load('ajax/flags_list.php');
					$("#comments-box2").load('ajax/sms_list.php');
					$("#comments-box3").load('ajax/types_list.php');
					$("#comments-box4").load('ajax/servers_list.php');
					$("#comments-box5").load('ajax/links_list.php');
					$("#comments-box6").load('ajax/priv_list.php');
					$("#comments-box7").load('ajax/makro_list.php');
				}, 100);		
			});
		  
			$('#form1').ajaxForm({ 
				target: '#target1', 
				success: function() { 
					$('#target1').fadeIn('slow'); 
				} 
			});
			
			$('#form2').ajaxForm({ 
				target: '#target2', 
				success: function() { 
					$('#target2').fadeIn('slow'); 
				} 
			});
			
			$('#form3').ajaxForm({ 
				target: '#target3', 
				success: function() { 
					$('#target3').fadeIn('slow'); 
				} 
			});
			
			$('#form4').ajaxForm({ 
				target: '#target4', 
				success: function() { 
					$('#target4').fadeIn('slow').delay(1000).fadeOut('slow'); 
				} 
			});
			
			$('select[name=sistema]').change(function ()
			{
				if($("select[name='sistema']").val() == '0')
				{
					$("#mokejimailt").css("display", "block");
					$("#vpsnet").css("display", "none");
				}
				else if($("select[name='sistema']").val() == '1')
				{
					$("#mokejimailt").css("display", "none");
					$("#vpsnet").css("display", "block");
				}
			});
			
			$('select[name=message_type]').change(function ()
			{
				if($("select[name='message_type']").val() == 'unban')
				{
					$("#unban_no1").css("display", "none");
					$("#unban_no2").css("display", "none");
				}
				else if($("select[name='message_type']").val() != 'unban')
				{
					$("#unban_no1").css("display", "inline");
					$("#unban_no2").css("display", "inline");
				}
			});
			
		});