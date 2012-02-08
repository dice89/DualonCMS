<?php
$this->Html->script('jquery/jquery.relatedselects.min',false);
$this->Html->script('ckeditor/ckeditor',false);
$this->Html->script('ckeditor/adapters/jquery',false);
$this->Html->script('admin/configuration',false);
echo $this->element('config-menu');
echo $this->Form->create('Configuration');
echo $this->Form->input('config_name', array('label' => __('Configuration:')));
echo $this->Form->input('page_name', array('label' => __('Page name:')));
echo $this->Form->input('email', array('label' => __('Email:')));
echo $this->Form->input('active_template', array('options' => $themes, 'label' => __('Template:')));
echo $this->Form->input('active_design', array('options' => $designs, 'label' => __('Design:')));
echo $this->Form->input('status', array('label' => __('Online')));
echo $this->Form->input('status_text', array('type' => 'textarea'));
//Social Network Configuration
echo $this->Form->input('facebook', array('label' => __('Facebook:')));
echo $this->Form->input('twitter', array('label' => __('Twitter:')));
echo $this->Form->input('googleplus', array('label' => 'Google+:'));
echo $this->Form->input('xing', array('label' => __('Xing:')));
echo $this->Form->input('linkedin', array('label' => __('LinkedIn:')));
echo $this->Form->end(__('Save Configuration'));
?>
