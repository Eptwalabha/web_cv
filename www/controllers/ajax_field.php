<?php

class ajax_field extends controller {
	
	public function formForNewField() {

		if (isset($_POST['domain_id'])) {
			
			$id = (int) $_POST['domain_id'];
		?>
<form action="" id="form_new_domain_<?php echo $id; ?>" >
	<label for="id_txt_field_name_<?php echo $id; ?>" >Comp&eacute;tence</label>
	<input type="text" id="id_txt_field_name_<?php echo $id; ?>" placeholder="Le nom de la comp&eacute;tence" required />
	<label for="id_sel_field_lvl_<?php echo $id; ?>" >Niveau</label>
	<select id="id_sel_field_lvl_<?php echo $id; ?>">
		<option value="1" selected>option1</option>
		<option value="2" >option2</option>
		<option value="3" >option3</option>
		<option value="4" >option4</option>
		<option value="5" >option5</option>
		<option value="6" >option6</option>
	</select>
	<label for="id_field_description_<?php echo $id; ?>" >Description</label>
	<textarea class="span6" rows="7" placeholder="D&eacute;scription de la comp&eacute;tence_<?php echo $id; ?>"></textarea><br />
	<input type="hidden" value="<?php echo $id; ?>" />
	<button type="submit" class="btn">Enregistrer</button>
	
</form>
		<?php
		
		}

	}
	
}