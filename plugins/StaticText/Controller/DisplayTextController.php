<?php
/*
 * Controller for editing text
 */
class DisplayTextController extends StaticTextAppController {
	//Component for editing the ContentValue-table
	public $components = array('ContentValueManager');
	
	/*
	 * Main-Function
	 * Loads the Data from the database and prepare it to be displayed
	 * Tests if the actual user has the right to edit-text
	 */
	public function admin($contentId){
		$this->set('contentId',$contentId );
		$this->layout = 'overlay';
		//Load datatable
		$this->loadModel('Plugin');
		//find plugin
		$textPlugin = $this->Plugin->findByName($this->plugin);
		//Get plugin-ID
		$pluginId = $textPlugin['Plugin']['id'];
		$editAllowed = $this->PermissionValidation->actionAllowed($pluginId, 'edittext');
		//If you are in the requiered role
		if ($editAllowed){	
			//Load and save data
			//save data
			if ($this->request->is('post')) {
				$this->ContentValueManager->saveContentValues($contentId, $this->request->data['null']);
				$this->Session->setFlash(__d('static_text', 'Successfully saved'));
			}
			//load data with contentId
			$contentValues = $this->ContentValueManager->getContentValues($contentId);
			if (array_key_exists('Text', $contentValues)) {
				$text = $contentValues['Text'];
			} else {
				$text = __d('static_text',"empty"); //"Leer" or '' ?
			} 
			// load the value for 'published' to display it
			if (array_key_exists('Published', $contentValues)) {
				$pub = $contentValues['Published'];
			} else {
				$pub = false;
			}
			//prepare data to be displayed
			if (empty($this->request->data)) {
				$this->request->data = array(
			                'null' => array(
			                    'Text' => $text,
			                    'Published' => $pub
				)
				);
			}
		} else    { //If you are not aloowed to
		   $this->Session->setFlash(__d('static_text','You are not authenticated to enter these page!'));
		   //Go to mainpage
			$this->redirect($this->referer());
		}
	}	
}