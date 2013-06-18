<form action="#" id="form_new_domain" >
	<label for="id_txt_domain_title" >Nom domaine de comp&eacute;tence</label>
	<input type="text" id="id_txt_domain_title" placeholder="Le nom du nouveau domaine" data-provide="typeahead" autocomplete="off" 
		data-source='<?php echo isset($auto_complete)? $auto_complete : ""; ?>' required />
	<label for="id_txt_domain_text" >Description</label>
	<textarea class="span6" rows="5" id="id_txt_domain_text" placeholder="D&eacute;scription du domaine de comp&eacute;tence"></textarea><br />
	<button type="submit" class="btn save_domain"><i class="icon-plus"></i></button>
</form>