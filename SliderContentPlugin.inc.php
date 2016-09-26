<?php

/**
 * @file plugins/generic/sliderContent/SliderContentPlugin.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING. 
 *
 * @class SliderContentPlugin
 *
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class SliderContentPlugin extends GenericPlugin {

	function register($category, $path) {

		if (parent::register($category, $path)) {
			$this->addLocaleData();
			
			// register manager.xml as OMP does not do it itself
			import('lib.pkp.classes.file.FileManager');
			$fileManager = new FileManager();
			$locale = AppLocale::getLocale();
			$managerPath = 'lib/pkp/locale/en_US/manager.xml';
			if ($fileManager->fileExists($managerPath)) {
				AppLocale::registerLocaleFile($locale,$managerPath, false);
			}

			// register hooks
			if ($this->getEnabled()) {
				
				HookRegistry::register('LoadHandler', array(&$this, 'handleLoadRequest'));
				HookRegistry::register('LoadComponentHandler', array($this, 'setupGridHandler'));
				HookRegistry::register('Templates::Management::Settings::website', array($this, 'callbackShowWebsiteSettingsTabs'));
			}
			return true;
		}
		return false;

	}
	
	/**
	 * Extend the website settings tabs to include slider contents
	 * @param $hookName string The name of the invoked hook
	 * @param $args array Hook parameters
	 * @return boolean Hook handling status
	 */
	function callbackShowWebsiteSettingsTabs($hookName, $args) {
		$output =& $args[2];
		$request =& Registry::get('request');
		$dispatcher = $request->getDispatcher();

		// Add a new tab for slider contents
		$output .= '<li><a name="sliderContent" href="' . $dispatcher->url($request, ROUTE_COMPONENT, null, 'plugins.generic.sliderContent.controllers.grid.SliderContentGridHandler', 'index') . '">' . __('plugins.generic.sliderContent.sliderContent') . '</a></li>';
		
		// Permit other plugins to continue interacting with this hook
		return false;
	}

	function handleLoadRequest($hookName, $args) {

		$request = $this->getRequest();
		$press = $request -> getPress();

		// get url path components
		$pageUrl = $args[0];
		$opUrl = $args[1];

		if ($pageUrl=="sliderContent" && $opUrl=="index") {

			define('HANDLER_CLASS', 'SliderContentHandler');
			define('SLIDERCONTENT_PLUGIN_NAME', $this->getName());
			$this->import('SliderContentHandler');

			return true;
		}
		return false;
	}

	/**
	 * Permit requests to the grid handler
	 * @param $hookName string The name of the hook being invoked
	 * @param $args array The parameters to the invoked hook
	 */
	function setupGridHandler($hookName, $params) {

		$component =& $params[0];

		if ($component == 'plugins.generic.sliderContent.controllers.grid.SliderContentGridHandler') {
			// Allow the users grid handler to get the plugin object
			import($component);
			SliderContentGridHandler::setPlugin($this);
			return true;
		}
		return false;
	}

	function getDisplayName() {
		return __('plugins.generic.sliderContent.displayName');
	}

	function getDescription() {
		return __('plugins.generic.sliderContent.description');
	}

	function getTemplatePath() {
		return parent::getTemplatePath() . 'templates/';
	}

	function getInstallSchemaFile() {
		return $this->getPluginPath() . '/schema.xml';
	}
}

?>
