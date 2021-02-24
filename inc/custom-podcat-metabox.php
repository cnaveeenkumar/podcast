<table class="res-table">
	<tbody>
		<tr class="res-field">
			<td class="res-label">Audio Link</td>
			<td class="res-input">
				<input type="text" name="meta[audiolink]" id="audiolink" class="form-control" value="<?php echo get_post_meta(get_the_ID(), 'audiolink', true);?>">
			</td>
		</tr>
		<tr class="res-field">
			<td class="res-label">&nbsp;</td>
			<td class="res-input">&nbsp;</td>
		</tr>
		<tr class="res-field">
			<td class="res-label">Transcript</td>
			<td class="res-input">
				<textarea  name="meta[transcript]" id="transcript" class="form-control" rows="10" cols="40" ><?php echo get_post_meta(get_the_ID(), 'transcript', true);?></textarea>
			</td>
		</tr>
	</tbody>
</table>