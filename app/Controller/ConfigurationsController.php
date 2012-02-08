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
 * @author Christoph Krämer
 *
 * @description Controller for CMS basic settings
 */

App::uses('Folder', 'Utility');

class ConfigurationsController extends AppController
{

    function beforeFilter()
    {
        parent::beforeFilter();
        //all methods are only available to user with appropriate permission
        $this->PermissionValidation->actionAllowed(null, 'GeneralConfiguration', true);
    }

    public function index()
    {
        $this->layout = 'overlay';

        $config = $this->Configuration->find('first');

        //if no config entry exists a new one has to be created
        if (!$config) {
            $config = $this->Configuration->create();
            $config['config_name'] = 'default';
            $config['page_name'] = 'BeePublish';
            $config['status'] = true;
            $config['config_name'] = 'default';
            $config['active_design'] = 'default';
            $config['active_template'] = 'BeeDefault';
            $config['language'] = 'eng';
            $this->Configuration->save($config);
            $this->redirect(array('action' => 'index'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')) {
            //Save configuration data
            $this->Configuration->id = $config['Configuration']['id'];
            if (isset($this->request->data['Configuration']['submittedfile']))
            	$this->uploadImage($this->data['Configuration']['submittedfile'], true);
            if ($this->Configuration->save($this->request->data)) {
                $this->Session->setFlash('Successfully saved');
            } else {
                $this->Session->setFlash('Saving failed');
            }
            $this->redirect(array('action' => 'index'));
        } else {
            //load configuration data
            $this->request->data = $config;
        }

        //read all available themes from themed dirctory
        $themeFolder = new Folder(APP . 'View' . DS . 'Themed');
        list($themes, $files) = $themeFolder->read();

        $themesSelect = array();
        foreach ($themes as $theme) {
            $themesSelect[$theme] = $theme;
        }

        //get all designs for selected template
        $designs = $this->getDesignsForTemplate($config['Configuration']['active_template']);

        $this->set('themes', $themesSelect);
        $this->set('designs', $designs);

    } //index()

    public function designs()
    {
        $name = $_GET['data']['Configuration']['active_template'];
        $this->layout = null;
        $this->set('designs', json_encode($this->getDesignsForTemplate($name)));
    }

    private function getDesignsForTemplate($template)
    {
        //scan folder
        $designFolder = new Folder(APP . 'View' . DS . 'Themed' . DS . $template . DS . 'webroot' . DS . 'css' . DS . 'designs');
        list($folders, $designs) = $designFolder->read();
        $designsSelect = array();
        foreach ($designs as $design) {
            //remove .css from design name
            $design = substr($design, 0, -4);
            $designsSelect[$design] = $design;
        }
        return $designsSelect;
    }
    
    
    /**
    * Function to upload image.
     */
    private function uploadImage($file, $init_creation, $file_old="logo.png"){
	    
	    /* FILE */
    	$file_path = WWW_ROOT.'uploads\\';
    	$file_name = "logo.png";
    	$upload_error = true;
    	
	    //CREATE folder
	    if(!is_dir ($file_path))
	    	@mkdir($file_path);
	    	
	    //CHECK filetype
	    $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');
	    
	    foreach($permitted as $type) {
		    if($type == $file['type']) {
			    $upload_error = false;
			    break;
		    }
	    }
	    
	    //REMOVE old image
	    if(!$upload_error && !$init_creation){
	    	@unlink($file_path.$file_old);
		}

    	//MOVE file
    	if(!$upload_error){
    		$upload_error = !@move_uploaded_file($file['tmp_name'], $file_path.$file_name);
    	}
    
    	//RESULT data
    	$result['error'] = $upload_error;
    	$result['file_name'] = $file_name;
    
    	return $result;
    }
}

?>
