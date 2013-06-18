<li>
	<div class="row-fluid">
		<div class="span3">
			<h4 class="text-right" ><?php echo $field->getFieldTitle();?></h4>
			<p class="text-right" ><?php echo $field->getFieldRawDateBeginning();?></p>
			<p class="text-right" ><?php echo $field->getFieldLevel();?></p>
		</div>
		<div class="span9" >
			<p><?php echo $field->getFieldText(); ?></p>
		</div>
	</div>
</li>