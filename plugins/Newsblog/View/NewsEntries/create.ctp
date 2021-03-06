<?php
/*
* This file is part of BeePublished which is based on CakePHP.
* BeePublished is free software: you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation, either version 3
* of the License, or any later version.
* BeePublished is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
* You should have received a copy of the GNU General Public
* License along with BeePublished. If not, see
* http://www.gnu.org/licenses/.
*
* @copyright 2012 Duale Hochschule Baden-Württemberg Mannheim
* @author Philipp Scholl
*
* @description View to write a news entry
*/

$this->Html->script('jquery/jquery-ui-timepicker-addon', array('inline' => false));
$this->Html->script('ckeditor/ckeditor', array('inline' => false));
$this->Html->script('ckeditor/adapters/jquery', array('inline' => false));
$this->Html->script('/newsblog/js/admin_write', false);
$this->Html->css('/newsblog/css/admin', null, array('inline' => false));
$this->Html->css('/css/jqueryui/jquery-ui-1.8.17.custom', null, array('inline' => false));
$this->Html->css('/css/jqueryui/jquery-ui-timepicker-addon.css', null, array('inline' => false));
$DateTimeHelper = $this->Helpers->load('Time');

echo $this->element('admin_menu',array('plugin' => 'Newsblog'), array('contentId' => $contentId));
$this->Js->set('webroot', $webroot);
$this->Js->set('validFromAltText', __d('newsblog','Choose Valid From'));
$this->Js->set('validToAltText', __d('newsblog','Choose Valid To'));
$dateFormat = __('m-d-Y');
$this->Js->set('dateFormatForPicker', $dateFormat);
$writeAllowed = $this->PermissionValidation->actionAllowed($pluginId, 'Write');

if($writeAllowed){
	echo '<div id="admin_newsblog-write">';
	echo '<div class="writeNewsContainer">';
	
		//create form
		echo $this->Form->create('NewsEntry', array('url' => array('plugin' => 'Newsblog', 'controller' => 'NewsEntries', 'action' => 'create')));
		//create title input
		echo $this->Form->input('NewsEntry.title', array(
			//'div' => 'writeNewsTitle',
			'label' => __d('newsblog','Title:'),
			'name' => 'title'
		));
		//create subtitle input
		echo $this->Form->input('NewsEntry.subtitle', array(
			//'div' => 'writeNewsSubtitle',
			'label' => __d('newsblog', 'Subtitle:'),
			'name' => 'subtitle'
		));
		//create entrytext textarea
		echo $this->Form->input('NewsEntry.text', array(
			//'div' => 'writeNewsBody',
			'label' => false,
			'id' => 'writeNewsTextEditor',
			'name' => 'text'
		));
		//create validFrom input
		echo $this->Form->input('NewsEntry.validFrom', array(
			'div' => 'writeValidConfiguration',
			'type' => 'text',
			'id' => 'nbValidFromDatepicker',
			'label' => __d('newsblog', 'Valid from:'),
			'name' => 'validFromUI',
			'class' => 'datepicker',
			'disabled' => true
		));
		//create validTo input
		echo $this->Form->input('NewsEntry.validTo', array(
			'div' => 'writeValidConfiguration',
			'type' => 'text',
			'id' => 'nbValidToDatepicker',
			'label' => __d('newsblog', 'Valid to:'),
			'name' => 'validToUI',
			'class' => 'datepicker',
			'disabled' => true
			
		));
		//hidden fields
		echo $this->Form->hidden(null,array(
			'id' => 'validFromDB',
			'name' => 'validFrom'
		));
		echo $this->Form->hidden(null,array(
			'id' => 'validToDB',
			'name' => 'validTo'
		));
		
		//contentid
		echo $this->Form->hidden(null,array(
			'name' => 'contentId',
			'value' => $contentId
		));
		
		echo $this->Form->end(__d('newsblog', 'Create News'));
		
	echo '</div>';
	echo '</div>';
}
?>