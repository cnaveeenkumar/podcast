<?php
// Exit you access directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if( isset($_POST['submit']) && $_POST['submit'] == "Save Changes" ){
		
		if( isset($_POST['options']['podcastpostperpage']) ){
			$podcastpostperpage = $_POST['options']['podcastpostperpage'];
		}else{
			$podcastpostperpage = "6";
		}
		
		if( isset($_POST['options']['showhidethumbnail']) ){
			$showhidethumbnail = $_POST['options']['showhidethumbnail'];
		}else{
			$showhidethumbnail = "show";
		}
		
	//$podcastpostperpage 	=	intval((!empty($_POST['options']['podcastpostperpage'])) ? $_POST['options']['podcastpostperpage'] : 8 );
	
	//$showhidethumbnail	=	sanitize_text_field((!empty($_POST['options']['showhidethumbnail'])) ? $_POST['options']['showhidethumbnail'] : show );
	
	//$podcastpostperpage = 8;
	//$showhidethumbnail = "show";
	
	update_option( 'podcastpostperpage', $podcastpostperpage );
	update_option( 'showhidethumbnail', $showhidethumbnail );

}
?>
<div class="podcast-settings-option" id="podcast-settings">
	<div class="podcast-header">
		<h1>Podcast Settings</h1>
	</div>
	<div class="podcast-holder">
		<div class="showhidelimits">
			<form name="show-options-padcast" id="show-options-padcast" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
				<input type="hidden" name="page" value="podcat-settings.php" />
				<?php settings_fields( 'podcast_option_group' ); ?>
				<?php do_settings_sections( 'podcast_option_name' ); ?>
				 <?php wp_nonce_field( 'podcast_option_group', 'podcast_option_name' ); ?>
				<table width="100%" cellspacing="5" cellpadding="5">	
					<tr>
						<td width="2%" class="textbold">Post Per page</td>
						<td width="1%" class="textlight"> : </td>
						<td width="10%">
							<input type="text" class="podcast-options" name="options[podcastpostperpage]" 
							value="<?php if( get_option('podcastpostperpage', $podcastpostperpage ) != '' ) { echo get_option('podcastpostperpage', $podcastpostperpage ); }  ?>" maxlength="2" required />
						</td>
					</tr>
					<tr>
						<td width="2%" class="textbold">Show/Hide Thumbnail</td>
						<td width="1%" class="textlight"> : </td>
						<td>
							<select class="podcast-options" name="options[showhidethumbnail]">
								<option value="show" <?php if( get_option('showhidethumbnail', $showhidethumbnail ) == 'show' ) { echo "selected"; }  ?>>Show</option>
								<option value="hide" <?php if( get_option('showhidethumbnail', $showhidethumbnail) == 'hide' ) { echo "selected"; }  ?> >Hide</option>
							</select>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
</div>