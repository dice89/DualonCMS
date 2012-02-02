<?php
App::uses('Sanitize', 'Utility');
class FoodMenuEntriesController extends FoodMenuAppController {
	
	public $name = 'FoodMenuEntries';
	public $uses = array('FoodMenu.FoodMenuMenu', 'FoodMenu.FoodMenuCategory', 'FoodMenu.FoodMenuEntry', 'FoodMenu.FoodMenuCategoriesFoodMenuEntry');
	var $layout = 'overlay';

	function beforeRender()
    {
        parent::beforeRender();

        //Get PluginId for PermissionsValidation Helper
        $pluginId = $this->getPluginId();
        $this->set('pluginId', $pluginId);
    }
    
    public function index() {
		$entries = $this->FoodMenuEntry->find('all', array('conditions' => array('deleted' => null)));
		$this->set('entries', $entries);	
	}

	function create() {
		$pluginId = $this->getPluginId();
		$createAllowed = $this->PermissionValidation->actionAllowed($pluginId, 'create', true);
		
			if ($this->request->is('post') && isset($this->request->data['FoodMenuEntry'])) {
			$save = $this->request->data;
			$save['price'] = str_replace(',', '.', $save['price']);				
            if ($this->FoodMenuEntry->save(Sanitize::clean($save, array('encode' => false)))) {
                $this->Session->setFlash(__d('food_menu', 'The entry has been saved successfully.', array('class' => 'flash_success')));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__d('food_menu', 'The entry couldn\'t be saved.', array('class' => 'flash_failure')));
            }//else
        }//if
	}//create
	
	function edit($name = null, $id = null) {	
		$pluginId = $this->getPluginId();
		$editAllowed = $this->PermissionValidation->actionAllowed($pluginId, 'edit', true);
		// Has any form data been POSTed?
    	if ($this->request->is('post') && isset($this->request->data['FoodMenuEntry'])) {
        	// If the form data can be validated and saved...
        	$save = $this->request->data;
        	$save['price'] = str_replace(',', '.', $save['price']);
        	if ($this->FoodMenuEntry->save(Sanitize::clean($save, array('encode' => false)))) {
            	// Set a session flash message and redirect.
            	$this->Session->setFlash((__d('food_menu', 'The entry has been changed successfully', array('class' => 'flash_success'))));
            	$this->set('mode', 'edit');
            	$this->redirect($this->referer());
            	//$this->render('/View/admin');
        	}
    	}
	    // If no form data, find the recipe to be edited
    	// and hand it to the view.
    	$entry = $this->FoodMenuEntry->findById($id);
    	$this->set('entry', $entry);
    	$this->set('mode', 'edit');
    	
    	//Submit variables of admin method to make back-button work
    	$menus = $this->FoodMenuMenu->find('all');
		$this->set('menus', $menus);
		$categories = $this->FoodMenuCategory->find('all');
		$this->set('categories', $categories);
		$entries = $this->FoodMenuEntry->find('all');
		$this->set('entries', $entries);
			
	}//edit

	function delete($name = null, $id = null) {
		$pluginId = $this->getPluginId();
		$deleteAllowed = $this->PermissionValidation->actionAllowed($pluginId, 'delete', true);
		
		$this->FoodMenuEntry->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->FoodMenuEntry->read();
			$this->request->data['FoodMenuEntry']['deleted'] = date("Y-m-d H:i:s");
			$save['FoodMenuEntry'] = $this->request->data['FoodMenuEntry'];
			if($this->FoodMenuEntry->save($save)) {
				$this->FoodMenuCategoriesFoodMenuEntry->deleteAll(array('FoodMenuCategoriesFoodMenuEntry.food_menu_entry_id' => $id), false);
				$this->Session->setFlash(__d('food_menu', 'The entry has been deleted.', array('class' => 'flash_success')));
				$this->redirect($this->referer());
			}//if
		}//if	
	}//delete
	
	function deleteMultiple() {
		$pluginId = $this->getPluginId();
		$deleteAllowed = $this->PermissionValidation->actionAllowed($pluginId, 'delete', true);
		
		if(array_key_exists('FoodMenuEntry', $this->request->data)) {
			$ids = array_keys($this->request->data['FoodMenuEntry']);
			foreach ($ids as $id) {
					$this->FoodMenuEntry->id = $id;
					$this->request->data = $this->FoodMenuEntry->read();
					$this->request->data['FoodMenuEntry']['deleted'] = date("Y-m-d H:i:s");
					$save['FoodMenuEntry'] = $this->request->data['FoodMenuEntry'];
					if($this->FoodMenuEntry->save($save)) {
						$this->FoodMenuCategoriesFoodMenuEntry->deleteAll(array('FoodMenuCategoriesFoodMenuEntry.food_menu_entry_id' => $id), false);
						continue;
					}//if
					else {
						$this->Session->setFlash(__d('food_menu', 'Errors occured during deleting.', array('class' => 'flash_failure')));
						$this->redirect($this->referer());
					}	
			}
			$this->Session->setFlash(__d('food_menu', 'The entries have been deleted.', array('class' => 'flash_success')));
			$this->redirect($this->referer());
		}
		else {
			$this->Session->setFlash(__d('food_menu', 'No entries were selected.', array('class' => 'flash_failure')));
			$this->redirect($this->referer());
		}
	}//deleteMultiple
}
?>