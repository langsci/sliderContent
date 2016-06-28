{**
 * plugins/generic/sliderContent/templates/editSliderContentForm.tpl
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 *}

<link rel="stylesheet" href="{$baseUrl}/plugins/generic/sliderContent/css/sliderContent.css" type="text/css" />

<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#sliderContentForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

{url|assign:actionUrl router=$smarty.const.ROUTE_COMPONENT component="plugins.generic.sliderContent.controllers.grid.SliderContentGridHandler" op="updateSliderContent"  escape=false}

<form class="pkp_form" id="sliderContentForm" method="post" action="{$actionUrl}">

	{if $sliderContentId}
		<input type="hidden" name="sliderContentId" value="{$sliderContentId|escape}" />
	{/if}

	{fbvFormArea id="sliderContentFormArea" class="border"}

		{fbvFormSection}
			{fbvElement type="text" label="plugins.generic.sliderContent.name" id="name" required="true" value=$name maxlength="50" inline=true multilingual=false size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{fbvFormSection}
			{fbvElement type="textarea" label="plugins.generic.sliderContent.content" id="content" value=$content inline=true multilingual=false size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{fbvFormSection class="formButtons"}
			{fbvElement type="submit" class="submitFormButton" id="submitFormButton" label="common.save"}
		{/fbvFormSection}

	{/fbvFormArea}


</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
