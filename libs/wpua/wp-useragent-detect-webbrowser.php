<?php

// Detect Web Browsers
function detect_webbrowser()
{
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$mobile=0;

	if(preg_match('/360se/i', $useragent))
	{
		$link="http://se.360.cn/";
		$title="360Safe Explorer";
		$code="360se";
	}
	elseif(preg_match('/Abolimba/i', $useragent))
	{
		$link="http://www.aborange.de/products/freeware/abolimba-multibrowser.php";
		$title="Abolimba";
		$code="abolimba";
	}
	elseif(preg_match('/Acoo\ Browser/i', $useragent))
	{
		$link="http://www.acoobrowser.com/";
		$title="Acoo ".detect_browser_version("Browser");
		$code="acoobrowser";
	}
	elseif(preg_match('/Alienforce/i', $useragent))
	{
		$link="http://sourceforge.net/projects/alienforce/";
		$title=detect_browser_version("Alienforce");
		$code="alienforce";
	}
	elseif(preg_match('/Amaya/i', $useragent))
	{
		$link="http://www.w3.org/Amaya/";
		$title=detect_browser_version("Amaya");
		$code="amaya";
	}
	elseif(preg_match('/Amiga-AWeb/i', $useragent))
	{
		$link="http://aweb.sunsite.dk/";
		$title="Amiga ".detect_browser_version("AWeb");
		$code="amiga-aweb";
	}
	elseif(preg_match('/America\ Online\ Browser/i', $useragent))
	{
		$link="http://downloads.channel.aol.com/browser";
		$title="America Online ".detect_browser_version("Browser");
		$code="aol";
	}
	elseif(preg_match('/AmigaVoyager/i', $useragent))
	{
		$link="http://v3.vapor.com/voyager/";
		$title="Amiga ".detect_browser_version("Voyager");
		$code="amigavoyager";
	}
	elseif(preg_match('/AOL/i', $useragent))
	{
		$link="http://downloads.channel.aol.com/browser";
		$title=detect_browser_version("AOL");
		$code="aol";
	}
	elseif(preg_match('/Arora/i', $useragent))
	{
		$link="http://code.google.com/p/arora/";
		$title=detect_browser_version("Arora");
		$code="arora";
	}
	elseif(preg_match('/AtomicBrowser/i', $useragent))
	{
		$link="http://www.atomicwebbrowser.com/";
		$title=detect_browser_version("AtomicBrowser");
		$code="atomicwebbrowser";
	}
	elseif(preg_match('/Avant\ Browser/i', $useragent))
	{
		$link="http://www.avantbrowser.com/";
		$title="Avant ".detect_browser_version("Browser");
		$code="avantbrowser";
	}
	elseif(preg_match('/baidubrowser/i', $useragent))
	{
		$link="http://liulanqi.baidu.com/";
		$title=detect_browser_version("Browser");
		$code="baidubrowser";
	}
	elseif(preg_match('/BarcaPro/i', $useragent))
	{
		$link="http://www.pocosystems.com/home/index.php?option=content&task=category&sectionid=2&id=9&Itemid=27";
		$title=detect_browser_version("BarcaPro");
		$code="barca";
	}
	elseif(preg_match('/Barca/i', $useragent))
	{
		$link="http://www.pocosystems.com/home/index.php?option=content&task=category&sectionid=2&id=9&Itemid=27";
		$title=detect_browser_version("Barca");
		$code="barca";
	}
	elseif(preg_match('/Beamrise/i', $useragent))
	{
		$link="http://www.beamrise.com/";
		$title=detect_browser_version("Beamrise");
		$code="beamrise";
	}
	elseif(preg_match('/Beonex/i', $useragent))
	{
		$link="http://www.beonex.com/";
		$title=detect_browser_version("Beonex");
		$code="beonex";
	}
	elseif(preg_match('/BlackBerry/i', $useragent))
	{
		$link="http://www.blackberry.com/";
		$title=detect_browser_version("BlackBerry");
		$code="blackberry";
	}
	elseif(preg_match('/Blackbird/i', $useragent))
	{
		$link="http://www.blackbirdbrowser.com/";
		$title=detect_browser_version("Blackbird");
		$code="blackbird";
	}
	elseif(preg_match('/BlackHawk/i', $useragent))
	{
		$link="http://www.netgate.sk/blackhawk/help/welcome-to-blackhawk-web-browser.html";
		$title=detect_browser_version("BlackHawk");
		$code="blackhawk";
	}
	elseif(preg_match('/Blazer/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Blazer_(web_browser)";
		$title=detect_browser_version("Blazer");
		$code="blazer";
	}
	elseif(preg_match('/Bolt/i', $useragent))
	{
		$link="http://www.boltbrowser.com/";
		$title=detect_browser_version("Bolt");
		$code="bolt";
	}
	elseif(preg_match('/BonEcho/i', $useragent))
	{
		$link="http://www.mozilla.org/projects/minefield/";
		$title=detect_browser_version("BonEcho");
		$code="firefoxdevpre";
	}
	elseif(preg_match('/BrowseX/i', $useragent))
	{
		$link="http://pdqi.com/browsex/";
		$title="BrowseX";
		$code="browsex";
	}
	elseif(preg_match('/Browzar/i', $useragent))
	{
		$link="http://www.browzar.com/";
		$title=detect_browser_version("Browzar");
		$code="browzar";
	}
	elseif(preg_match('/Bunjalloo/i', $useragent))
	{
		$link="http://code.google.com/p/quirkysoft/";
		$title=detect_browser_version("Bunjalloo");
		$code="bunjalloo";
	}
	elseif(preg_match('/Camino/i', $useragent))
	{
		$link="http://www.caminobrowser.org/";
		$title=detect_browser_version("Camino");
		$code="camino";
	}
	elseif(preg_match('/Cayman\ Browser/i', $useragent))
	{
		$link="http://www.caymanbrowser.com/";
		$title="Cayman ".detect_browser_version("Browser");
		$code="caymanbrowser";
	}
	elseif(preg_match('/Charon/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Charon_(web_browser)";
		$title=detect_browser_version("Charon");
		$code="null";
	}
	elseif(preg_match('/Cheshire/i', $useragent))
	{
		$link="http://downloads.channel.aol.com/browser";
		$title=detect_browser_version("Cheshire");
		$code="aol";
	}
	elseif(preg_match('/Chimera/i', $useragent))
	{
		$link="http://www.chimera.org/";
		$title=detect_browser_version("Chimera");
		$code="null";
	}
	elseif(preg_match('/chromeframe/i', $useragent))
	{
		$link="http://code.google.com/chrome/chromeframe/";
		$title=detect_browser_version("chromeframe");
		$code="google";
	}
	elseif(preg_match('/ChromePlus/i', $useragent))
	{
		$link="http://www.chromeplus.org/";
		$title=detect_browser_version("ChromePlus");
		$code="chromeplus";
	}
	elseif(preg_match('/Iron/i', $useragent))
	{
		$link="http://www.srware.net/";
		$title="SRWare ".detect_browser_version("Iron");
		$code="srwareiron";
	}
	elseif(preg_match('/Chromium/i', $useragent))
	{
		$link="http://www.chromium.org/";
		$title=detect_browser_version("Chromium");
		$code="chromium";
	}
	elseif(preg_match('/Classilla/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Classilla";
		$title=detect_browser_version("Classilla");
		$code="classilla";
	}
	elseif(preg_match('/Columbus/i', $useragent))
	{
		$link="http://www.columbus-browser.com/";
		$title=detect_browser_version("Columbus");
		$code="columbus";
	}
	elseif(preg_match('/CometBird/i', $useragent))
	{
		$link="http://www.cometbird.com/";
		$title=detect_browser_version("CometBird");
		$code="cometbird";
	}
	elseif(preg_match('/Comodo_Dragon/i', $useragent))
	{
		$link="http://www.comodo.com/home/internet-security/browser.php";
		$title="Comodo ".detect_browser_version("Dragon");
		$code="comodo-dragon";
	}
	elseif(preg_match('/Conkeror/i', $useragent))
	{
		$link="http://www.conkeror.org/";
		$title=detect_browser_version("Conkeror");
		$code="conkeror";
	}
	elseif(preg_match('/CoolNovo/i', $useragent))
	{
		$link="http://www.coolnovo.com/";
		$title=detect_browser_version("CoolNovo");
		$code="coolnovo";
	}
	elseif(preg_match('/Crazy\ Browser/i', $useragent))
	{
		$link="http://www.crazybrowser.com/";
		$title="Crazy ".detect_browser_version("Browser");
		$code="crazybrowser";
	}
	elseif(preg_match('/CrMo/i', $useragent))
	{
		$link="http://www.google.com/chrome";
		$title=detect_browser_version("CrMo");
		$code="chrome";
	}
	elseif(preg_match('/Cruz/i', $useragent))
	{
		$link="http://www.cruzapp.com/";
		$title=detect_browser_version("Cruz");
		$code="cruz";
	}
	elseif(preg_match('/Cyberdog/i', $useragent))
	{
		$link="http://www.cyberdog.org/about/cyberdog/cyberbrowse.html";
		$title=detect_browser_version("Cyberdog");
		$code="cyberdog";
	}
	elseif(preg_match('/DPlus/i', $useragent))
	{
		$link="http://dplus-browser.sourceforge.net/";
		$title=detect_browser_version("DPlus");
		$code="dillo";
	}
	elseif(preg_match('/Deepnet\ Explorer/i', $useragent))
	{
		$link="http://www.deepnetexplorer.com/";
		$title=detect_browser_version("Deepnet Explorer");
		$code="deepnetexplorer";
	}
	elseif(preg_match('/Demeter/i', $useragent))
	{
		$link="http://www.hurrikenux.com/Demeter/";
		$title=detect_browser_version("Demeter");
		$code="demeter";
	}
	elseif(preg_match('/DeskBrowse/i', $useragent))
	{
		$link="http://www.deskbrowse.org/";
		$title=detect_browser_version("DeskBrowse");
		$code="deskbrowse";
	}
	elseif(preg_match('/Dillo/i', $useragent))
	{
		$link="http://www.dillo.org/";
		$title=detect_browser_version("Dillo");
		$code="dillo";
	}
	elseif(preg_match('/DoCoMo/i', $useragent))
	{
		$link="http://www.nttdocomo.com/";
		$title=detect_browser_version("DoCoMo");
		$code="null";
	}
	elseif(preg_match('/DocZilla/i', $useragent))
	{
		$link="http://www.doczilla.com/";
		$title=detect_browser_version("DocZilla");
		$code="doczilla";
	}
	elseif(preg_match('/Dolfin/i', $useragent))
	{
		$link="http://www.samsungmobile.com/";
		$title=detect_browser_version("Dolfin");
		$code="samsung";
	}
	elseif(preg_match('/Dooble/i', $useragent))
	{
		$link="http://dooble.sourceforge.net/";
		$title=detect_browser_version("Dooble");
		$code="dooble";
	}
	elseif(preg_match('/Doris/i', $useragent))
	{
		$link="http://www.anygraaf.fi/browser/indexe.htm";
		$title=detect_browser_version("Doris");
		$code="doris";
	}
	elseif(preg_match('/Dorothy/i', $useragent))
	{
		$link="http://www.dorothybrowser.com/";
		$title=detect_browser_version("Dorothy");
		$code="dorothybrowser";
	}
	elseif(preg_match('/Edbrowse/i', $useragent))
	{
		$link="http://edbrowse.sourceforge.net/";
		$title=detect_browser_version("Edbrowse");
		$code="edbrowse";
	}
	elseif(preg_match('/Elinks/i', $useragent))
	{
		$link="http://elinks.or.cz/";
		$title=detect_browser_version("Elinks");
		$code="elinks";
	}
	elseif(preg_match('/Element\ Browser/i', $useragent))
	{
		$link="http://www.elementsoftware.co.uk/software/elementbrowser/";
		$title="Element ".detect_browser_version("Browser");
		$code="elementbrowser";
	}
	elseif(preg_match('/Enigma\ Browser/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Enigma_Browser";
		$title="Enigma ".detect_browser_version("Browser");
		$code="enigmabrowser";
	}
	elseif(preg_match('/EnigmaFox/i', $useragent))
	{
		$link="#";
		$title=detect_browser_version("EnigmaFox");
		$code="null";
	}
	elseif(preg_match('/Epic/i', $useragent))
	{
		$link="http://www.epicbrowser.com/";
		$title=detect_browser_version("Epic");
		$code="epicbrowser";
	}
	elseif(preg_match('/Epiphany/i', $useragent))
	{
		$link="http://gnome.org/projects/epiphany/";
		$title=detect_browser_version("Epiphany");
		$code="epiphany";
	}
	elseif(preg_match('/Escape/i', $useragent))
	{
		$link="http://www.espial.com/products/evo_browser/";
		$title="Espial TV Browser - ".detect_browser_version("Escape");
		$code="espialtvbrowser";
	}
	elseif(preg_match('/Fennec/i', $useragent))
	{
		$link="https://wiki.mozilla.org/Fennec";
		$title=detect_browser_version("Fennec");
		$code="fennec";
	}
	elseif(preg_match('/Firebird/i', $useragent))
	{
		$link="http://seb.mozdev.org/firebird/";
		$title=detect_browser_version("Firebird");
		$code="firebird";
	}
	elseif(preg_match('/Fireweb\ Navigator/i', $useragent))
	{
		$link="http://www.arsslensoft.tk/?q=node/7";
		$title=detect_browser_version("Fireweb Navigator");
		$code="firewebnavigator";
	}
	elseif(preg_match('/Flock/i', $useragent))
	{
		$link="http://www.flock.com/";
		$title=detect_browser_version("Flock");
		$code="flock";
	}
	elseif(preg_match('/Fluid/i', $useragent))
	{
		$link="http://www.fluidapp.com/";
		$title=detect_browser_version("Fluid");
		$code="fluid";
	}
	elseif(preg_match('/Galaxy/i', $useragent)
		&& !preg_match('/Chrome/i', $useragent))
	{
		$link="http://www.traos.org/";
		$title=detect_browser_version("Galaxy");
		$code="galaxy";
	}
	elseif(preg_match('/Galeon/i', $useragent))
	{
		$link="http://galeon.sourceforge.net/";
		$title=detect_browser_version("Galeon");
		$code="galeon";
	}
	elseif(preg_match('/GlobalMojo/i', $useragent))
	{
		$link="http://www.globalmojo.com/";
		$title=detect_browser_version("GlobalMojo");
		$code="globalmojo";
	}
	elseif(preg_match('/GoBrowser/i', $useragent))
	{
		$link="http://www.gobrowser.cn/";
		$title="GO ".detect_browser_version("Browser");
		$code="gobrowser";
	}
	elseif(preg_match('/Google\ Wireless\ Transcoder/i', $useragent))
	{
		$link="http://google.com/gwt/n";
		$title="Google Wireless Transcoder";
		$code="google";
	}
	elseif(preg_match('/GoSurf/i', $useragent))
	{
		$link="http://gosurfbrowser.com/?ln=en";
		$title=detect_browser_version("GoSurf");
		$code="gosurf";
	}
	elseif(preg_match('/GranParadiso/i', $useragent))
	{
		$link="http://www.mozilla.org/";
		$title=detect_browser_version("GranParadiso");
		$code="firefoxdevpre";
	}
	elseif(preg_match('/GreenBrowser/i', $useragent))
	{
		$link="http://www.morequick.com/";
		$title=detect_browser_version("GreenBrowser");
		$code="greenbrowser";
	}
	elseif(preg_match('/Hana/i', $useragent))
	{
		$link="http://www.alloutsoftware.com/";
		$title=detect_browser_version("Hana");
		$code="hana";
	}
	elseif(preg_match('/HotJava/i', $useragent))
	{
		$link="http://java.sun.com/products/archive/hotjava/";
		$title=detect_browser_version("HotJava");
		$code="hotjava";
	}
	elseif(preg_match('/Hv3/i', $useragent))
	{
		$link="http://tkhtml.tcl.tk/hv3.html";
		$title=detect_browser_version("Hv3");
		$code="hv3";
	}
	elseif(preg_match('/Hydra\ Browser/i', $useragent))
	{
		$link="http://www.hydrabrowser.com/";
		$title="Hydra Browser";
		$code="hydrabrowser";
	}
	elseif(preg_match('/Iris/i', $useragent))
	{
		$link="http://www.torchmobile.com/";
		$title=detect_browser_version("Iris");
		$code="iris";
	}
	elseif(preg_match('/IBM\ WebExplorer/i', $useragent))
	{
		$link="http://www.networking.ibm.com/WebExplorer/";
		$title="IBM ".detect_browser_version("WebExplorer");
		$code="ibmwebexplorer";
	}
	elseif(preg_match('/IBrowse/i', $useragent))
	{
		$link="http://www.ibrowse-dev.net/";
		$title=detect_browser_version("IBrowse");
		$code="ibrowse";
	}
	elseif(preg_match('/iCab/i', $useragent))
	{
		$link="http://www.icab.de/";
		$title=detect_browser_version("iCab");
		$code="icab";
	}
	elseif(preg_match('/Ice Browser/i', $useragent))
	{
		$link="http://www.icesoft.com/products/icebrowser.html";
		$title=detect_browser_version("Ice Browser");
		$code="icebrowser";
	}
	elseif(preg_match('/Iceape/i', $useragent))
	{
		$link="http://packages.debian.org/iceape";
		$title=detect_browser_version("Iceape");
		$code="iceape";
	}
	elseif(preg_match('/IceCat/i', $useragent))
	{
		$link="http://gnuzilla.gnu.org/";
		$title="GNU ".detect_browser_version("IceCat");
		$code="icecat";
	}
	elseif(preg_match('/IceWeasel/i', $useragent))
	{
		$link="http://www.geticeweasel.org/";
		$title=detect_browser_version("IceWeasel");
		$code="iceweasel";
	}
	elseif(preg_match('/IEMobile/i', $useragent))
	{
		$link="http://www.microsoft.com/windowsmobile/en-us/downloads/microsoft/internet-explorer-mobile.mspx";
		$title=detect_browser_version("IEMobile");
		$code="msie-mobile";
	}
	elseif(preg_match('/iNet\ Browser/i', $useragent))
	{
		$link="http://alexanderjbeston.wordpress.com/";
		$title="iNet ".detect_browser_version("Browser");
		$code="null";
	}
	elseif(preg_match('/iRider/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/IRider";
		$title=detect_browser_version("iRider");
		$code="irider";
	}
	elseif(preg_match('/Iron/i', $useragent))
	{
		$link="http://www.srware.net/en/software_srware_iron.php";
		$title=detect_browser_version("Iron");
		$code="iron";
	}
	elseif(preg_match('/InternetSurfboard/i', $useragent))
	{
		$link="http://inetsurfboard.sourceforge.net/";
		$title=detect_browser_version("InternetSurfboard");
		$code="internetsurfboard";
	}
	elseif(preg_match('/Jasmine/i', $useragent))
	{
		$link="http://www.samsungmobile.com/";
		$title=detect_browser_version("Jasmine");
		$code="samsung";
	}
	elseif(preg_match('/K-Meleon/i', $useragent))
	{
		$link="http://kmeleon.sourceforge.net/";
		$title=detect_browser_version("K-Meleon");
		$code="kmeleon";
	}
	elseif(preg_match('/K-Ninja/i', $useragent))
	{
		$link="http://k-ninja-samurai.en.softonic.com/";
		$title=detect_browser_version("K-Ninja");
		$code="kninja";
	}
	elseif(preg_match('/Kapiko/i', $useragent))
	{
		$link="http://ufoxlab.googlepages.com/cooperation";
		$title=detect_browser_version("Kapiko");
		$code="kapiko";
	}
	elseif(preg_match('/Kazehakase/i', $useragent))
	{
		$link="http://kazehakase.sourceforge.jp/";
		$title=detect_browser_version("Kazehakase");
		$code="kazehakase";
	}
	elseif(preg_match('/Strata/i', $useragent))
	{
		$link="http://www.kirix.com/";
		$title="Kirix ".detect_browser_version("Strata");
		$code="kirix-strata";
	}
	elseif(preg_match('/KKman/i', $useragent))
	{
		$link="http://www.kkman.com.tw/";
		$title=detect_browser_version("KKman");
		$code="kkman";
	}
	elseif(preg_match('/KMail/i', $useragent))
	{
		$link="http://kontact.kde.org/kmail/";
		$title=detect_browser_version("KMail");
		$code="kmail";
	}
	elseif(preg_match('/KMLite/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/K-Meleon";
		$title=detect_browser_version("KMLite");
		$code="kmeleon";
	}
	elseif(preg_match('/Konqueror/i', $useragent))
	{
		$link="http://konqueror.kde.org/";
		$title=detect_browser_version("Konqueror");
		$code="konqueror";
	}
	elseif(preg_match('/Kylo/i', $useragent))
	{
		$link="http://kylo.tv/";
		$title=detect_browser_version("Kylo");
		$code="kylo";
	}
	elseif(preg_match('/LBrowser/i', $useragent))
	{
		$link="http://wiki.freespire.org/index.php/Web_Browser";
		$title=detect_browser_version("LBrowser");
		$code="lbrowser";
	}
	elseif(preg_match('/LeechCraft/i', $useragent))
	{
		$link="http://leechcraft.org/";
		$title="LeechCraft";
		$code="null";
	}
	elseif(preg_match('/Links/i', $useragent)
		&& !preg_match('/online\ link\ validator/i', $useragent))
	{
		$link="http://links.sourceforge.net/";
		$title=detect_browser_version("Links");
		$code="links";
	}
	elseif(preg_match('/Lobo/i', $useragent))
	{
		$link="http://www.lobobrowser.org/";
		$title=detect_browser_version("Lobo");
		$code="lobo";
	}
	elseif(preg_match('/lolifox/i', $useragent))
	{
		$link="http://www.lolifox.com/";
		$title=detect_browser_version("lolifox");
		$code="lolifox";
	}
	elseif(preg_match('/Lorentz/i', $useragent))
	{
		$link="http://news.softpedia.com/news/Firefox-Codenamed-Lorentz-Drops-in-March-2010-130855.shtml";
		$title=detect_browser_version("Lorentz");
		$code="firefoxdevpre";
	}
	elseif(preg_match('/Lunascape/i', $useragent))
	{
		$link="http://www.lunascape.tv";
		$title=detect_browser_version("Lunascape");
		$code="lunascape";
	}
	elseif(preg_match('/Lynx/i', $useragent))
	{
		$link="http://lynx.browser.org/";
		$title=detect_browser_version("Lynx");
		$code="lynx";
	}
	elseif(preg_match('/Madfox/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Madfox";
		$title=detect_browser_version("Madfox");
		$code="madfox";
	}
	elseif(preg_match('/Maemo\ Browser/i', $useragent))
	{
		$link="http://maemo.nokia.com/features/maemo-browser/";
		$title=detect_browser_version("Maemo Browser");
		$code="maemo";
	}
	elseif(preg_match('/Maxthon/i', $useragent))
	{
		$link="http://www.maxthon.com/";
		$title=detect_browser_version("Maxthon");
		$code="maxthon";
	}
	elseif(preg_match('/\ MIB\//i', $useragent))
	{
		$link="http://www.motorola.com/content.jsp?globalObjectId=1827-4343";
		$title=detect_browser_version("MIB");
		$code="mib";
	}
	elseif(preg_match('/Tablet\ browser/i', $useragent))
	{
		$link="http://browser.garage.maemo.org/";
		$title=detect_browser_version("Tablet browser");
		$code="microb";
	}
	elseif(preg_match('/Midori/i', $useragent))
	{
		$link="http://www.twotoasts.de/index.php?/pages/midori_summary.html";
		$title=detect_browser_version("Midori");
		$code="midori";
	}
	elseif(preg_match('/Minefield/i', $useragent))
	{
		$link="http://www.mozilla.org/projects/minefield/";
		$title=detect_browser_version("Minefield");
		$code="minefield";
	}
	elseif(preg_match('/MiniBrowser/i', $useragent))
	{
		$link="http://dmkho.tripod.com/";
		$title=detect_browser_version("MiniBrowser");
		$code="minibrowser";
	}
	elseif(preg_match('/Minimo/i', $useragent))
	{
		$link="http://www-archive.mozilla.org/projects/minimo/";
		$title=detect_browser_version("Minimo");
		$code="minimo";
	}
	elseif(preg_match('/Mosaic/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Mosaic_(web_browser)";
		$title=detect_browser_version("Mosaic");
		$code="mosaic";
	}
	elseif(preg_match('/MozillaDeveloperPreview/i', $useragent))
	{
		$link="http://www.mozilla.org/projects/devpreview/releasenotes/";
		$title=detect_browser_version("MozillaDeveloperPreview");
		$code="firefoxdevpre";
	}
	elseif(preg_match('/MQQBrowser/i', $useragent))
	{
		$link="http://browser.qq.com/";
		$title="QQbrowser";
		$code="qqbrowser";
	}
	elseif(preg_match('/Multi-Browser/i', $useragent))
	{
		$link="http://www.multibrowser.de/";
		$title=detect_browser_version("Multi-Browser");
		$code="multi-browserxp";
	}
	elseif(preg_match('/MultiZilla/i', $useragent))
	{
		$link="http://multizilla.mozdev.org/";
		$title=detect_browser_version("MultiZilla");
		$code="mozilla";
	}
	elseif(preg_match('/myibrow/i', $useragent)
		&& preg_match('/My\ Internet\ Browser/i', $useragent))
	{
		$link="http://myinternetbrowser.webove-stranky.org/";
		$title=detect_browser_version("myibrow");
		$code="my-internet-browser";
	}
	elseif(preg_match('/MyIE2/i', $useragent))
	{
		$link="http://www.myie2.com/";
		$title=detect_browser_version("MyIE2");
		$code="myie2";
	}
	elseif(preg_match('/Namoroka/i', $useragent))
	{
		$link="https://wiki.mozilla.org/Firefox/Namoroka";
		$title=detect_browser_version("Namoroka");
		$code="firefoxdevpre";
	}
	elseif(preg_match('/Navigator/i', $useragent))
	{
		$link="http://netscape.aol.com/";
		$title="Netscape ".detect_browser_version("Navigator");
		$code="netscape";
	}
	elseif(preg_match('/NetBox/i', $useragent))
	{
		$link="http://www.netgem.com/";
		$title=detect_browser_version("NetBox");
		$code="netbox";
	}
	elseif(preg_match('/NetCaptor/i', $useragent))
	{
		$link="http://www.netcaptor.com/";
		$title=detect_browser_version("NetCaptor");
		$code="netcaptor";
	}
	elseif(preg_match('/NetFront/i', $useragent))
	{
		$link="http://www.access-company.com/";
		$title=detect_browser_version("NetFront");
		$code="netfront";
	}
	elseif(preg_match('/NetNewsWire/i', $useragent))
	{
		$link="http://www.newsgator.com/individuals/netnewswire/";
		$title=detect_browser_version("NetNewsWire");
		$code="netnewswire";
	}
	elseif(preg_match('/NetPositive/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/NetPositive";
		$title=detect_browser_version("NetPositive");
		$code="netpositive";
	}
	elseif(preg_match('/Netscape/i', $useragent))
	{
		$link="http://netscape.aol.com/";
		$title=detect_browser_version("Netscape");
		$code="netscape";
	}
	elseif(preg_match('/NetSurf/i', $useragent))
	{
		$link="http://www.netsurf-browser.org/";
		$title=detect_browser_version("NetSurf");
		$code="netsurf";
	}
	elseif(preg_match('/NF-Browser/i', $useragent))
	{
		$link="http://www.access-company.com/";
		$title=detect_browser_version("NF-Browser");
		$code="netfront";
	}
	elseif(preg_match('/NokiaBrowser/i', $useragent))
	{
		$link="http://browser.nokia.com/";
		$title="Nokia ".detect_browser_version("Browser");
		$code="nokia";
	}
	elseif(preg_match('/Novarra-Vision/i', $useragent))
	{
		$link="http://www.novarra.com/";
		$title="Novarra ".detect_browser_version("Vision");
		$code="novarra";
	}
	elseif(preg_match('/Obigo/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Obigo_Browser";
		$title=detect_browser_version("Obigo");
		$code="obigo";
	}
	elseif(preg_match('/OffByOne/i', $useragent))
	{
		$link="http://www.offbyone.com/";
		$title="Off By One";
		$code="offbyone";
	}
	elseif(preg_match('/OmniWeb/i', $useragent))
	{
		$link="http://www.omnigroup.com/applications/omniweb/";
		$title=detect_browser_version("OmniWeb");
		$code="omniweb";
	}
	elseif(preg_match('/Opera Mini/i', $useragent))
	{
		$link="http://www.opera.com/mini/";
		$title=detect_browser_version("Opera Mini");
		$code="opera-2";
	}
	elseif(preg_match('/Opera Mobi/i', $useragent))
	{
		$link="http://www.opera.com/mobile/";
		$title=detect_browser_version("Opera Mobi");
		$code="opera-2";
	}
	elseif(preg_match('/Opera Labs/i', $useragent)
		|| (preg_match('/Opera/i', $useragent)
			&& preg_match('/Edition Labs/i', $useragent)))
	{
		$link="http://labs.opera.com/";
		$title=detect_browser_version("Opera Labs");
		$code="opera-next";
	}
	elseif(preg_match('/Opera Next/i', $useragent)
		|| (preg_match('/Opera/i', $useragent)
			&& preg_match('/Edition Next/i', $useragent)))
	{
		$link="http://www.opera.com/support/kb/view/991/";
		$title=detect_browser_version("Opera Next");
		$code="opera-next";
	}
	elseif(preg_match('/Opera/i', $useragent))
	{
		$link="http://www.opera.com/";
		$title=detect_browser_version("Opera");
		$code="opera-1";
		if(preg_match('/Version/i', $useragent))
			$code="opera-2";
	}
	elseif(preg_match('/Orca/i', $useragent))
	{
		$link="http://www.orcabrowser.com/";
		$title=detect_browser_version("Orca");
		$code="orca";
	}
	elseif(preg_match('/Oregano/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Oregano_(web_browser)";
		$title=detect_browser_version("Oregano");
		$code="oregano";
	}
	elseif(preg_match('/Origyn\ Web\ Browser/i', $useragent))
	{
		$link="http://www.sand-labs.org/owb";
		$title="Oregano Web Browser";
		$code="owb";
	}
	elseif(preg_match('/osb-browser/i', $useragent))
	{
		$link="http://gtk-webcore.sourceforge.net/";
		$title=detect_browser_version("osb-browser");
		$code="null";
	}
	elseif(preg_match('/\ Pre\//i', $useragent))
	{
		$link="http://www.palm.com/us/products/phones/pre/index.html";
		$title="Palm ".detect_browser_version("Pre");
		$code="palmpre";
	}
	elseif(preg_match('/Palemoon/i', $useragent))
	{
		$link="http://www.palemoon.org/";
		$title="Pale ".detect_browser_version("Moon");
		$code="palemoon";
	}
	elseif(preg_match('/Patriott\:\:Browser/i', $useragent))
	{
		$link="http://madgroup.x10.mx/patriott1.php";
		$title="Patriott ".detect_browser_version("Browser");
		$code="patriott";
	}
	elseif(preg_match('/Phaseout/i', $useragent))
	{
		$link="http://www.phaseout.net/";
		$title="Phaseout";
		$code="phaseout";
	}
	elseif(preg_match('/Phoenix/i', $useragent))
	{
		$link="http://www.mozilla.org/projects/phoenix/phoenix-release-notes.html";
		$title=detect_browser_version("Phoenix");
		$code="phoenix";
	}
	elseif(preg_match('/Podkicker/i', $useragent))
	{
		$link="http://www.podkicker.com/";
		$title=detect_browser_version("Podkicker");
		$code="podkicker";
	}
	elseif(preg_match('/Podkicker\ Pro/i', $useragent))
	{
		$link="http://www.podkicker.com/";
		$title=detect_browser_version("Podkicker Pro");
		$code="podkicker";
	}
	elseif(preg_match('/Pogo/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/AT%26T_Pogo";
		$title=detect_browser_version("Pogo");
		$code="pogo";
	}
	elseif(preg_match('/Polaris/i', $useragent))
	{
		$link="http://www.infraware.co.kr/eng/01_product/product02.asp";
		$title=detect_browser_version("Polaris");
		$code="polaris";
	}
	elseif(preg_match('/Prism/i', $useragent))
	{
		$link="http://prism.mozillalabs.com/";
		$title=detect_browser_version("Prism");
		$code="prism";
	}
	elseif(preg_match('/QtWeb\ Internet\ Browser/i', $useragent))
	{
		$link="http://www.qtweb.net/";
		$title="QtWeb Internet ".detect_browser_version("Browser");
		$code="qtwebinternetbrowser";
	}
	elseif(preg_match('/QupZilla/i', $useragent))
	{
		$link="http://www.qupzilla.com/";
		$title=detect_browser_version("QupZilla");
		$code="qupzilla";
	}
	elseif(preg_match('/rekonq/i', $useragent))
	{
		$link="http://rekonq.sourceforge.net/";
		$title="rekonq";
		$code="rekonq";
	}
	elseif(preg_match('/retawq/i', $useragent))
	{
		$link="http://retawq.sourceforge.net/";
		$title=detect_browser_version("retawq");
		$code="terminal";
	}
	elseif(preg_match('/RockMelt/i', $useragent))
	{
		$link="http://www.rockmelt.com/";
		$title=detect_browser_version("RockMelt");
		$code="rockmelt";
	}
	elseif(preg_match('/Ryouko/i', $useragent))
	{
		$link="http://sourceforge.net/projects/ryouko/";
		$title=detect_browser_version("Ryouko");
		$code="ryouko";
	}
	elseif(preg_match('/SaaYaa/i', $useragent))
	{
		$link="http://www.saayaa.com/";
		$title="SaaYaa Explorer";
		$code="saayaa";
	}
	elseif(preg_match('/SeaMonkey/i', $useragent))
	{
		$link="http://www.seamonkey-project.org/";
		$title=detect_browser_version("SeaMonkey");
		$code="seamonkey";
	}
	elseif(preg_match('/SEMC-Browser/i', $useragent))
	{
		$link="http://www.sonyericsson.com/";
		$title=detect_browser_version("SEMC-Browser");
		$code="semcbrowser";
	}
	elseif(preg_match('/SEMC-java/i', $useragent))
	{
		$link="http://www.sonyericsson.com/";
		$title=detect_browser_version("SEMC-java");
		$code="semcbrowser";
	}
	elseif(preg_match('/Series60/i', $useragent)
		&& !preg_match('/Symbian/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Web_Browser_for_S60";
		$title="Nokia ".detect_browser_version("Series60");
		$code="s60";
	}
	elseif(preg_match('/S60/i', $useragent)
		&& !preg_match('/Symbian/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Web_Browser_for_S60";
		$title="Nokia ".detect_browser_version("S60");
		$code="s60";
	}
	elseif(preg_match('/SE\ /i', $useragent)
		&& preg_match('/MetaSr/i', $useragent))
	{
		$link="http://ie.sogou.com/";
		$title="Sogou Explorer";
		$code="sogou";
	}
	elseif(preg_match('/Shiira/i', $useragent))
	{
		$link="http://www.shiira.jp/en.php";
		$title=detect_browser_version("Shiira");
		$code="shiira";
	}
	elseif(preg_match('/Shiretoko/i', $useragent))
	{
		$link="http://www.mozilla.org/";
		$title=detect_browser_version("Shiretoko");
		$code="firefoxdevpre";
	}
	elseif(preg_match('/Silk/i', $useragent)
		&& !preg_match('/PlayStation/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Amazon_Silk";
		$title="Amazon ".detect_browser_version("Silk");
		$code="silk";
	}
	elseif(preg_match('/SiteKiosk/i', $useragent))
	{
		$link="http://www.sitekiosk.com/SiteKiosk/Default.aspx";
		$title=detect_browser_version("SiteKiosk");
		$code="sitekiosk";
	}
	elseif(preg_match('/SkipStone/i', $useragent))
	{
		$link="http://www.muhri.net/skipstone/";
		$title=detect_browser_version("SkipStone");
		$code="skipstone";
	}
	elseif(preg_match('/Skyfire/i', $useragent))
	{
		$link="http://www.skyfire.com/";
		$title=detect_browser_version("Skyfire");
		$code="skyfire";
	}
	elseif(preg_match('/Sleipnir/i', $useragent))
	{
		$link="http://www.fenrir-inc.com/other/sleipnir/";
		$title=detect_browser_version("Sleipnir");
		$code="sleipnir";
	}
	elseif(preg_match('/SlimBoat/i', $useragent))
	{
		$link="http://slimboat.com/";
		$title=detect_browser_version("SlimBoat");
		$code="slimboat";
	}
	elseif(preg_match('/SlimBrowser/i', $useragent))
	{
		$link="http://www.flashpeak.com/sbrowser/";
		$title=detect_browser_version("SlimBrowser");
		$code="slimbrowser";
	}
	elseif(preg_match('/SmartTV/i', $useragent))
	{
		$link="http://www.freethetvchallenge.com/details/faq";
		$title=detect_browser_version("SmartTV");
		$code="maplebrowser";
	}
	elseif(preg_match('/Songbird/i', $useragent))
	{
		$link="http://www.getsongbird.com/";
		$title=detect_browser_version("Songbird");
		$code="songbird";
	}
	elseif(preg_match('/Stainless/i', $useragent))
	{
		$link="http://www.stainlessapp.com/";
		$title=detect_browser_version("Stainless");
		$code="stainless";
	}
	elseif(preg_match('/SubStream/i', $useragent))
	{
		$link="http://itunes.apple.com/us/app/substream/id389906706?mt=8";
		$title=detect_browser_version("SubStream");
		$code="substream";
	}
	elseif(preg_match('/Sulfur/i', $useragent))
	{
		$link="http://www.flock.com/";
		$title="Flock ".detect_browser_version("Sulfur");
		$code="flock";
	}
	elseif(preg_match('/Sundance/i', $useragent))
	{
		$link="http://digola.com/sundance.html";
		$title=detect_browser_version("Sundance");
		$code="sundance";
	}
	elseif(preg_match('/Sunrise/i', $useragent))
	{
		$link="http://www.sundialbrowser.com/";
		$title=detect_browser_version("Sundial");
		$code="sundial";
	}
	elseif(preg_match('/Sunrise/i', $useragent))
	{
		$link="http://www.sunrisebrowser.com/";
		$title=detect_browser_version("Sunrise");
		$code="sunrise";
	}
	elseif(preg_match('/Surf/i', $useragent))
	{
		$link="http://surf.suckless.org/";
		$title=detect_browser_version("Surf");
		$code="surf";
	}
	elseif(preg_match('/Swiftfox/i', $useragent))
	{
		$link="http://www.getswiftfox.com/";
		$title=detect_browser_version("Swiftfox");
		$code="swiftfox";
	}
	elseif(preg_match('/Swiftweasel/i', $useragent))
	{
		$link="http://swiftweasel.tuxfamily.org/";
		$title=detect_browser_version("Swiftweasel");
		$code="swiftweasel";
	}
	elseif(preg_match('/Sylera/i', $useragent))
	{
		$link="http://dombla.net/sylera/";
		$title=detect_browser_version("Sylera");
		$code="null";
	}
	elseif(preg_match('/tear/i', $useragent))
	{
		$link="http://wiki.maemo.org/Tear";
		$title="Tear";
		$code="tear";
	}
	elseif(preg_match('/TeaShark/i', $useragent))
	{
		$link="http://www.teashark.com/";
		$title=detect_browser_version("TeaShark");
		$code="teashark";
	}
	elseif(preg_match('/Teleca/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Obigo_Browser/";
		$title=detect_browser_version(" Teleca");
		$code="obigo";
	}
	elseif(preg_match('/TencentTraveler/i', $useragent))
	{
		$link="http://www.tencent.com/en-us/index.shtml";
		$title="Tencent ".detect_browser_version("Traveler");
		$code="tencenttraveler";
	}
	elseif(preg_match('/TenFourFox/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/TenFourFox";
		$title=detect_browser_version("TenFourFox");
		$code="tenfourfox";
	}
	elseif(preg_match('/TheWorld/i', $useragent))
	{
		$link="http://www.ioage.com/";
		$title="TheWorld Browser";
		$code="theworld";
	}
	elseif(preg_match('/Thunderbird/i', $useragent))
	{
		$link="http://www.mozilla.com/thunderbird/";
		$title=detect_browser_version("Thunderbird");
		$code="thunderbird";
	}
	elseif(preg_match('/Tizen/i', $useragent))
	{
		$link="https://www.tizen.org/";
		$title=detect_browser_version("Tizen");
		$code="tizen";
	}
	elseif(preg_match('/Tjusig/i', $useragent))
	{
		$link="http://www.tjusig.cz/";
		$title=detect_browser_version("Tjusig");
		$code="tjusig";
	}
	elseif(preg_match('/TencentTraveler/i', $useragent))
	{
		$link="http://tt.qq.com/";
		$title=detect_browser_version("TencentTraveler");
		$code="tt-explorer";
	}
	elseif(preg_match('/uBrowser/i', $useragent))
	{
		$link="http://www.ubrowser.com/";
		$title=detect_browser_version("uBrowser");
		$code="ubrowser";
	}
	elseif(preg_match('/UC\ Browser/i', $useragent))
	{
		$link="http://www.uc.cn/English/index.shtml";
		$title=detect_browser_version("UC Browser");
		$code="ucbrowser";
	}
	elseif(preg_match('/UCWEB/i', $useragent))
	{
		$link="http://www.ucweb.com/English/product.shtml";
		$title=detect_browser_version("UCWEB");
		$code="ucweb";
	}
	elseif(preg_match('/UltraBrowser/i', $useragent))
	{
		$link="http://www.ultrabrowser.com/";
		$title=detect_browser_version("UltraBrowser");
		$code="ultrabrowser";
	}
	elseif(preg_match('/UP.Browser/i', $useragent))
	{
		$link="http://www.openwave.com/";
		$title=detect_browser_version("UP.Browser");
		$code="openwave";
	}
	elseif(preg_match('/UP.Link/i', $useragent))
	{
		$link="http://www.openwave.com/";
		$title=detect_browser_version("UP.Link");
		$code="openwave";
	}
	elseif(preg_match('/Usejump/i', $useragent))
	{
		$link="http://www.usejump.com/";
		$title=detect_browser_version("Usejump");
		$code="usejump";
	}
	elseif(preg_match('/uZardWeb/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/UZard_Web";
		$title=detect_browser_version("uZardWeb");
		$code="uzardweb";
	}
	elseif(preg_match('/uZard/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/UZard_Web";
		$title=detect_browser_version("uZard");
		$code="uzardweb";
	}
	elseif(preg_match('/uzbl/i', $useragent))
	{
		$link="http://www.uzbl.org/";
		$title="uzbl";
		$code="uzbl";
	}
	elseif(preg_match('/Vimprobable/i', $useragent))
	{
		$link="http://www.vimprobable.org/";
		$title=detect_browser_version("Vimprobable");
		$code="null";
	}
	elseif(preg_match('/Vonkeror/i', $useragent))
	{
		$link="http://zzo38computer.cjb.net/vonkeror/";
		$title=detect_browser_version("Vonkeror");
		$code="null";
	}
	elseif(preg_match('/w3m/i', $useragent))
	{
		$link="http://w3m.sourceforge.net/";
		$title=detect_browser_version("W3M");
		$code="w3m";
	}
	elseif(preg_match('/AppleWebkit/i', $useragent)
		&& preg_match('/Android/i', $useragent)
		&& !preg_match('/Chrome/i', $useragent))
	{
		$link="http://developer.android.com/reference/android/webkit/package-summary.html";
		$title=detect_browser_version("Android Webkit");
		$code="android-webkit";
	}
	elseif(preg_match('/WebianShell/i', $useragent))
	{
		$link="http://webian.org/shell/";
		$title="Webian ".detect_browser_version("Shell");
		$code="webianshell";
	}
	elseif(preg_match('/Webrender/i', $useragent))
	{
		$link="http://webrender.99k.org/";
		$title="Webrender";
		$code="webrender";
	}
	elseif(preg_match('/WeltweitimnetzBrowser/i', $useragent))
	{
		$link="http://weltweitimnetz.de/software/Browser.en.page";
		$title="Weltweitimnetz ".detect_browser_version("Browser");
		$code="weltweitimnetzbrowser";
	}
	elseif(preg_match('/wKiosk/i', $useragent))
	{
		$link="http://www.app4mac.com/store/index.php?target=products&product_id=9";
		$title="wKiosk";
		$code="wkiosk";
	}
	elseif(preg_match('/WorldWideWeb/i', $useragent))
	{
		$link="http://www.w3.org/People/Berners-Lee/WorldWideWeb.html";
		$title=detect_browser_version("WorldWideWeb");
		$code="worldwideweb";
	}
	elseif(preg_match('/wp-android/i', $useragent))
	{
		$link="http://android.wordpress.org/";
		$title=detect_browser_version("wp-android");
		$code="wordpress";
	}
	elseif(preg_match('/wp-blackberry/i', $useragent))
	{
		$link="http://blackberry.wordpress.org/";
		$title=detect_browser_version("wp-blackberry");
		$code="wordpress";
	}
	elseif(preg_match('/wp-iphone/i', $useragent))
	{
		$link="http://ios.wordpress.org/";
		$title=detect_browser_version("wp-iphone");
		$code="wordpress";
	}
	elseif(preg_match('/wp-nokia/i', $useragent))
	{
		$link="http://nokia.wordpress.org/";
		$title=detect_browser_version("wp-nokia");
		$code="wordpress";
	}
	elseif(preg_match('/wp-webos/i', $useragent))
	{
		$link="http://webos.wordpress.org/";
		$title=detect_browser_version("wp-webos");
		$code="wordpress";
	}
	elseif(preg_match('/wp-windowsphone/i', $useragent))
	{
		$link="http://windowsphone.wordpress.org/";
		$title=detect_browser_version("wp-windowsphone");
		$code="wordpress";
	}
	elseif(preg_match('/Wyzo/i', $useragent))
	{
		$link="http://www.wyzo.com/";
		$title=detect_browser_version("Wyzo");
		$code="Wyzo";
	}
	elseif(preg_match('/X-Smiles/i', $useragent))
	{
		$link="http://www.xsmiles.org/";
		$title=detect_browser_version("X-Smiles");
		$code="x-smiles";
	}
	elseif(preg_match('/Xiino/i', $useragent))
	{
		$link="#";
		$title=detect_browser_version("Xiino");
		$code="null";
	}
	elseif(preg_match('/YaBrowser/i', $useragent))
	{
		$link="http://browser.yandex.com/";
		$title="Yandex.".detect_browser_version("Browser");
		$code="yandex";
	}
	elseif(preg_match('/zBrowser/i', $useragent))
	{
		$link="http://sites.google.com/site/zeromusparadoxe01/zbrowser";
		$title=detect_browser_version("zBrowser");
		$code="zbrowser";
	}
	elseif(preg_match('/ZipZap/i', $useragent))
	{
		$link="http://www.zipzaphome.com/";
		$title=detect_browser_version("ZipZap");
		$code="zipzap";
	}

	// Pulled out of order to help ensure better detection for above browsers
	elseif(preg_match('/ABrowse/i', $useragent))
	{
		$link="http://abrowse.sourceforge.net/";
		$title=detect_browser_version("ABrowse");
		$code="abrowse";
	}
	elseif(preg_match('/Chrome/i', $useragent))
	{
		$link="http://google.com/chrome/";
		$title="Google ".detect_browser_version("Chrome");
		$code="chrome";
	}
	elseif(preg_match('/Safari/i', $useragent)
		&& !preg_match('/Nokia/i', $useragent))
	{
		$link="http://www.apple.com/safari/";
		$title="Safari";

		if(preg_match('/Version/i', $useragent))
		{
			$title=detect_browser_version("Safari");
		}
		
		if(preg_match('/Mobile Safari/i', $useragent))
		{
			$title="Mobile ".$title;
		}

		$code="safari";
	}
	elseif(preg_match('/Nokia/i', $useragent))
	{
		$link="http://www.nokia.com/browser";
		$title="Nokia Web Browser";
		$code="maemo"; 
	}
	elseif(preg_match('/Firefox/i', $useragent))
	{
		$link="http://www.mozilla.org/";
		$title=detect_browser_version("Firefox");
		$code="firefox";
	}
	elseif(preg_match('/MSIE/i', $useragent))
	{
		$link="http://www.microsoft.com/windows/products/winfamily/ie/default.mspx";
		$title="Internet Explorer".detect_browser_version("MSIE");
		
		preg_match('/MSIE[\ |\/]?([.0-9a-zA-Z]+)/i', $useragent, $regmatch);

		if($regmatch[1]>=10)
		{
			$code="msie10";
		}
		elseif($regmatch[1]>=9)
		{
			$code="msie9";
		}
		elseif($regmatch[1]>=7)
		{
			// also ie8
			$code="msie7";
		}
		elseif($regmatch[1]>=6)
		{
			$code="msie6";
		}
		elseif($regmatch[1]>=4)
		{
			// also ie5
			$code="msie4";
		}
		elseif($regmatch[1]>=3)
		{
			$code="msie3";
		}
		elseif($regmatch[1]>=2)
		{
			$code="msie2";
		}
		elseif($regmatch[1]>=1)
		{
			$code="msie1";
		}
		else
		{
			$code="msie";
		}
	}
	elseif(preg_match('/Mozilla/i', $useragent))
	{
		$link="http://www.mozilla.org/";
		$title="Mozilla Compatible";

		if(preg_match('/rv:([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title="Mozilla ".$regmatch[1];
		}

		$code="mozilla";
	}
	else
	{
		return '';
	}

	return '<img src="/browser/browsers/'.$code.'.png" title="'.$title.'" class="i1" /> ';
}

?>
