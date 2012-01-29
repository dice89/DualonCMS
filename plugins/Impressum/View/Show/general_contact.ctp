﻿<h2>
	<?php 
		$type = $input['Impressum']['type'];
		switch ($type) {
			case 'comp':
			echo __('Bitte geben Sie die Kontaktdaten Ihres Unternehmens ein.');
			break;
			case 'club':
			echo __('Bitte geben Sie die Kontaktdaten Ihres Vereins ein.');
			break;
			case 'public':
			echo __('Bitte geben Sie die Kontaktdaten Ihrer Körperschaft ein.');
			break;			
		}
	?>
</h2>
<br>
<?php
	echo $this->Form->create('Impressum',array('url' => array('plugin'     => 'Impressum',
														   	  'controller' => 'Show',
															  'action'	   => 'generalContact'))); 
	
	if (!empty($input['Impressum']['phone_no'])) {
		echo $this->Form->input('Impressum.phone_no', array('label' => __('Telefonnummer:'), 'value' => $input['Impressum']['phone_no']));
	} else {
		echo $this->Form->input('Impressum.phone_no', array('label' => __('Telefonnummer:')));
	}
	
	if (!empty($input['Impressum']['fax_no'])) {
		echo $this->Form->input('Impressum.fax_no', array('label' => __('Faxnummer:'), 'value' => $input['Impressum']['fax_no']));
	} else {
		echo $this->Form->input('Impressum.fax_no', array('label' => __('Faxnummer:')));
	}
	
	if (!empty($input['Impressum']['email'])) {
		echo $this->Form->input('Impressum.email', array('label' => __('E-Mail-Adresse:'), 'error' => __('Das ist keine gültige E-Mail-Adresse') ,'value' => $input['Impressum']['email']));
	} else {
		echo $this->Form->input('Impressum.email', array('label' => __('E-Mail-Adresse:'), 'error' => __('Das ist keine gültige E-Mail-Adresse')));
	} 
?>
<p>
	<?php echo __('Hinweis: Ihre E-Mail-Adresse wird so dargestellt, dass sie nicht von Spambots ausgelesen werden kann.')?>
</p>
<br>
<h3>
	<?php echo __('Daten des Vertretungsberechtigten')?>
</h3>
<br>
<?php 
	if (!empty($input['Impressum']['auth_rep_first_name'])) {
		echo $this->Form->input('Impressum.auth_rep_first_name', array('label' => __('Vorname:'), 'value' => $input['Impressum']['auth_rep_first_name']));
	} else {
		echo $this->Form->input('Impressum.auth_rep_first_name', array('label' => __('Vorname:')));
	}
	
	if (!empty($input['Impressum']['auth_rep_last_name'])) {
		echo $this->Form->input('Impressum.auth_rep_last_name', array('label' => __('Name:'), 'value' => $input['Impressum']['auth_rep_last_name']));
	} else {
		echo $this->Form->input('Impressum.auth_rep_last_name', array('label' => __('Name:')));
	}
?>
<br>
<?php echo $this->Form->end(__('weiter')); ?>