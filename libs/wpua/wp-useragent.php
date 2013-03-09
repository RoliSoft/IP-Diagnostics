<?php
/*
Plugin Name: WP-UserAgent
Plugin URI: http://kyleabaker.com/goodies/coding/wp-useragent/
Description: A simple User-Agent detection plugin that lets you easily insert icons and/or textual web browser and operating system details with each comment.
Version: 1.0.1
Author: Kyle Baker
Author URI: http://kyleabaker.com/
//Author: Fernando Briano
//Author URI: http://picandocodigo.net
*/

/* Copyright 2008-2012  Kyle Baker  (email: kyleabaker@gmail.com)
	//Copyright 2008  Fernando Briano  (email : transformers.es@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Include our main UA detection functions
include('wp-useragent-detect-device.php');
include('wp-useragent-detect-os.php');
include('wp-useragent-detect-platform.php');
include('wp-useragent-detect-trackback.php');
include('wp-useragent-detect-webbrowser.php');
include('wp-useragent-detect-webbrowser-version.php');

?>
