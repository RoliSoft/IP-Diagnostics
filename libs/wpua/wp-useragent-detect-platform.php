<?php

// Detect Platform (check for Device, then OS if no device is found, else return null)
function detect_platform()
{
	if(strlen($detected_platform=detect_device()) > 0)
	{
		return $detected_platform;
	}
	elseif(strlen($detected_platform=detect_os()) > 0)
	{
		return $detected_platform;
	}
	else
	{
		return '';
	}
	
	return '<img src="/browser/browsers/'.$code.'.png" title="'.$title.'" class="i1" /> ';
}

?>
