<?php 

/**
 * @file plugins/generic/sliderContent/SliderContentHandler.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING. 
 *
 * @class SliderContentHandler
 *
 */

import('classes.handler.Handler');

class SliderContentHandler extends Handler {	

	function SliderContentHandler() {
		parent::Handler();
	}

	function index($args, $request) {

		$authorizedUserGroups = array(ROLE_ID_SITE_ADMIN,ROLE_ID_MANAGER);
		$userRoles = $this->getAuthorizedContextObject(ASSOC_TYPE_USER_ROLES);

		// redirect to index page if user does not have the rights
		$user = $request->getUser();
		if (!array_intersect($authorizedUserGroups, $userRoles)) {
			$request->redirect(null, 'index');
		}

		$press = $request->getPress();
		$dispatcher = $request->getDispatcher();
		$sliderContentPlugin = PluginRegistry::getPlugin('generic', SLIDERCONTENT_PLUGIN_NAME);

		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pageTitle', 'plugins.generic.title.sliderContent');
		$templateMgr->assign('userRoles', $userRoles); // necessary for the backend sidenavi to appear
		$templateMgr->assign('baseUrl',$request->getBaseUrl());
		$templateMgr->display($sliderContentPlugin->getTemplatePath().'sliderContent.tpl');
	}
}
?>
