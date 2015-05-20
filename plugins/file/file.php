<?php
// Copyright (c) 2013-2015 Datenstrom, http://datenstrom.se
// This file may be used and distributed under the terms of the public license.

// File plugin
class YellowFile
{
	const Version = "0.5.2";
	var $yellow;			//access to API
	
	// Handle initialisation
	function onLoad($yellow)
	{
		$this->yellow = $yellow;
	}
	
	// Handle page content parsing of custom block
	function onParseContentBlock($page, $name, $text, $typeShortcut)
	{
		$output = NULL;
		if($name=="file" && $typeShortcut)
		{
			list($fileName) = $this->yellow->toolbox->getTextArgs($text);
			$location = $this->yellow->lookup->findLocationFromFile($fileName);
			$content = $this->yellow->pages->find($location);
			if($content)
			{
				$page->setLastModified($content->getModified());
				$output = $content->getContent();
			} else {
				$page->error(500, "File '$fileName' does not exist!");
			}
		}
		return $output;
	}
}

$yellow->plugins->register("file", "YellowFile", YellowFile::Version);
?>