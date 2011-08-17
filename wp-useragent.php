<?php
/*
Plugin Name: WP-UserAgent
Plugin URI: http://kyleabaker.com/goodies/coding/wp-useragent/
Description: A simple User-Agent detection plugin that lets you easily insert icons and/or textual web browser and operating system details with each comment.
Version: 0.10.6
Author: Kyle Baker
Author URI: http://kyleabaker.com/
//Author: Fernando Briano
//Author URI: http://picandocodigo.net
*/

/* Copyright 2008-2011  Kyle Baker  (email: kyleabaker@gmail.com)
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

//Detect webbrowser versions
function detect_browser_version($title){
	//fix for Opera's (and others) UA string changes in v10.00
	$start=$title;
	if(strtolower($title)==strtolower("Opera") && preg_match('/Version/i', $_SERVER['HTTP_USER_AGENT']))
		$start="Version";
	elseif(strtolower($title)==strtolower("Opera Mobi") && preg_match('/Version/i', $_SERVER['HTTP_USER_AGENT']))
		$start="Version";
	elseif(strtolower($title)==strtolower("Safari") && preg_match('/Version/i', $_SERVER['HTTP_USER_AGENT']))
		$start="Version";
	elseif(strtolower($title)==strtolower("Pre") && preg_match('/Version/i', $_SERVER['HTTP_USER_AGENT']))
		$start="Version";
	elseif(strtolower($title)==strtolower("Links"))
		$start="Links (";
	elseif(strtolower($title)==strtolower("UC Browser"))
		$start="UC Browse";

	//Grab the browser version if its present
	preg_match('/'.$start.'[\ |\/]?([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch);
	$version=$regmatch[1];

	//Return browser Title and Version, but first..some titles need to be changed
	if(strtolower($title)=="msie" && strtolower($version)=="7.0" && preg_match('/Trident\/4.0/i', $_SERVER['HTTP_USER_AGENT']))
		return " 8.0 (Compatibility Mode)"; //fix for IE8 quirky UA string with Compatibility Mode enabled
	elseif(strtolower($title)=="msie")
			return " ".$version;
	elseif(strtolower($title)=="multi-browser")
		return "Multi-Browser XP ".$version;
	elseif(strtolower($title)=="nf-browser")
		return "NetFront ".$version;
	elseif(strtolower($title)=="semc-browser")
		return "SEMC Browser ".$version;
	elseif(strtolower($title)=="ucweb")
		return "UC Browser ".$version;
	elseif(strtolower($title)=="up.browser" || strtolower($title)=="up.link")
		return "Openwave Mobile Browser ".$version;
	elseif(strtolower($title)=="chromeframe")
		return "Google Chrome Frame ".$version;
	elseif(strtolower($title)=="mozilladeveloperpreview")
		return "Mozilla Developer Preview ".$version;
	elseif(strtolower($title)=="multi-browser")
		return "Multi-Browser XP ".$version;
	elseif(strtolower($title)=="opera mobi")
		return "Opera Mobile ".$version;
	elseif(strtolower($title)=="osb-browser")
		return "Gtk+ WebCore ".$version;
	elseif(strtolower($title)=="tablet browser")
		return "MicroB ".$version;
	elseif(strtolower($title)=="tencenttraveler")
		return "TT Explorer ".$version;
	else
		return $title." ".$version;
}

//Detect webbrowsers
function detect_webbrowser(){
	$mobile=0;
	if(preg_match('/360se/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://se.360.cn/";
		$title="360Safe Explorer";
		$code="360se";
	}elseif(preg_match('/Abolimba/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.aborange.de/products/freeware/abolimba-multibrowser.php";
		$title="Abolimba";
		$code="abolimba";
	}elseif(preg_match('/ABrowse/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://abrowse.sourceforge.net/";
		$title=detect_browser_version("ABrowse");
		$code="abrowse";
	}elseif(preg_match('/Acoo\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.acoobrowser.com/";
		$title="Acoo ".detect_browser_version("Browser");
		$code="acoobrowser";
	}elseif(preg_match('/Amaya/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.w3.org/Amaya/";
		$title=detect_browser_version("Amaya");
		$code="amaya";
	}elseif(preg_match('/Amiga-AWeb/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://aweb.sunsite.dk/";
		$title="Amiga ".detect_browser_version("AWeb");
		$code="amiga-aweb";
	}elseif(preg_match('/America\ Online\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://downloads.channel.aol.com/browser";
		$title="America Online ".detect_browser_version("Browser");
		$code="aol";
	}elseif(preg_match('/AmigaVoyager/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://v3.vapor.com/voyager/";
		$title="Amiga ".detect_browser_version("Voyager");
		$code="amigavoyager";
	}elseif(preg_match('/AOL/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://downloads.channel.aol.com/browser";
		$title=detect_browser_version("AOL");
		$code="aol";
	}elseif(preg_match('/Arora/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://code.google.com/p/arora/";
		$title=detect_browser_version("Arora");
		$code="arora";
	}elseif(preg_match('/Avant\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.avantbrowser.com/";
		$title="Avant ".detect_browser_version("Browser");
		$code="avantbrowser";
	}elseif(preg_match('/Beonex/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.beonex.com/";
		$title=detect_browser_version("Beonex");
		$code="beonex";
	}elseif(preg_match('/BlackBerry/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.blackberry.com/";
		$title=detect_browser_version("BlackBerry");
		$code="blackberry";
	}elseif(preg_match('/Blackbird/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.blackbirdbrowser.com/";
		$title=detect_browser_version("Blackbird");
		$code="blackbird";
	}elseif(preg_match('/BlackHawk/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.netgate.sk/blackhawk/help/welcome-to-blackhawk-web-browser.html";
		$title=detect_browser_version("BlackHawk");
		$code="blackhawk";
	}elseif(preg_match('/Blazer/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Blazer_(web_browser)";
		$title=detect_browser_version("Blazer");
		$code="blazer";
	}elseif(preg_match('/Bolt/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.boltbrowser.com/";
		$title=detect_browser_version("Bolt");
		$code="bolt";
	}elseif(preg_match('/BonEcho/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/projects/minefield/";
		$title=detect_browser_version("BonEcho");
		$code="firefoxdevpre";
	}elseif(preg_match('/BrowseX/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://pdqi.com/browsex/";
		$title="BrowseX";
		$code="browsex";
	}elseif(preg_match('/Browzar/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.browzar.com/";
		$title=detect_browser_version("Browzar");
		$code="browzar";
	}elseif(preg_match('/Bunjalloo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://code.google.com/p/quirkysoft/";
		$title=detect_browser_version("Bunjalloo");
		$code="bunjalloo";
	}elseif(preg_match('/Camino/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.caminobrowser.org/";
		$title=detect_browser_version("Camino");
		$code="camino";
	}elseif(preg_match('/Cayman\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.caymanbrowser.com/";
		$title="Cayman ".detect_browser_version("Browser");
		$code="caymanbrowser";
	}elseif(preg_match('/Cheshire/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://downloads.channel.aol.com/browser";
		$title=detect_browser_version("Cheshire");
		$code="aol";
	}elseif(preg_match('/Chimera/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.chimera.org/";
		$title=detect_browser_version("Chimera");
		$code="null";
	}elseif(preg_match('/chromeframe/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://code.google.com/chrome/chromeframe/";
		$title=detect_browser_version("chromeframe");
		$code="google";
	}elseif(preg_match('/ChromePlus/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.chromeplus.org/";
		$title=detect_browser_version("ChromePlus");
		$code="chromeplus";
	}elseif(preg_match('/Chrome/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/Iron/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.srware.net/";
		$title="SRWare ".detect_browser_version("Iron");
		$code="srwareiron";
	}elseif(preg_match('/Chromium/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.chromium.org/";
		$title=detect_browser_version("Chromium");
		$code="chromium";
	}elseif(preg_match('/CometBird/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.cometbird.com/";
		$title=detect_browser_version("CometBird");
		$code="cometbird";
	}elseif(preg_match('/Comodo_Dragon/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.comodo.com/home/internet-security/browser.php";
		$title="Comodo ".detect_browser_version("Dragon");
		$code="comodo-dragon";
	}elseif(preg_match('/Conkeror/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.conkeror.org/";
		$title=detect_browser_version("Conkeror");
		$code="conkeror";
	}elseif(preg_match('/Crazy\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.crazybrowser.com/";
		$title="Crazy ".detect_browser_version("Browser");
		$code="crazybrowser";
	}elseif(preg_match('/Cruz/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.cruzapp.com/";
		$title=detect_browser_version("Cruz");
		$code="cruz";
	}elseif(preg_match('/Cyberdog/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.cyberdog.org/about/cyberdog/cyberbrowse.html";
		$title=detect_browser_version("Cyberdog");
		$code="cyberdog";
	}elseif(preg_match('/Deepnet\ Explorer/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.deepnetexplorer.com/";
		$title=detect_browser_version("Deepnet Explorer");
		$code="deepnetexplorer";
	}elseif(preg_match('/Demeter/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.hurrikenux.com/Demeter/";
		$title=detect_browser_version("Demeter");
		$code="demeter";
	}elseif(preg_match('/DeskBrowse/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.deskbrowse.org/";
		$title=detect_browser_version("DeskBrowse");
		$code="deskbrowse";
	}elseif(preg_match('/Dillo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.dillo.org/";
		$title=detect_browser_version("Dillo");
		$code="dillo";
	}elseif(preg_match('/DoCoMo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.nttdocomo.com/";
		$title=detect_browser_version("DoCoMo");
		$code="null";
	}elseif(preg_match('/DocZilla/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.doczilla.com/";
		$title=detect_browser_version("DocZilla");
		$code="doczilla";
	}elseif(preg_match('/Dolfin/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.samsungmobile.com/";
		$title=detect_browser_version("Dolfin");
		$code="samsung";
	}elseif(preg_match('/Dooble/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://dooble.sourceforge.net/";
		$title=detect_browser_version("Dooble");
		$code="dooble";
	}elseif(preg_match('/Doris/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.anygraaf.fi/browser/indexe.htm";
		$title=detect_browser_version("Doris");
		$code="doris";
	}elseif(preg_match('/Edbrowse/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://edbrowse.sourceforge.net/";
		$title=detect_browser_version("Edbrowse");
		$code="edbrowse";
	}elseif(preg_match('/Elinks/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://elinks.or.cz/";
		$title=detect_browser_version("Elinks");
		$code="elinks";
	}elseif(preg_match('/Element\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.elementsoftware.co.uk/software/elementbrowser/";
		$title="Element ".detect_browser_version("Browser");
		$code="elementbrowser";
	}elseif(preg_match('/Enigma\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Enigma_Browser";
		$title="Enigma ".detect_browser_version("Browser");
		$code="enigmabrowser";
	}elseif(preg_match('/Epic/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.epicbrowser.com/";
		$title=detect_browser_version("Epic");
		$code="epicbrowser";
	}elseif(preg_match('/Epiphany/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://gnome.org/projects/epiphany/";
		$title=detect_browser_version("Epiphany");
		$code="epiphany";
	}elseif(preg_match('/Escape/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.espial.com/products/evo_browser/";
		$title="Espial TV Browser - ".detect_browser_version("Escape");
		$code="espialtvbrowser";
	}elseif(preg_match('/Fennec/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="https://wiki.mozilla.org/Fennec";
		$title=detect_browser_version("Fennec");
		$code="fennec";
	}elseif(preg_match('/Firebird/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://seb.mozdev.org/firebird/";
		$title=detect_browser_version("Firebird");
		$code="firebird";
	}elseif(preg_match('/Flock/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.flock.com/";
		$title=detect_browser_version("Flock");
		$code="flock";
	}elseif(preg_match('/Fluid/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.fluidapp.com/";
		$title=detect_browser_version("Fluid");
		$code="fluid";
	}elseif(preg_match('/Galaxy/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.traos.org/";
		$title=detect_browser_version("Galaxy");
		$code="galaxy";
	}elseif(preg_match('/Galeon/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://galeon.sourceforge.net/";
		$title=detect_browser_version("Galeon");
		$code="galeon";
	}elseif(preg_match('/GlobalMojo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.globalmojo.com/";
		$title=detect_browser_version("GlobalMojo");
		$code="globalmojo";
	}elseif(preg_match('/GoBrowser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.gobrowser.cn/";
		$title="GO ".detect_browser_version("Browser");
		$code="gobrowser";
	}elseif(preg_match('/Google\ Wireless\ Transcoder/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://google.com/gwt/n";
		$title="Google Wireless Transcoder";
		$code="google";
	}elseif(preg_match('/GoSurf/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://gosurfbrowser.com/?ln=en";
		$title=detect_browser_version("GoSurf");
		$code="gosurf";
	}elseif(preg_match('/GranParadiso/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/";
		$title=detect_browser_version("GranParadiso");
		$code="firefoxdevpre";
	}elseif(preg_match('/GreenBrowser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.morequick.com/";
		$title=detect_browser_version("GreenBrowser");
		$code="greenbrowser";
	}elseif(preg_match('/Hana/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.alloutsoftware.com/";
		$title=detect_browser_version("Hana");
		$code="hana";
	}elseif(preg_match('/HotJava/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://java.sun.com/products/archive/hotjava/";
		$title=detect_browser_version("HotJava");
		$code="hotjava";
	}elseif(preg_match('/Hv3/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://tkhtml.tcl.tk/hv3.html";
		$title=detect_browser_version("Hv3");
		$code="hv3";
	}elseif(preg_match('/Hydra\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.hydrabrowser.com/";
		$title="Hydra Browser";
		$code="hydrabrowser";
	}elseif(preg_match('/Iris/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.torchmobile.com/";
		$title=detect_browser_version("Iris");
		$code="iris";
	}elseif(preg_match('/IBM\ WebExplorer/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.networking.ibm.com/WebExplorer/";
		$title="IBM ".detect_browser_version("WebExplorer");
		$code="ibmwebexplorer";
	}elseif(preg_match('/IBrowse/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.ibrowse-dev.net/";
		$title=detect_browser_version("IBrowse");
		$code="ibrowse";
	}elseif(preg_match('/iCab/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.icab.de/";
		$title=detect_browser_version("iCab");
		$code="icab";
	}elseif(preg_match('/Ice Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.icesoft.com/products/icebrowser.html";
		$title=detect_browser_version("Ice Browser");
		$code="icebrowser";
	}elseif(preg_match('/Iceape/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://packages.debian.org/iceape";
		$title=detect_browser_version("Iceape");
		$code="iceape";
	}elseif(preg_match('/IceCat/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://gnuzilla.gnu.org/";
		$title="GNU ".detect_browser_version("IceCat");
		$code="icecat";
	}elseif(preg_match('/IceWeasel/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.geticeweasel.org/";
		$title=detect_browser_version("IceWeasel");
		$code="iceweasel";
	}elseif(preg_match('/IEMobile/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.microsoft.com/windowsmobile/en-us/downloads/microsoft/internet-explorer-mobile.mspx";
		$title=detect_browser_version("IEMobile");
		$code="msie-mobile";
	}elseif(preg_match('/iNet\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://alexanderjbeston.wordpress.com/";
		$title="iNet ".detect_browser_version("Browser");
		$code="null";
	}elseif(preg_match('/iRider/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/IRider";
		$title=detect_browser_version("iRider");
		$code="irider";
	}elseif(preg_match('/Iron/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.srware.net/en/software_srware_iron.php";
		$title=detect_browser_version("Iron");
		$code="iron";
	}elseif(preg_match('/InternetSurfboard/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://inetsurfboard.sourceforge.net/";
		$title=detect_browser_version("InternetSurfboard");
		$code="internetsurfboard";
	}elseif(preg_match('/Jasmine/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.samsungmobile.com/";
		$title=detect_browser_version("Jasmine");
		$code="samsung";
	}elseif(preg_match('/K-Meleon/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://kmeleon.sourceforge.net/";
		$title=detect_browser_version("K-Meleon");
		$code="kmeleon";
	}elseif(preg_match('/K-Ninja/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://k-ninja-samurai.en.softonic.com/";
		$title=detect_browser_version("K-Ninja");
		$code="kninja";
	}elseif(preg_match('/Kapiko/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://ufoxlab.googlepages.com/cooperation";
		$title=detect_browser_version("Kapiko");
		$code="kapiko";
	}elseif(preg_match('/Kazehakase/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://kazehakase.sourceforge.jp/";
		$title=detect_browser_version("Kazehakase");
		$code="kazehakase";
	}elseif(preg_match('/Strata/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.kirix.com/";
		$title="Kirix ".detect_browser_version("Strata");
		$code="kirix-strata";
	}elseif(preg_match('/KKman/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.kkman.com.tw/";
		$title=detect_browser_version("KKman");
		$code="kkman";
	}elseif(preg_match('/KMail/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://kontact.kde.org/kmail/";
		$title=detect_browser_version("KMail");
		$code="kmail";
	}elseif(preg_match('/KMLite/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/K-Meleon";
		$title=detect_browser_version("KMLite");
		$code="kmeleon";
	}elseif(preg_match('/Konqueror/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://konqueror.kde.org/";
		$title=detect_browser_version("Konqueror");
		$code="konqueror";
	}elseif(preg_match('/LBrowser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://wiki.freespire.org/index.php/Web_Browser";
		$title=detect_browser_version("LBrowser");
		$code="lbrowser";
	}elseif(preg_match('/LeechCraft/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://leechcraft.org/";
		$title="LeechCraft";
		$code="null";
	}elseif(preg_match('/Links/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://links.sourceforge.net/";
		$title=detect_browser_version("Links");
		$code="links";
	}elseif(preg_match('/Lobo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.lobobrowser.org/";
		$title=detect_browser_version("Lobo");
		$code="lobo";
	}elseif(preg_match('/lolifox/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.lolifox.com/";
		$title=detect_browser_version("lolifox");
		$code="lolifox";
	}elseif(preg_match('/Lorentz/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://news.softpedia.com/news/Firefox-Codenamed-Lorentz-Drops-in-March-2010-130855.shtml";
		$title=detect_browser_version("Lorentz");
		$code="firefoxdevpre";
	}elseif(preg_match('/Lunascape/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.lunascape.tv";
		$title=detect_browser_version("Lunascape");
		$code="lunascape";
	}elseif(preg_match('/Lynx/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://lynx.browser.org/";
		$title=detect_browser_version("Lynx");
		$code="lynx";
	}elseif(preg_match('/Madfox/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Madfox";
		$title=detect_browser_version("Madfox");
		$code="madfox";
	}elseif(preg_match('/Maemo\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://maemo.nokia.com/features/maemo-browser/";
		$title=detect_browser_version("Maemo Browser");
		$code="maemo";
	}elseif(preg_match('/Maxthon/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.maxthon.com/";
		$title=detect_browser_version("Maxthon");
		$code="maxthon";
	}elseif(preg_match('/\ MIB\//i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.motorola.com/content.jsp?globalObjectId=1827-4343";
		$title=detect_browser_version("MIB");
		$code="mib";
	}elseif(preg_match('/Tablet\ browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://browser.garage.maemo.org/";
		$title=detect_browser_version("Tablet browser");
		$code="microb";
	}elseif(preg_match('/Midori/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.twotoasts.de/index.php?/pages/midori_summary.html";
		$title=detect_browser_version("Midori");
		$code="midori";
	}elseif(preg_match('/Minefield/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/projects/minefield/";
		$title=detect_browser_version("Minefield");
		$code="minefield";
	}elseif(preg_match('/Minimo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www-archive.mozilla.org/projects/minimo/";
		$title=detect_browser_version("Minimo");
		$code="minimo";
	}elseif(preg_match('/Mosaic/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Mosaic_(web_browser)";
		$title=detect_browser_version("Mosaic");
		$code="mosaic";
	}elseif(preg_match('/MozillaDeveloperPreview/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/projects/devpreview/releasenotes/";
		$title=detect_browser_version("MozillaDeveloperPreview");
		$code="firefoxdevpre";
	}elseif(preg_match('/Multi-Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.multibrowser.de/";
		$title=detect_browser_version("Multi-Browser");
		$code="multi-browserxp";
	}elseif(preg_match('/MultiZilla/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://multizilla.mozdev.org/";
		$title=detect_browser_version("MultiZilla");
		$code="mozilla";
	}elseif(preg_match('/myibrow/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/My\ Internet\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://myinternetbrowser.webove-stranky.org/";
		$title=detect_browser_version("myibrow");
		$code="my-internet-browser";
	}elseif(preg_match('/MyIE2/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.myie2.com/";
		$title=detect_browser_version("MyIE2");
		$code="myie2";
	}elseif(preg_match('/Namoroka/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="https://wiki.mozilla.org/Firefox/Namoroka";
		$title=detect_browser_version("Namoroka");
		$code="firefoxdevpre";
	}elseif(preg_match('/Navigator/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://netscape.aol.com/";
		$title="Netscape ".detect_browser_version("Navigator");
		$code="netscape";
	}elseif(preg_match('/NetBox/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.netgem.com/";
		$title=detect_browser_version("NetBox");
		$code="netbox";
	}elseif(preg_match('/NetCaptor/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.netcaptor.com/";
		$title=detect_browser_version("NetCaptor");
		$code="netcaptor";
	}elseif(preg_match('/NetFront/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.access-company.com/";
		$title=detect_browser_version("NetFront");
		$code="netfront";
	}elseif(preg_match('/NetNewsWire/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.newsgator.com/individuals/netnewswire/";
		$title=detect_browser_version("NetNewsWire");
		$code="netnewswire";
	}elseif(preg_match('/NetPositive/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/NetPositive";
		$title=detect_browser_version("NetPositive");
		$code="netpositive";
	}elseif(preg_match('/Netscape/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://netscape.aol.com/";
		$title=detect_browser_version("Netscape");
		$code="netscape";
	}elseif(preg_match('/NetSurf/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.netsurf-browser.org/";
		$title=detect_browser_version("NetSurf");
		$code="netsurf";
	}elseif(preg_match('/NF-Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.access-company.com/";
		$title=detect_browser_version("NF-Browser");
		$code="netfront";
	}elseif(preg_match('/Novarra-Vision/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.novarra.com/";
		$title="Novarra ".detect_browser_version("Vision");
		$code="novarra";
	}elseif(preg_match('/Obigo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Obigo_Browser";
		$title=detect_browser_version("Obigo");
		$code="obigo";
	}elseif(preg_match('/OffByOne/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.offbyone.com/";
		$title="Off By One";
		$code="offbyone";
	}elseif(preg_match('/OmniWeb/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.omnigroup.com/applications/omniweb/";
		$title=detect_browser_version("OmniWeb");
		$code="omniweb";
	}elseif(preg_match('/Opera Mini/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.opera.com/mini/";
		$title=detect_browser_version("Opera Mini");
		$code="opera-2";
	}elseif(preg_match('/Opera Mobi/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.opera.com/mobile/";
		$title=detect_browser_version("Opera Mobi");
		$code="opera-2";
	}elseif(preg_match('/Opera/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.opera.com/";
		$title=detect_browser_version("Opera");
		$code="opera-1";
		if(preg_match('/Version/i', $_SERVER['HTTP_USER_AGENT']))
			$code="opera-2";
	}elseif(preg_match('/Orca/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.orcabrowser.com/";
		$title=detect_browser_version("Orca");
		$code="orca";
	}elseif(preg_match('/Oregano/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Oregano_(web_browser)";
		$title=detect_browser_version("Oregano");
		$code="oregano";
	}elseif(preg_match('/Origyn\ Web\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sand-labs.org/owb";
		$title="Oregano Web Browser";
		$code="owb";
	}elseif(preg_match('/osb-browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://gtk-webcore.sourceforge.net/";
		$title=detect_browser_version("osb-browser");
		$code="null";
	}elseif(preg_match('/\ Pre\//i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.palm.com/us/products/phones/pre/index.html";
		$title="Palm ".detect_browser_version("Pre");
		$code="palmpre";
	}elseif(preg_match('/Palemoon/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.palemoon.org/";
		$title="Pale ".detect_browser_version("Moon");
		$code="palemoon";
	}elseif(preg_match('/Phaseout/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.phaseout.net/";
		$title="Phaseout";
		$code="phaseout";
	}elseif(preg_match('/Phoenix/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/projects/phoenix/phoenix-release-notes.html";
		$title=detect_browser_version("Phoenix");
		$code="phoenix";
	}elseif(preg_match('/Pogo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/AT%26T_Pogo";
		$title=detect_browser_version("Pogo");
		$code="pogo";
	}elseif(preg_match('/Polaris/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.infraware.co.kr/eng/01_product/product02.asp";
		$title=detect_browser_version("Polaris");
		$code="polaris";
	}elseif(preg_match('/Prism/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://prism.mozillalabs.com/";
		$title=detect_browser_version("Prism");
		$code="prism";
	}elseif(preg_match('/QtWeb\ Internet\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.qtweb.net/";
		$title="QtWeb Internet ".detect_browser_version("Browser");
		$code="qtwebinternetbrowser";
	}elseif(preg_match('/rekonq/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://rekonq.sourceforge.net/";
		$title="rekonq";
		$code="rekonq";
	}elseif(preg_match('/retawq/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://retawq.sourceforge.net/";
		$title=detect_browser_version("retawq");
		$code="terminal";
	}elseif(preg_match('/RockMelt/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.rockmelt.com/";
		$title=detect_browser_version("RockMelt");
		$code="rockmelt";
	}elseif(preg_match('/SaaYaa/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.saayaa.com/";
		$title="SaaYaa Explorer";
		$code="saayaa";
	}elseif(preg_match('/SeaMonkey/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.seamonkey-project.org/";
		$title=detect_browser_version("SeaMonkey");
		$code="seamonkey";
	}elseif(preg_match('/SEMC-Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sonyericsson.com/";
		$title=detect_browser_version("SEMC-Browser");
		$code="semcbrowser";
	}elseif(preg_match('/SEMC-java/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sonyericsson.com/";
		$title=detect_browser_version("SEMC-java");
		$code="semcbrowser";
	}elseif(preg_match('/Series60/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/Symbian/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Web_Browser_for_S60";
		$title="Nokia ".detect_browser_version("Series60");
		$code="s60";
	}elseif(preg_match('/S60/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/Symbian/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Web_Browser_for_S60";
		$title="Nokia ".detect_browser_version("S60");
		$code="s60";
	}elseif(preg_match('/SE\ /i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/MetaSr/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://ie.sogou.com/";
		$title="Sogou Explorer";
		$code="sogou";
	}elseif(preg_match('/Shiira/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.shiira.jp/en.php";
		$title=detect_browser_version("Shiira");
		$code="shiira";
	}elseif(preg_match('/Shiretoko/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/";
		$title=detect_browser_version("Shiretoko");
		$code="firefoxdevpre";
	}elseif(preg_match('/SiteKiosk/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sitekiosk.com/SiteKiosk/Default.aspx";
		$title=detect_browser_version("SiteKiosk");
		$code="sitekiosk";
	}elseif(preg_match('/SkipStone/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.muhri.net/skipstone/";
		$title=detect_browser_version("SkipStone");
		$code="skipstone";
	}elseif(preg_match('/Skyfire/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.skyfire.com/";
		$title=detect_browser_version("Skyfire");
		$code="skyfire";
	}elseif(preg_match('/Sleipnir/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.fenrir-inc.com/other/sleipnir/";
		$title=detect_browser_version("Sleipnir");
		$code="sleipnir";
	}elseif(preg_match('/SlimBrowser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.flashpeak.com/sbrowser/";
		$title=detect_browser_version("SlimBrowser");
		$code="slimbrowser";
	}elseif(preg_match('/Songbird/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.getsongbird.com/";
		$title=detect_browser_version("Songbird");
		$code="songbird";
	}elseif(preg_match('/Stainless/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.stainlessapp.com/";
		$title=detect_browser_version("Stainless");
		$code="stainless";
	}elseif(preg_match('/Sulfur/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.flock.com/";
		$title="Flock ".detect_browser_version("Sulfur");
		$code="flock";
	}elseif(preg_match('/Sunrise/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sunrisebrowser.com/";
		$title=detect_browser_version("Sunrise");
		$code="sunrise";
	}elseif(preg_match('/Surf/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://surf.suckless.org/";
		$title=detect_browser_version("Surf");
		$code="surf";
	}elseif(preg_match('/Swiftfox/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.getswiftfox.com/";
		$title=detect_browser_version("Swiftfox");
		$code="swiftfox";
	}elseif(preg_match('/Swiftweasel/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://swiftweasel.tuxfamily.org/";
		$title=detect_browser_version("Swiftweasel");
		$code="swiftweasel";
	}elseif(preg_match('/tear/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://wiki.maemo.org/Tear";
		$title="Tear";
		$code="tear";
	}elseif(preg_match('/TeaShark/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.teashark.com/";
		$title=detect_browser_version("TeaShark");
		$code="teashark";
	}elseif(preg_match('/Teleca/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Obigo_Browser/";
		$title=detect_browser_version(" Teleca");
		$code="obigo";
	}elseif(preg_match('/TencentTraveler/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.tencent.com/en-us/index.shtml";
		$title="Tencent ".detect_browser_version("Traveler");
		$code="tencenttraveler";
	}elseif(preg_match('/TheWorld/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.ioage.com/";
		$title="TheWorld Browser";
		$code="theworld";
	}elseif(preg_match('/Thunderbird/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.com/thunderbird/";
		$title=detect_browser_version("Thunderbird");
		$code="thunderbird";
	}elseif(preg_match('/Tjusig/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.tjusig.cz/";
		$title=detect_browser_version("Tjusig");
		$code="tjusig";
	}elseif(preg_match('/TencentTraveler/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://tt.qq.com/";
		$title=detect_browser_version("TencentTraveler");
		$code="tt-explorer";
	}elseif(preg_match('/uBrowser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.ubrowser.com/";
		$title=detect_browser_version("uBrowser");
		$code="ubrowser";
	}elseif(preg_match('/UC\ Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.uc.cn/English/index.shtml";
		$title=detect_browser_version("UC Browser");
		$code="ucbrowser";
	}elseif(preg_match('/UCWEB/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.ucweb.com/English/product.shtml";
		$title=detect_browser_version("UCWEB");
		$code="ucweb";
	}elseif(preg_match('/UltraBrowser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.ultrabrowser.com/";
		$title=detect_browser_version("UltraBrowser");
		$code="ultrabrowser";
	}elseif(preg_match('/UP.Browser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.openwave.com/";
		$title=detect_browser_version("UP.Browser");
		$code="openwave";
	}elseif(preg_match('/UP.Link/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.openwave.com/";
		$title=detect_browser_version("UP.Link");
		$code="openwave";
	}elseif(preg_match('/uZardWeb/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/UZard_Web";
		$title=detect_browser_version("uZardWeb");
		$code="uzardweb";
	}elseif(preg_match('/uZard/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/UZard_Web";
		$title=detect_browser_version("uZard");
		$code="uzardweb";
	}elseif(preg_match('/uzbl/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.uzbl.org/";
		$title="uzbl";
		$code="uzbl";
	}elseif(preg_match('/Vimprobable/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.vimprobable.org/";
		$title=detect_browser_version("Vimprobable");
		$code="null";
	}elseif(preg_match('/Vonkeror/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://zzo38computer.cjb.net/vonkeror/";
		$title=detect_browser_version("Vonkeror");
		$code="null";
	}elseif(preg_match('/w3m/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://w3m.sourceforge.net/";
		$title=detect_browser_version("W3M");
		$code="w3m";
	}elseif(preg_match('/WeltweitimnetzBrowser/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://weltweitimnetz.de/software/Browser.en.page";
		$title="Weltweitimnetz ".detect_browser_version("Browser");
		$code="weltweitimnetzbrowser";
	}elseif(preg_match('/wKiosk/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.app4mac.com/store/index.php?target=products&product_id=9";
		$title="wKiosk";
		$code="wkiosk";
	}elseif(preg_match('/WorldWideWeb/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.w3.org/People/Berners-Lee/WorldWideWeb.html";
		$title=detect_browser_version("WorldWideWeb");
		$code="worldwideweb";
	}elseif(preg_match('/Wyzo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.wyzo.com/";
		$title=detect_browser_version("Wyzo");
		$code="Wyzo";
	}elseif(preg_match('/X-Smiles/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.xsmiles.org/";
		$title=detect_browser_version("X-Smiles");
		$code="x-smiles";
	}elseif(preg_match('/Xiino/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="#";
		$title=detect_browser_version("Xiino");
		$code="null";

	//Pulled out of order to help ensure better detection for above browsers
	}elseif(preg_match('/Chrome/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://google.com/chrome/";
		$title="Google ".detect_browser_version("Chrome");
		$code="chrome";
	}elseif(preg_match('/Safari/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/Nokia/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.apple.com/safari/";
		$title="Safari";
		if(preg_match('/Version/i', $_SERVER['HTTP_USER_AGENT']))
			$title=detect_browser_version("Safari");
		if(preg_match('/Mobile Safari/i', $_SERVER['HTTP_USER_AGENT']))
			$title="Mobile ".$title;
		$code="safari";
	}elseif(preg_match('/Nokia/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.nokia.com/browser";
		$title="Nokia Web Browser";
		$code="maemo"; 
	}elseif(preg_match('/Firefox/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/";
		$title=detect_browser_version("Firefox");
		$code="firefox";
	}elseif(preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.microsoft.com/windows/products/winfamily/ie/default.mspx";
		$title="Internet Explorer".detect_browser_version("MSIE");
		preg_match('/MSIE[\ |\/]?([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch);
		if($regmatch[1]>=9){
			$code="msie9";
		}elseif($regmatch[1]>=7){
			//also ie8
			$code="msie7";
		}elseif($regmatch[1]>=6){
			$code="msie6";
		}elseif($regmatch[1]>=4){
			//also ie5
			$code="msie4";
		}elseif($regmatch[1]>=3){
			$code="msie3";
		}elseif($regmatch[1]>=2){
			$code="msie2";
		}elseif($regmatch[1]>=1){
			$code="msie1";
		}else{
			$code="msie";
		}
	}elseif(preg_match('/Mozilla/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mozilla.org/";
		$title="Mozilla Compatible";
		if(preg_match('/rv:([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title="Mozilla ".$regmatch[1];
		$code="mozilla";
	}else{
		return '';
	}
	
	return '<img src="/browser/browsers/'.$code.'.png" title="'.$title.'" style="margin-bottom:-4px" /> ';
}

//Detect Console or Mobile Device
function detect_device(){
	//Apple
	if(preg_match('/iPad/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.apple.com/itunes";
		$title="iPad";
		if(preg_match('/CPU\ OS\ ([._0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" iOS ".str_replace("_", ".", $regmatch[1]);
		$code="ipad";
	}elseif(preg_match('/iPod/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.apple.com/itunes";
		$title="iPod";
		if(preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" iOS ".str_replace("_", ".", $regmatch[1]);
		$code="iphone";
	}elseif(preg_match('/iPhone/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.apple.com/iphone";
		$title="iPhone";
		if(preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" iOS ".str_replace("_", ".", $regmatch[1]);
		$code="iphone";

	//BenQ-Siemens (Openwave)
	}elseif(preg_match('/[^M]SIE/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/BenQ-Siemens";
		$title="BenQ-Siemens";
		if(preg_match('/[^M]SIE-([.0-9a-zA-Z]+)\//i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="benq-siemens";

	//BlackBerry
	}elseif(preg_match('/BlackBerry/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.blackberry.com/";
		$title="BlackBerry";
		if(preg_match('/blackberry([.0-9a-zA-Z]+)\//i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="blackberry";

	//Dell
	}elseif(preg_match('/Dell Mini 5/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Dell_Streak";
		$title="Dell Mini 5";
		$code="dell";
	}elseif(preg_match('/Dell Streak/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Dell_Streak";
		$title="Dell Streak";
		$code="dell";
	}elseif(preg_match('/Dell/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Dell";
		$title="Dell";
		$code="dell";

	//Google
	}elseif(preg_match('/Nexus One/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Nexus_One";
		$title="Nexus One";
		$code="google-nexusone";

	//HTC
	}elseif(preg_match('/Desire/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/HTC_Desire";
		$title="HTC Desire";
		$code="htc";
	}elseif(preg_match('/Rhodium/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/HTC[_|\ ]Touch[_|\ ]Pro2/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/WMD-50433/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/HTC_Touch_Pro2";
		$title="HTC Touch Pro2";
		$code="htc";
	}elseif(preg_match('/HTC[_|\ ]Touch[_|\ ]Pro/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/HTC_Touch_Pro";
		$title="HTC Touch Pro";
		$code="htc";
	}elseif(preg_match('/HTC/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/High_Tech_Computer_Corporation";
		$title="HTC";
		if(preg_match('/HTC[\ |_|-]8500/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_Startrek";
			$title.=" Startrek";
		}elseif(preg_match('/HTC[\ |_|-]Hero/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_Hero";
			$title.=" Hero";
		}elseif(preg_match('/HTC[\ |_|-]Legend/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_Legend";
			$title.=" Legend";
		}elseif(preg_match('/HTC[\ |_|-]Magic/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_Magic";
			$title.=" Magic";
		}elseif(preg_match('/HTC[\ |_|-]P3450/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_Touch";
			$title.=" Touch";
		}elseif(preg_match('/HTC[\ |_|-]P3650/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_Polaris";
			$title.=" Polaris";
		}elseif(preg_match('/HTC[\ |_|-]S710/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_S710";
			$title.=" S710";
		}elseif(preg_match('/HTC[\ |_|-]Tattoo/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://en.wikipedia.org/wiki/HTC_Tattoo";
			$title.=" Tattoo";
		}elseif(preg_match('/HTC[\ |_|-]?([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch)){
			$title.=" ".$regmatch[1];
		}elseif(preg_match('/HTC([._0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch)){
			$title.=str_replace("_", " ", $regmatch[1]);
		}
		$code="htc";

	//LG
	}elseif(preg_match('/LG/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.lgmobile.com";
		$title="LG";
		if(preg_match('/LG[E]?[\ |-|\/]([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="lg";

	//Motorola
	}elseif(preg_match('/\ Droid/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Motorola_Droid";
		$title.="Motorola Droid";
		$code="motorola";
	}elseif(preg_match('/XT720/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Motorola";
		$title.="Motorola Motoroi (XT720)";
		$code="motorola";
	}elseif(preg_match('/MOT-/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/MIB/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Motorola";
		$title="Motorola";
		if(preg_match('/MOTO([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		if(preg_match('/MOT-([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="motorola";

	//Nintendo
	}elseif(preg_match('/Nintendo/i', $_SERVER['HTTP_USER_AGENT'])){
		$title="Nintendo";
		if(preg_match('/Nintendo DSi/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://www.nintendodsi.com/";
			$title.=" DSi";
			$code="nintendodsi";
		}elseif(preg_match('/Nintendo DS/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://www.nintendo.com/ds";
			$title.=" DS";
			$code="nintendods";
		}elseif(preg_match('/Nintendo Wii/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://www.nintendo.com/wii";
			$title.=" Wii";
			$code="nintendowii";
		}else{
			$link="http://www.nintendo.com/";
			$code="nintendo";
		}

	//Nokia
	}elseif(preg_match('/Nokia/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/S(eries)?60/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.nokia.com/";
		$title="Nokia";
		if(preg_match('/Nokia(E|N)?([0-9]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1].$regmatch[2];
		$code="nokia";
	}elseif(preg_match('/S(eries)?60/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.s60.com";
		$title="Nokia Series60";
		$code="nokia";

	//OLPC (One Laptop Per Child)
	}elseif(preg_match('/OLPC/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.laptop.org/";
		$title="OLPC (XO)";
		$code="olpc";

	//Palm
	}elseif(preg_match('/\ Pixi\//i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Palm_Pixi";
		$title="Palm Pixi";
		$code="palm";
	}elseif(preg_match('/\ Pre\//i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Palm_Pre";
		$title="Palm Pre";
		$code="palm";
	}elseif(preg_match('/Palm/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.palm.com/";
		$title="Palm";
		$code="palm";

	//Playstation
	}elseif(preg_match('/Playstation/i', $_SERVER['HTTP_USER_AGENT'])){
		$title="Playstation";
		if(preg_match('/[PS|Playstation\ ]3/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://www.us.playstation.com/PS3";
			$title.=" 3";
		}elseif(preg_match('/[Playstation Portable|PSP]/i', $_SERVER['HTTP_USER_AGENT'])){
			$link="http://www.us.playstation.com/PSP";
			$title.=" Portable";
		}else{
			$link="http://www.us.playstation.com/";
		}
		$code="playstation";

	//Samsung
	}elseif(preg_match('/Samsung/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.samsungmobile.com/";
		$title="Samsung";
		if(preg_match('/Samsung-([.\-0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="samsung";

	//Sony Ericsson
	}elseif(preg_match('/SonyEricsson/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/SonyEricsson";
		$title="SonyEricsson";
		if(preg_match('/SonyEricsson([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch)){
			if(strtolower($regmatch[1])==strtolower("U20i"))
				$title.=" Xperia X10 Mini Pro";
			else
				$title.=" ".$regmatch[1];
		}
		$code="sonyericsson";

	//No Device match
	}else{
		return "";
	}
	
	return '<img src="/browser/device/'.$code.'.png" title="'.$title.'" style="margin-bottom:-4px" /> ';
}

//Detect Operating System
function detect_os(){
	if(preg_match('/AmigaOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/AmigaOS";
		$title="AmigaOS";
		if(preg_match('/AmigaOS\ ([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="amigaos";
	}elseif(preg_match('/Android/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.android.com/";
		$title="Android";
		$code="android";
	}elseif(preg_match('/[^A-Za-z]Arch/i', $_SERVER['HTTP_USER_AGENT'])) { //&& !preg_match('/Search/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.archlinux.org/";
		$title="Arch Linux";
		$code="archlinux";
	}elseif(preg_match('/BeOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/BeOS";
		$title="BeOS";
		$code="beos";
	}elseif(preg_match('/CentOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.centos.org/";
		$title="CentOS";
		if(preg_match('/.el([.0-9a-zA-Z]+).centos/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="centos";
	}elseif(preg_match('/CrOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Google_Chrome_OS";
		$title="Google Chrome OS";
		$code="chromeos";
	}elseif(preg_match('/Debian/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.debian.org/";
		$title="Debian GNU/Linux";
		$code="debian";
	}elseif(preg_match('/DragonFly/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.dragonflybsd.org/";
		$title="DragonFly BSD";
		$code="dragonflybsd";
	}elseif(preg_match('/Edubuntu/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.edubuntu.org/";
		$title="Edubuntu";
		if(preg_match('/Edubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$version.=" ".$regmatch[1];
		if($regmatch[1] < 10)
			$code="edubuntu-1";
		else
			$code="edubuntu-2";
		if(strlen($version) > 1)
			$title.=$version;
	}elseif(preg_match('/Fedora/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.fedoraproject.org/";
		$title="Fedora";
		if(preg_match('/.fc([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="fedora";
	}elseif(preg_match('/Foresight\ Linux/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.foresightlinux.org/";
		$title="Foresight Linux";
		if(preg_match('/Foresight\ Linux\/([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="foresight";
	}elseif(preg_match('/FreeBSD/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.freebsd.org/";
		$title="FreeBSD";
		$code="freebsd";
	}elseif(preg_match('/Gentoo/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.gentoo.org/";
		$title="Gentoo";
		$code="gentoo";
	}elseif(preg_match('/IRIX/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sgi.com/partners/?/technology/irix/";
		$title="IRIX Linux";
		if(preg_match('/IRIX(64)?\ ([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch)) {
			if($regmatch[1])
				$title.=" x".$regmatch[1];
			if($regmatch[2])
				$title.=" ".$regmatch[2];
		}
		$code="irix";
	}elseif(preg_match('/Kanotix/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.kanotix.com/";
		$title="Kanotix";
		$code="kanotix";
	}elseif(preg_match('/Knoppix/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.knoppix.net/";
		$title="Knoppix";
		$code="knoppix";
	}elseif(preg_match('/Kubuntu/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.kubuntu.org/";
		$title="Kubuntu";
		if(preg_match('/Kubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$version.=" ".$regmatch[1];
		if($regmatch[1] < 10)
			$code="kubuntu-1";
		else
			$code="kubuntu-2";
		if(strlen($version) > 1)
			$title.=$version;
	}elseif(preg_match('/LindowsOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/Lsongs";
		$title="LindowsOS";
		$code="lindowsos";
	}elseif(preg_match('/Linspire/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.linspire.com/";
		$title="Linspire";
		$code="lindowsos";
	}elseif(preg_match('/Linux\ Mint/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.linuxmint.com/";
		$title="Linux Mint";
		if(preg_match('/Linux\ Mint\/([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="linuxmint";
	}elseif(preg_match('/Lubuntu/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.lubuntu.net/";
		$title="Lubuntu";
		if(preg_match('/Lubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$version.=" ".$regmatch[1];
		if($regmatch[1] < 10)
			$code="lubuntu-1";
		else
			$code="lubuntu-2";
		if(strlen($version) > 1)
			$title.=$version;
	}elseif(preg_match('/Mac/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Darwin/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.apple.com/macosx/";
		if(preg_match('/Mac OS X/i', $_SERVER['HTTP_USER_AGENT'])){
			$title=substr($_SERVER['HTTP_USER_AGENT'], strpos(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower("Mac OS X")));
			$title=substr($title, 0, strpos($title, ";"));
			$title=str_replace("_", ".", $title); 
			$code="mac-3";
		}elseif(preg_match('/Mac OSX/i', $_SERVER['HTTP_USER_AGENT'])){
			$title=substr($_SERVER['HTTP_USER_AGENT'], strpos(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower("Mac OSX")));
			$title=substr($title, 0, strpos($title, ";"));
			$title=str_replace("_", ".", $title); 
			$code="mac-2";
		}elseif(preg_match('/Darwin/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Mac OS Darwin";
			$code="mac-1";
		}else {
			$title="Macintosh";
			$code="mac-1";
		}
	}elseif(preg_match('/Mandriva/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.mandriva.com/";
		$title="Mandriva";
		if(preg_match('/mdv([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="mandriva";
	}elseif(preg_match('/MorphOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.morphos-team.net/";
		$title="MorphOS";
		$code="morphos";
	}elseif(preg_match('/NetBSD/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.netbsd.org/";
		$title="NetBSD";
		$code="netbsd";
	}elseif(preg_match('/OpenBSD/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.openbsd.org/";
		$title="OpenBSD";
		$code="openbsd";
	}elseif(preg_match('/Oracle/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.oracle.com/us/technologies/linux/";
		$title="Oracle";
		if(preg_match('/.el([._0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" Enterprise Linux ".str_replace("_", ".", $regmatch[1]);
		else
			$title.=" Linux";
		$code="oracle";
	}elseif(preg_match('/PCLinuxOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.pclinuxos.com/";
		$title="PCLinuxOS";
		if(preg_match('/PCLinuxOS\/[.\-0-9a-zA-Z]+pclos([.\-0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".str_replace("_", ".", $regmatch[1]);
		$code="pclinuxos";
	}elseif(preg_match('/Red\ Hat/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/RedHat/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.redhat.com/";
		$title="Red Hat";
		if(preg_match('/.el([._0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" Enterprise Linux ".str_replace("_", ".", $regmatch[1]);
		$code="mandriva";
	}elseif(preg_match('/Sabayon/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sabayonlinux.org/";
		$title="Sabayon Linux";
		$code="sabayon";
	}elseif(preg_match('/Slackware/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.slackware.com/";
		$title="Slackware";
		$code="slackware";
	}elseif(preg_match('/Solaris/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sun.com/software/solaris/";
		$title="Solaris";
		$code="solaris";
	}elseif(preg_match('/SunOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.sun.com/software/solaris/";
		$title="Solaris";
		$code="solaris";
	}elseif(preg_match('/Suse/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.opensuse.org/";
		$title="openSUSE";
		$code="suse";
	}elseif(preg_match('/Symb[ian]?[OS]?/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.symbianos.org/";
		$title="SymbianOS";
		if(preg_match('/Symb[ian]?[OS]?\/([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$title.=" ".$regmatch[1];
		$code="symbianos";
	}elseif(preg_match('/Ubuntu/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.ubuntu.com/";
		$title="Ubuntu";
		if(preg_match('/Ubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$version.=" ".$regmatch[1];
		if($regmatch[1] < 10)
			$code="ubuntu-1";
		else
			$code="ubuntu-2";
		if(strlen($version) > 1)
			$title.=$version;
	}elseif(preg_match('/Unix/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.unix.org/";
		$title="Unix";
		$code="unix";
	}elseif(preg_match('/VectorLinux/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.vectorlinux.com/";
		$title="VectorLinux";
		$code="vectorlinux";
	}elseif(preg_match('/Venenux/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.venenux.org/";
		$title="Venenux GNU Linux";
		$code="venenux";
	}elseif(preg_match('/webOS/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://en.wikipedia.org/wiki/WebOS";
		$title="Palm webOS";
		$code="palm";
	}elseif(preg_match('/Windows/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/WinNT/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Win32/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.microsoft.com/windows/";
		if(preg_match('/Windows NT 6.1; Win64; x64;/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Windows NT 6.1; WOW64;/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows 7 x64 Edition";
			$code="win-4";
		}elseif(preg_match('/Windows NT 6.1/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows 7";
			$code="win-4";
		}elseif(preg_match('/Windows NT 6.0/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows Vista";
			$code="win-3";
		}elseif(preg_match('/Windows NT 5.2 x64/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows XP x64 Edition";
			$code="win-2";
		}elseif(preg_match('/Windows NT 5.2/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows Server 2003";
			$code="win-2";
		}elseif(preg_match('/Windows NT 5.1/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Windows XP/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows XP";
			$code="win-2";
		}elseif(preg_match('/Windows NT 5.01/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows 2000, Service Pack 1 (SP1)";
			$code="win-1";
		}elseif(preg_match('/Windows NT 5.0/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Windows 2000/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows 2000";
			$code="win-1";
		}elseif(preg_match('/Windows NT 4.0/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/WinNT4.0/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Microsoft Windows NT 4.0";
			$code="win-1";
		}elseif(preg_match('/Windows NT 3.51/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/WinNT3.51/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Microsoft Windows NT 3.11";
			$code="win-1";
		}elseif(preg_match('/Windows 3.11/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Win3.11/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Win16/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Microsoft Windows 3.11";
			$code="win-1";
		}elseif(preg_match('/Windows 3.1/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Microsoft Windows 3.1";
			$code="win-1";
		}elseif(preg_match('/Windows 98; Win 9x 4.90/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Win 9x 4.90/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Windows ME/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows Millennium Edition (Windows Me)";
			$code="win-1";
		}elseif(preg_match('/Win98/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows 98 SE";
			$code="win-1";
		}elseif(preg_match('/Windows 98/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Windows\ 4.10/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows 98";
			$code="win-1";
		}elseif(preg_match('/Windows 95/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Win95/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows 95";
			$code="win-1";
		}elseif(preg_match('/Windows CE/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows CE";
			$code="win-2";
		}elseif(preg_match('/WM5/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows Mobile 5";
			$code="win-phone";
		}elseif(preg_match('/WindowsMobile/i', $_SERVER['HTTP_USER_AGENT'])){
			$title="Windows Mobile";
			$code="win-phone";
		}else{
			$title="Windows";
			$code="win-2";
		}
	}elseif(preg_match('/Xandros/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.xandros.com/";
		$title="Xandros";
		$code="xandros";
	}elseif(preg_match('/Xubuntu/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.xubuntu.org/";
		$title="Xubuntu";
		if(preg_match('/Xubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $_SERVER['HTTP_USER_AGENT'], $regmatch))
			$version.=" ".$regmatch[1];
		if($regmatch[1] < 10)
			$code="xubuntu-1";
		else
			$code="xubuntu-2";
		if(strlen($version) > 1)
			$title.=$version;
	}elseif(preg_match('/Zenwalk/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.zenwalk.org/";
		$title="Zenwalk GNU Linux";
		$code="zenwalk";

	//Pulled out of order to help ensure better detection for above platforms
	}elseif(preg_match('/Linux/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://www.linux.org/";
		$title="GNU/Linux";
		$code="linux";
		if(preg_match('/x86_64/i', $_SERVER['HTTP_USER_AGENT']))
			$title.=" x64";
	}elseif(preg_match('/J2ME\/MIDP/i', $_SERVER['HTTP_USER_AGENT'])){
		$link="http://java.sun.com/javame/";
		$title="J2ME/MIDP Device";
		$code="java";
	}else{
		return "";
	}
	
	return '<img src="/browser/os/'.$code.'.png" title="'.$title.'" style="margin-bottom:-4px" /> ';
}

//Detect Platform (check for Device, then OS if no device is found, else return null)
function detect_platform(){
	if(strlen($detected_platform=detect_device()) > 0){
		return $detected_platform;
	}elseif(strlen($detected_platform=detect_os()) > 0){
		return $detected_platform;
	}else{
		return '';
	}
	
	return '<img src="/browser/browsers/'.$code.'.png" title="'.$title.'" style="margin-bottom:-4px" /> ';
}

?>
