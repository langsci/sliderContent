<?php

/**
 * @file plugins/generic/sliderContent/classes/SliderContentForm.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SliderContentForm
 *
 */

import('lib.pkp.classes.form.Form');

class SliderContentForm extends Form {

	var $contextId;

	var $sliderContentId;

	var $plugin;

	/**
	 * Constructor
	 */
	function SliderContentForm($sliderContentPlugin, $contextId, $sliderContentId = null) {

		parent::Form($sliderContentPlugin->getTemplatePath() . 'editSliderContentForm.tpl');

		$this->contextId = $contextId;
		$this->sliderContentId = $sliderContentId;
		$this->plugin = $sliderContentPlugin;

		// Add form checks
		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidator($this,'name','required', 'plugins.generic.sliderContent.nameRequired'));
	}

	/**
	 * Initialize form data 
	 */
	function initData() {

		if ($this->sliderContentId) {
			$sliderContentDao = new SliderContentDAO();
			
			$sliderContent = $sliderContentDao->getById($this->sliderContentId, $this->contextId);
			$this->setData('name', $sliderContent->getName());
			$this->setData('content', $sliderContent->getContent());			
		}
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(array('name','content'));
	}

	/**
	 * @see Form::fetch
	 */
	function fetch($request) {

		$templateMgr = TemplateManager::getManager();
		$templateMgr->assign('sliderContentId', $this->sliderContentId);
		$templateMgr->assign('baseUrl',$request->getBaseUrl());

		if (!$this->sliderContentId) {
				$this->setData('content',
"<img src='#' alt=''>

<h3>Title</h3>

<p>Text
<a href='#'>Read more ...</a>
</p>");
			}

		return parent::fetch($request);
	}

	/**
	 * Save form values into the database
	 */
	function execute() {

		$sliderContentDao = new SliderContentDAO();
		if ($this->sliderContentId) {
			// Load and update an existing content
			$sliderContent = $sliderContentDao->getById($this->sliderContentId, $this->contextId);
		} else {
			// Create a new item
			$sliderContent = $sliderContentDao->newDataObject();
			$sliderContent->setContextId($this->contextId);
		}

		$sliderContent->setName($this->getData('name'));
		$sliderContent->setContent($this->getData('content'));
		if ($this->sliderContentId) {
			$sliderContent->setSequence($sliderContent->getData('sequence'));
			$sliderContentDao->updateObject($sliderContent);
		} else {
			$sliderContent->setSequence($sliderContentDao->getMaxSequence($this->contextId)+1);
			$sliderContentDao->insertObject($sliderContent);
		}
	}
}

?>
