<?php
/*
Plugin Name: Facebook Lightbox Comments
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Show the facebook comments in a lightbox without leaving the actual page.
Version: 1.1.1
Author: Dk Ribeiro
Author URI: http://viagiz.com
License: GPL2
*/

if(!isset($_REQUEST['frame']) ||$_REQUEST['frame']!='sim'){
	
	
	 function ativar(){
		add_option('flcclass', 'comments-link a');
		add_option('flcappid', '');
		add_option('flcadmins', '');
		add_option('flcform', '');
		add_option('flcremove', '');
		add_option('flcformid', 'comments');
		add_option('flczero', 'Respond');
		add_option('flcum', 'comment');
		add_option('flcmais', 'comments');
		add_option('flclang', 'en_US');
		add_option('flcwidth', '580');
		add_option('flcstyle', 'light');
	 }
	 
	  function criarMenu(){
		add_options_page( 'Facebook Lightbox Comments Config', 'Fb lightbox comments', 5, 'flc-options','config_options');
	 }
	 
	 function config_options(){
		 $msg = '';
 
if($_POST){
 update_option('flcclass', $_POST['flcclass']);
 update_option('flcappid', $_POST['flcappid']);
 update_option('flcadmins', $_POST['flcadmins']);
 update_option('flclang', $_POST['flclang']);
 update_option('flcstyle', $_POST['flcstyle']);
 update_option('flcform', $_POST['flcform']);
 update_option('flcremove', $_POST['flcremove']);
 update_option('flcformid', $_POST['flcformid']);
 update_option('flcwidth', $_POST['flcwidth']);
 update_option('flczero', $_POST['flczero']);
 update_option('flcum', $_POST['flcum']);
 update_option('flcmais', $_POST['flcmais']);
 
 $msg = '<div id="message" class="updated"><p>Options updated!</p></div>';
 
}
?>
 
<h2>Facebook Lightbox Comments Options</h2>
<?php echo $msg; ?>
<form action="" method="post">
<p><b>Comments links Class: </b> <input name="flcclass" type="text" value="<?php echo get_option('flcclass');?>" size="20"/> <small>(default is comments-link a)</small></p>

<p><b>Facebook App Id: </b> <input name="flcappid" type="text" value="<?php echo get_option('flcappid');?>" size="40"/>
<?php if(get_option('flcappid')!=''){?><a href="https://developers.facebook.com/tools/comments?id=<?php echo get_option('flcappid');?>"> Comments moderation </a><?php } else echo '<a target="_blank" href="https://developers.facebook.com/apps"> Get your App ID Here</a>'; ?>
</p>

<p><b>Facebook Comments admins IDs: </b> <input name="flcadmins" type="text" value="<?php echo get_option('flcadmins');?>" size="40"/> <small>(separate the uids by comma without spaces)</small></p>

<p><b>Language: </b> <input name="flclang" type="text" value="<?php echo get_option('flclang');?>" size="10"/> <small>(default is en_US)</small></p>

<p><b>Comments style: </b> <select name="flcstyle">
  <option value="light">light</option>
  <option value="dark" <?php if(get_option('flcstyle')=='dark'){ echo 'selected="selected"' ;}?> >dark</option>
</select> 
<small>(default is ligth)</small></p>

<p><b>Wp Comments  DIV Id in post page: </b> <input name="flcformid" type="text" value="<?php echo get_option('flcformid');?>" size="20"/> <small>(default is comments)</small></p>

<p><label><b>Add Facebok comments in post page: </b> <input name="flcform" type="checkbox" value="1" <?php if(get_option('flcform')=='1') echo 'checked="checked"';?>  /> </label></p>

<p><label><b>Remove wordpress comments in post page: </b> <input name="flcremove" type="checkbox" value="1" <?php if(get_option('flcremove')=='1') echo 'checked="checked"';?>  /> </label></p>

<p><label><b>Comment's width: </b> 
    <input name="flcwidth" type="text" value="<?php echo get_option('flcwidth');?>" size="10"/></label><small>(default is 580)</small></p>

<br />

<p><b>No comments label: </b> <input name="flczero" type="text" value="<?php echo get_option('flczero');?>" size="20"/></p>

<p><b>One comment label: </b> <input name="flcum" type="text" value="<?php echo get_option('flcum');?>" size="20"/></p>

<p><b>More than one comments label: </b> <input name="flcmais" type="text" value="<?php echo get_option('flcmais');?>" size="20"/></p>


<input type="submit" name="Submit" value="Update options" class="button-primary" />
</form>


<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="BTGFR8Z8X3K4Q">
<input type="image" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - A maneira mais fácil e segura de efetuar pagamentos online!">
<img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
</form>


<?php
		 
	 }
	 
	// Função ativar
	register_activation_hook( __FILE__, 'ativar');
	
	//Ação de criar menu
	add_action('admin_menu', 'criarMenu');
	
	
	// hides para calculo
	function addhides($content) {
		$hidinputs = '<input type="hidden" id="url'.get_the_ID().'" class="posturl" value="'.get_permalink().'" />
					<input type="hidden" id="com'.get_the_ID().'" class="postcom" value="'.get_comments_number().'" />';
		return $content.$hidinputs;
	}
	add_filter('the_content', 'addhides');
	
	
	/// adicionar o jquery
	function inijquery() {
		if (!is_admin()) wp_enqueue_script('jquery');
	}
	add_action('init', 'inijquery');
	
	
	/// javascript
	function addhead_com(){
		?>
        
        <?php if(get_option('flcadmins')!=''){?><meta property="fb:admins" content="<?php echo get_option('flcadmins');?>"/><?php }?>
        <?php if(get_option('flcappid')!=''){?><meta property="fb:app_id" content="<?php echo get_option('flcappid');?>"/><?php }?>
        
        
		<script language="javascript">
		jQuery(function($){
			
			<?php if(!is_single()){ ?>
			$('body').prepend('<div id="sombrafbc"></div><div id="palcom"><img id="closelfb" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAdCAYAAABWk2cPAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAVVSURBVHjaxFdbSFxHGJ7djfdb1HgNpsV7iwQrYhWN5EmReHlqUEGqUcGHohBCMSqhqEgU8aWiqH0QBDGkAe2bF1ARMduKldqqsURFrVqtBo1uvOzu9P+n/znMWVfNWwc+zp455/zf/LdvZnXs8qGTrrbAwe2ASddrDdvOIfSEGwADQW9DagVYCGa6t9os4kpS5bdCgGSOCpqamj5PSUm5d+fOnS98fHyiHB0dg3U6HT8/P//r6Ojoj729PePy8vJIRkbGnLQQdh25johcADcBQYDQ4uLitNevX3eB4Q2r1coVbG1t8ZWVFS7PnZ6ewtTK856eniiypbskmuoDB4ArwBfwCSCmvr7+GzBiJIO8s7OTP3jwgLu6umqQnJzMW1pauMlkEuTg9eDo6Gg62bRLrHiIhLfQO0B8VVXVk83NzUU0Mjg4yKOioi6Q2eLu3bt8enpaEJ+cnBiHh4fTJY81QwmpLxEmpKWlPVpYWJjFj7u7u7mHh8e1hC4uLgLu7u68oaFBEIPng11dXdH2iJ0ohxjSeEDmy5cvf1I8vIpQIbKHtrY2Qfz27dvnxKGXSd2oaGIAaVB9Nbu7u3tQODw8PFxDkpiYyO/fv3+BICQkhJeWlnJfX191zsvLi6+vr4vigsKKt/XWm8KaDMiFghjAFba2tmoI4+Li1Cqtra1VjUdHR/ONjQ0x39HRoc47OzvzsrIyMT8zM1NJrSdI9XSDReSJC4iNjY3ABy9evNAk/vj4mEFxiN81NTXs6dOnLDQ0lI2MjLDg4GAx//79e8Y5F8AxMDDAgJRBxL609TQEiwfwFeBbWPXewcGB3fzl5OSobYHA95Tfr1694m5ubsJDGbOzs1jJS2Dbg0RHeOpAiUZvXSEvntvb2xovlZUPDQ2x3NxcdnZ2Ju6hyMS1v7+fFRUV/SdnBoMGkFfm4OBwmwjV8Cpy50RgIG0XCJUBYiHCKI/5+XlmsVjsSh3Ogw2drNt6W2Hf2dk5DgwMtGsAciO8hWiIe8wXDhASVllZafcbzDdEZlNWJr3tS4uLi+9A0MXLspcYSiQMCAhQQ/rw4UO1uKqrq1lJSYnGFoY3MjKSQfu9kef10naEW5NlfHx8Bx9kZWVpDODHMmFhYSED8WD5+fkqMWiw5pvU1FTm6enJlpaWfrXd7rBH7wG+BnwXExPzI1TwEe4icrMjsO8qKio4GBKVqgC2PF5XV8cjIiI08xMTExx3J2ivdFK9G3ZbBvB9Y2Pj79gGzc3NGlJsAdnoVYBQi1YyGo1dxKG2jIHE3pGu2DYukFcrSJ4P5Mx9dXWVzc3NqfnV6/XXnUZYQkIC6+vrY7BL/fzs2bNW2DywkE4ohdxAhPIpwenw8BALCj++CSt2MZvNbHJy8qNIsbh6e3vZ/v7+m/b29h9AGo0oaIBT6TShFXzAI1Q6DHNSUtIwkG1hmGC1PC8vj/v5+dkNZ2ZmJocThggpFM7s48ePn5DNIOJQZVBHgoCh9QL4AQLpRSzVW0FBQbfLy8s/Kygo+BTayA12DaxGBiIuVgyFx6CARJXCiWF/bGxsEmqhH3L5GzzeBRwAPqDmUJeopwblqOJFpwd/wi3ahdzh5BCUnZ0dAluff1hYmLe/vz+uHokO19bW/p6amvoTWukXqNhZmMa2+4cITURoUVpGUQmDzW7jI8GbKs+VomJQFI7yhEZRF98B9iUc0rMzmZBJfWOh1ZjooYWq7ZhW6y6RKt+YJdIjIjmgBRxJIbXYOx9x8tYsqYaFVmgiQwqhoySdVnpHITYR0QeaO7/s7PvRh23K+w0bUjMZP5Ngvu6w/b/8rfhXgAEAmJkyLSnsNQEAAAAASUVORK5CYII=" /><div id="alvoiframe"></div></div>');
			
			
			/// exibir  lightbox
			$(".<?php echo get_option('flcclass');?>").live("click", function(){
				$("#sombrafbc, #palcom").slideDown();
				
				if($(this).parent().find('.posturl').length) var urltoi = $(this).parent().find('.posturl').val();
				else if($(this).parent().parent().find('.posturl').length) var urltoi = $(this).parent().parent().find('.posturl').val();
				else if($(this).parent().parent().parent().find('.posturl').length) var urltoi = $(this).parent().parent().parent().find('.posturl').val();
				else if($(this).parent().parent().parent().parent().find('.posturl').length) var urltoi = $(this).parent().parent().parent().parent().find('.posturl').val();
				else if($(this).parent().parent().parent().parent().parent().find('.posturl').length) var urltoi = $(this).parent().parent().parent().parent().parent().find('.posturl').val();
				
				var urliframe = '<iframe src="<?php echo plugins_url( 'flcomments.php' , __FILE__ ); ?>?frame=sim&flclang=<?php echo get_option('flclang');?>&flcstyle=<?php echo get_option('flcstyle');?>&flcappid=<?php echo get_option('flcappid');?>&url='+urltoi+'" width="600" height="600" frameborder="0" scrolling="auto" ></iframe>';
				$("#alvoiframe").html(urliframe);
				return false;
			});
			
			/// sair do ligthbox
			$("#sombrafbc, #closelfb").live("click", function(){
				$("#sombrafbc, #palcom").slideUp();
			});
			$(document).keyup(function(e) {
			if (e.keyCode == 27) $("#sombrafbc, #palcom").slideUp();
			});
			
			/// update nos numeros de comentarios
			$('.postcom').each(function(){
				var atucom = $(this).val();
				var urlcom = $(this).parent().find('.posturl').val();
				
				var combj = $(this).attr('id');
				
				$.getJSON("https://api.facebook.com/method/fql.query?format=json&query=SELECT+commentsbox_count+FROM+link_stat+WHERE+url+%3D+%27"+urlcom+"%27", function(json) {
					if(json[0]!=''){
					fbcom = json[0].commentsbox_count;
					var novocom = (fbcom*1)+(atucom*1);
					
					if(novocom == 0) var novocom = '<?php echo get_option('flczero');?>';
					if(novocom == 1) var novocom = '1 <?php echo get_option('flcum');?>';
					if(novocom>1) var novocom = novocom+' <?php echo get_option('flcmais');?>';
						if($('#'+combj).parent().find('.<?php echo get_option('flcclass');?>').length) $('#'+combj).parent().find('.<?php echo get_option('flcclass');?>').html(novocom);
						else if($('#'+combj).parent().parent().find('.<?php echo get_option('flcclass');?>').length) $('#'+combj).parent().parent().find('.<?php echo get_option('flcclass');?>').html(novocom);
						else if($('#'+combj).parent().parent().parent().find('.<?php echo get_option('flcclass');?>').length) $('#'+combj).parent().parent().parent().find('.<?php echo get_option('flcclass');?>').html(novocom);
					}
				});
				
			});
			
				
				
	<?php } elseif(is_single()) {
		
		if(get_option('flcform')=='1' and get_option('flcremove')=='1') {?>
			urldopost = $(".posturl").val();
			$('#<?php echo get_option('flcformid');?>').html('<div class="fb-comments" data-href="'+urldopost+'" data-width="<?php echo get_option('flcwidth');?>" style="width: 100%; margin:auto; text-align:center; padding:10px;" data-num-posts="20" data-colorscheme="<?php echo get_option('flcstyle');?>"></div>');
			<?php }
			elseif(get_option('flcform')=='1'){ ?>
			urldopost = $(".posturl").val();
			$('#<?php echo get_option('flcformid');?>').prepend('<div class="fb-comments" data-href="'+urldopost+'" data-width="<?php echo get_option('flcwidth');?>" style="width: 100%; margin:auto; text-align:center; padding:10px;" data-num-posts="20" data-colorscheme="<?php echo get_option('flcstyle');?>"></div>');
	<?php
			}
		} ?>		
		});
		</script>
		<style>
		#sombrafbc{
			background:#000;
			position:fixed;
			display:none;
			z-index:99999;
			width:120%;
			height:120%;
			opacity:0.5;
			margin:-10%;
		}
		#palcom{
			position:fixed;
			display:none;
			left:50%;
			top:50%;
			margin:-300px 0 0 -300px;
			z-index:99999;
			width:600px;
			height:600px;
			border-radius:5px;
		}
		#closelfb{
			float:right;
			margin:-20px -20px;
			z-index:1000;
			cursor:pointer;
		}
		</style>
		<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/<?php echo get_option('flclang');?>/all.js#xfbml=1&appId=<?php echo get_option('flcappid');?>";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
		<?php
	}
	add_action('wp_head', 'addhead_com');

}
else{
	
	if($_REQUEST['flcstyle']=='dark'){ echo '<body bgcolor="#000000">'; } else { echo '<body  bgcolor="#FFFFFF">';}
	
	$urlc = $_REQUEST['url'];
	if($urlc == '') echo 'Plugin cannot get the url of your post. make sure if your theme have the post loop structure configured correctly';
	else{
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/<?php echo $_REQUEST['flclang'];?>/all.js#xfbml=1&appId=<?php echo $_REQUEST['flcappid'];?>";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-comments" data-href="<?=$urlc?>" data-width="570" data-num-posts="20" data-colorscheme="<?php echo $_REQUEST['flcstyle'];?>" ></div>
	</body>
<?php
	}
} 


?>
