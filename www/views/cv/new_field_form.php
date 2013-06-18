<?php
if (isset($domain)) {
	$id = $domain->getDomainID();
?>
<form action="#" id="form_new_domain_<?php echo $id; ?>" data-domain-id="<?php echo $id; ?>" >
	<label for="id_txt_field_title_<?php echo $id; ?>" >Comp&eacute;tence</label>
	<input type="text" id="id_txt_field_title_<?php echo $id; ?>" placeholder="Le nom de la comp&eacute;tence" required />
	<label for="id_sel_field_lvl_<?php echo $id; ?>" >Niveau</label>
	<select id="id_sel_field_lvl_<?php echo $id; ?>">
		<option value="1" selected>gros noob</option>
		<option value="2" >petit noob</option>
		<option value="3" >noob</option>
		<option value="4" >mouais...</option>
		<option value="5" >pas mal</option>
		<option value="6" >nice</option>
		<option value="7" >boss</option>
		<option value="7" >god</option>
	</select>
	
	<label for="id_field_text_<?php echo $id; ?>" >Description</label>
	<textarea class="span6" rows="7" id="id_field_text_<?php echo $id; ?>" placeholder="D&eacute;scription de la comp&eacute;tence_<?php echo $id; ?>"></textarea><br />
	<input type="hidden" value="<?php echo $id; ?>" />
	<button type="submit" class="btn">Enregistrer</button>

</form>
<?php

}