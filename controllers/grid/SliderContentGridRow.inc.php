<?php

/**
 * @file plugins/generic/sliderContent/classes/SliderContentGridRow.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SliderContentGridRow
 *
 */

import('lib.pkp.classes.controllers.grid.GridRow');

class SliderContentGridRow extends GridRow {
	/**
	 * Constructor
	 */
	function SliderContentGridRow() {
		parent::GridRow();
	}

	//
	// Overridden template methods
	//
	/**
	 * @copydoc GridRow::initialize()
	 */
	function initialize($request, $template = null) {

		parent::initialize($request, $template);

		$sliderContentId = $this->getId();
		if (!empty($sliderContentId)) {
			$router = $request->getRouter();

			// Create the "edit field" action
			import('lib.pkp.classes.linkAction.request.AjaxModal');
			$this->addAction(
				new LinkAction(
					'editSliderContent',
					new AjaxModal(
						$router->url($request, null, null, 'editSliderContent', null, array('sliderContentId' => $sliderContentId)),
						__('grid.action.edit'),
						'modal_edit',
						true),
					__('grid.action.edit'),
					null,
					__('plugins.generic.sliderContent.tooltip.editSliderContent')
				)
			);

			// Create the "delete field" action
			import('lib.pkp.classes.linkAction.request.RemoteActionConfirmationModal');
			$this->addAction(
				new LinkAction(
					'delete',
					new RemoteActionConfirmationModal(
						__('common.confirmDelete'),
						__('grid.action.delete'),
						$router->url($request, null, null, 'delete', null, array('sliderContentId' => $sliderContentId)), 'modal_delete'
					),
					__('grid.action.delete'),
					'delete'
				)
			);
		}
	}
}

?>
