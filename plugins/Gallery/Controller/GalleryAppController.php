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
 * @copyright 2012 Duale Hochschule Baden-W�rttemberg Mannheim
 * @author Alexander M�ller & Fabian Kajzar
 * 
 * @description Mother container for gallery
 */

class GalleryAppController extends AppController {

	var $components = array('ContentValueManager');
	
	public $uses = array('Plugin');
	
	protected function getPluginId(){
		$foodMenuPlugin = $this->Plugin->findByName($this->plugin);
		$pluginId = $foodMenuPlugin['Plugin']['id'];
		return $pluginId;
	}
	
}