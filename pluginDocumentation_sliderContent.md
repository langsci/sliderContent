Key data
============

- name of the plugin: Slider Content Plugin
- author: Carola Fanselow
- current version: 1.0.0.0
- tested on OMP version: 1.2
- github link: https://github.com/langsci/sliderContent.git
- community plugin: yes
- date: 2016/05/12

Description
============

This plugin allows to create entries to a table 'langsci_slider_content'. The entries have a name and a content field. They can be ordered arbitrarily. The table 'langsci_slider_content' is used by the Home Plugin to get content for the slider on the home page. The path for creating new content is %press%/sliderContent.

 
Implementation
================

Hooks
-----
- used hooks: 2

		LoadHandler
		LoadComponentHandler

New pages
------
- new pages: 1

		[press]/sliderContent

Templates
---------
- templates that substitute other templates: 0
- templates that are modified with template hooks: 0
- new/additional templates: 2

		sliderContent.tpl
		editSliderContentForm.tpl

Database access, server access
-----------------------------
- reading access to OMP tables: 0
- writing access to OMP tables: 0
- new tables: 1

		langsci_slider_content

- nonrecurring server access: yes

		creating database table during installation (file: schema.xml)

- recurring server access: no
 
Classes, plugins, external software
-----------------------
- OMP classes used (php): 11
	
		GenericPlugin
		Handler
		DAO
		DataObject
		GridHandler
		GridRow
		GridCellProvider
		Form
		LinkAction
		OrderGridItemsFeature
		FileManager

- OMP classes used (js, jqeury, ajax): 1

		AjaxFormHandler

- necessary plugins: 0
- optional plugins: 0
- use of external software: no
- file upload: no
 
Metrics
--------
- number of files 18
- number of lines: 1175

Settings
--------
- settings: no

Plugin category
----------
- plugin category: generic

Other
=============
- does using the plugin require special (background)-knowledge?: no
- access restrictions: access restricted to admins and managers
- adds css: yes


