{**
 * plugins/generic/sliderContent/templates/sliderContent.tpl
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 *}

<link rel="stylesheet" href="{$baseUrl}/plugins/generic/sliderContent/css/sliderContent.css" type="text/css" />

{strip}
	{include file="common/header.tpl"}
{/strip}

<p>{translate key="plugins.generic.sliderContent.intro"}</p>

{url|assign:sliderContentGridUrl router=$smarty.const.ROUTE_COMPONENT component="plugins.generic.sliderContent.controllers.grid.SliderContentGridHandler" op="fetchGrid" escape=false}

<div class="slider-content-container">
	{load_url_in_div id="sliderContentGridContainer" url=$sliderContentGridUrl}
</div>

{strip}
	{include file="common/footer.tpl"}
{/strip}
