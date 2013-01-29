
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline): ?>

<<?php echo $this->hl; ?>><?php echo $this->headline; ?></<?php echo $this->hl; ?>>
<?php endif; ?>

<form action="system/modules/DataExporter/DataExporterExecutor.php" method="post">
	<input type="hidden" name="FORM_SUBMIT" value="<?php echo $this->formSubmit; ?>"> 
	<input type="submit" name="export" value="<?php echo $this->button; ?>" />
</form>

</div>
