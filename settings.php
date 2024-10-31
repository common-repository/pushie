<?php
$strNotice = null;

if(!current_user_can('manage_options')) {
	die('ACCESS DENIED: Your don\'t have permission to do this.');
	
} elseif($_POST['update'] && $_POST['update'] == 'true' ) {
	
	// Notification
	if(isset($_POST['notification_onComment'])) {
		update_option('pushie_notification_onComment', 1);
	} else {
		update_option('pushie_notification_onComment', 0);
	}
	if(isset($_POST['notification_onPingback'])) {
		update_option('pushie_notification_onPingback', 1);
	} else {
		update_option('pushie_notification_onPingback', 0);
	}
	
	// Boxcar	
	update_option(
		'pushie_boxcar_apiKey', 
		strip_tags(stripslashes($_POST['boxcar_apiKey']))
	);
	update_option(
		'pushie_boxcar_apiSecret', 
		strip_tags(stripslashes($_POST['boxcar_apiSecret']))
	);
	update_option(
		'pushie_boxcar_email', 
		strip_tags(stripslashes($_POST['boxcar_email']))
	);
	
	$strNotice = 'Settings saved!';
	
}

?>
<div class="wrap"> 
	<div id="icon-options-general" class="icon32"><br /></div> 
	<h2>Pushie Settings</h2>
	
	<?php
		if($strNotice){
			echo '<p id="pushieNotice">'.$strNotice.'</p>';
		}
	?>
	
	<p><?php 
		if(function_exists('curl_init')) {
			echo 'Your WordPress supports cURL. Things should run swimmingly!';
		} else {
			echo '<span class="issue">Your WordPress doesn\'t support cURL, this plugin may not work.</span>';	
		}
	?></p>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
		
		<fieldset>
		
			<legend>Notification</legend>
			<small>More options coming soon</small>
			
			<p>
				<strong>On:</strong>
				<label>
					<input type="checkbox" name="notification_onComment" <?php if(get_option('pushie_notification_onComment') == '1') echo 'checked'; ?> /> New Comment
				</label>
				<label>
					<input type="checkbox" name="notification_onPingback" <?php if(get_option('pushie_notification_onPingback') == '1') echo 'checked'; ?> /> New Pingback
				</label>
			</p>
		
		</fieldset>
		
		<fieldset>
			
			<legend>Boxcar <small><a href="http://boxcar.io/" target="_blank">http://boxcar.io/</a></small></legend>
			
			<p>
				To use Pushie with Boxcar, make sure you have a Boxcar account, downloaded it to your phone and then linked your account.<br />
				Then you need to <a href="http://boxcar.io/site/providers/new" target="_blank">create a provider</a> to reflect your site. Possible settings for this blog are:<br />
				<br />
				<strong>Name</strong>
				<?php bloginfo('name'); ?><br />
				<br />
				<strong>Description</strong>
				<?php bloginfo('description'); ?><br />
				<br />
				<strong>Website URL</strong>
				<?php bloginfo('url'); ?><br />
				<br />
				Save the information and you should be provided with a API key and API secret.<br />
				Copy and past those into the boxes below along with the email address of your boxcar account and you should be good to go!
			</p>
			
			<p>
				<label for="apikey">API Key</label>
				<input type="text" name="boxcar_apiKey" id="boxcar_apiKey" value="<?php echo attribute_escape(get_option('pushie_boxcar_apiKey')); ?>" />
			</p>
			
			<p>
				<label for="apisecret">API Secret</label>
				<input type="text" name="boxcar_apiSecret" id="boxcar_apiSecret" value="<?php echo attribute_escape(get_option('pushie_boxcar_apiSecret')); ?>" />
			</p>
			
			<p>
				<label for="email">Email <small>(what you registered Boxcar with)</small></label>
				<input type="text" name="boxcar_email" id="boxcar_email" value="<?php echo attribute_escape(get_option('pushie_boxcar_email')); ?>" />
			</p>
			
		</fieldset>
	
		<p>
			<input type="hidden" name="update" value="true" />
			<input type="submit" name="action" value="Save Settings" />
		</p>
	
	</form>
	
	<hr />
	
	<p>Developed by <a href="http://wolfiezero.com/" taget="_blank">Neil 'WolfieZero' Sweeney</a></p>
	
</div>
<style>
	p{
		display: block;
	}
		.issue{
			background: red;	
			padding: 4px 8px;
			border-radius: 	5px;
			color: #FFF;
		}
		p strong{
			display:		inline-block;
			width:			100px;
		}
		#pushieNotice{
			color:			#555;
			font-size:		1.2em;
			font-style:		italic;
			text-align:		center;
			width:			400px;
			margin:			0 auto;
			border:			1px solid #CCC;
			padding:		13px 16px;
			border-radius: 	15px;
			background:		#FEFEFE;
		}
		p.centre{
			text-align: center;
		}
	label{
		width:			200px;
		margin:			0 20px 0 0;
	}
	small{
		display:		block;
	}
	input[type=text]{
		width:			400px;
		display:		block;
	}
	input[type=submit]{
		cursor:			pointer;
	}
	legend{
		display:		block;
		width:			100%;
		font-family:	Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif;
		font-size:		1.6em;
		font-style:		italic;
		text-decoration:underline;
		line-height:	1.8em;
		margin-bottom:	20px;
	}
		legend small{
			font-size:	0.6em;
			display:	inline;
		}
	fieldset{
		margin:			0 0 40px;
	}
		fieldset p{
			margin: 	10px 0 10px 20px;
		}
</style>

<script>
	jQuery(document).ready(function($) {
		$('#pushieNotice').delay(1000).fadeOut('slow');
	});
</script>