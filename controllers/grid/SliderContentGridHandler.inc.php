<?php

/**
 * @file plugins/generic/sliderContent/classes/SliderContentGridHandler.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SliderContentGridHandler
 *
 */

import('lib.pkp.classes.controllers.grid.GridHandler');
import('plugins.generic.sliderContent.controllers.grid.SliderContentGridRow');
import('plugins.generic.sliderContent.controllers.grid.SliderContentGridCellProvider');
import('plugins.generic.sliderContent.classes.SliderContent');
import('plugins.generic.sliderContent.classes.SliderContentDAO');

class SliderContentGridHandler extends GridHandler {

	static $plugin;

	static function setPlugin($plugin) {
		self::$plugin = $plugin;
	}

	/**
	 * Constructor
	 */
	function SliderContentGridHandler() {

		parent::GridHandler();
		$this->addRoleAssignment(
			array(ROLE_ID_MANAGER),
			array('addSliderContent', 'editSliderContent', 'updateSliderContent', 'delete')
		);
	} 

	//
	// Overridden template methods
	//
	/**
	 * @copydoc Gridhandler::initialize()
	 */
	function initialize($request, $args = null) {

		parent::initialize($request);
		$context = $request->getContext();

		// Set the grid details.
		$this->setTitle('plugins.generic.sliderContent.grid.title');
		$this->setEmptyRowText('plugins.generic.sliderContent.noneCreated');

		$sliderContentDao = new SliderContentDao();
		$this->setGridDataElements($sliderContentDao->getByContextId($context->getId()));

		// Add grid-level actions
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		$this->addAction(
			new LinkAction(
				'addSliderContent',
				new AjaxModal(
					$router->url($request, null, null, 'addSliderContent'),
					__('plugins.generic.sliderContent.addSliderContent'),
					'modal_add_item'
				),
				__('plugins.generic.sliderContent.addSliderContent'),
				null,
				__('plugins.generic.sliderContent.tooltip.addSliderContent')
			)
		);

		// Columns
		$cellProvider = new SliderContentGridCellProvider();

		$this->addColumn(new GridColumn(
			'name',
			'plugins.generic.sliderContent.name',
			null,
			'controllers/grid/gridCell.tpl',
			$cellProvider
		));
	}

	//
	// Overridden methods from GridHandler
	//

	function initFeatures($request, $args) {
		import('lib.pkp.classes.controllers.grid.feature.OrderGridItemsFeature');
		return array(new OrderGridItemsFeature());
	}


	/**
	 * @copydoc GridHandler::getDataElementSequence()
	 */
	function getDataElementSequence($gridDataElement) {
		return $gridDataElement->getSequence();		
	}

	/**
	 * @copydoc GridHandler::setDataElementSequence()
	 */
	function setDataElementSequence($request, $rowId, $gridDataElement, $newSequence) {

		$press = $request->getPress();
		$press->getId();
	
		$sliderContentDao = new SliderContentDAO();
		$sliderContent = $sliderContentDao->getById($rowId, $press->getId());

		$sliderContent->setSequence($newSequence);
		$sliderContentDao->updateObject($sliderContent);
	}


	/**
	 * @copydoc Gridhandler::getRowInstance()
	 */
	function getRowInstance() {
		return new SliderContentGridRow();
	}

	/**
	 * An action to add a new user
	 * @param $args array Arguments to the request
	 * @param $request PKPRequest Request object
	 */
	function addSliderContent($args, $request) {

		return $this->editSliderContent($args, $request);
	}

	/**
	 * An action to edit a user
	 * @param $args array Arguments to the request
	 * @param $request PKPRequest Request object
	 * @return string Serialized JSON object
	 */
	function editSliderContent($args, $request) {

		$sliderContentId = $request->getUserVar('sliderContentId');
		$context = $request->getContext();
		$this->setupTemplate($request);

		// Create and present the edit form
		import('plugins.generic.sliderContent.controllers.grid.form.SliderContentForm');
		$sliderContentPlugin = self::$plugin;

		$sliderContentForm = new SliderContentForm(self::$plugin, $context->getId(), $sliderContentId);
		$sliderContentForm->initData();

		$json = new JSONMessage(true, $sliderContentForm->fetch($request));

		return $json->getString();
	}

	/**
	 * Update a user
	 * @param $args array
	 * @param $request PKPRequest
	 * @return string Serialized JSON object
	 */
	function updateSliderContent($args, $request) {

		$sliderContentId = $request->getUserVar('sliderContentId');
		$context = $request->getContext();
		$this->setupTemplate($request);

		// Create and populate the form
		import('plugins.generic.sliderContent.controllers.grid.form.SliderContentForm');
		$sliderContentPlugin = self::$plugin;
		$sliderContentForm = new SliderContentForm(self::$plugin, $context->getId(), $sliderContentId);
		$sliderContentForm->readInputData();

		// Check the results
		if ($sliderContentForm->validate()) {
			// Save the results
			$sliderContentForm->execute();
 			return DAO::getDataChangedEvent();
		} else {
			// Present any errors
			$json = new JSONMessage(true, $sliderContentForm->fetch($request));
			return $json->getString();
		}
	}

	/**                               
	 * @param $args array
	 * Delete a user
	 * @param $request PKPRequest
	 * @return string Serialized JSON object
	 */
	function delete($args, $request) {

		$sliderContentId = $request->getUserVar('sliderContentId');
		$context = $request->getContext();

		$sliderContentDao = new SliderContentDAO();
		$sliderContent = $sliderContentDao->getById($sliderContentId, $context->getId());

		$sliderContentDao->deleteObject($sliderContent);

		return DAO::getDataChangedEvent();
	}
}

?>
