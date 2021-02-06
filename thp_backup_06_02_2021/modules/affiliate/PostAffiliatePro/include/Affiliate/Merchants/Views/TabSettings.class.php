<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================



//--------------------------------------------------------------------------
// SettingsTab
//  - specifies an interface for all tabs in settings
//  - ALL TABS HAVE TO EXTEND THIS CLASS
//--------------------------------------------------------------------------
class Affiliate_Merchants_Views_TabSettings
{
	var $name;		// id of the tab
	var $link;		// link to the tab
	var $template;	// template for the tab
	var $icon;      // icon of tab

	function setAttributes($name, $link, $template, $icon='') {
		$this->name = $name;
		$this->link = $link;
		$this->template = $template;
		$this->icon = $icon;
	}

	// processes data before saving
	function process($data) {}

	// processes data before saving (DEMO MODE)
	// - default behaviour is same as process()
	function demoProcess($data)
	{
		return $this->process($data);
	}

	// occurs before fetching template for tab
	// - e.g. can be used for loading data to combo boxes
	// $parent is reference to Settings class
	// returns temporarily fetched template
	function show($parent)
	{
		return $parent->temporaryFetch($this->template);
	}
}

?>