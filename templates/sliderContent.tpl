{**
 * plugins/generic/sliderContent/templates/sliderContent.tpl
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Slider content plugin -- displays the SliderContentGrid.
 *}

{url|assign:sliderContentGridUrl router=$smarty.const.ROUTE_COMPONENT component="plugins.generic.sliderContent.controllers.grid.SliderContentGridHandler" op="fetchGrid" escape=false}
{load_url_in_div id="sliderContentGridContainer" url=$sliderContentGridUrl}

