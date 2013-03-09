<?php
header('Content-Type: text/html; charset=UTF-8');

include 'libs/pear/Net/DNS2.php';
include 'libs/geoip/geoipcity.inc';
include 'libs/geoip/geoipregionvars.php';
include 'libs/ip2loc/ip2location.class.php';
include 'libs/wpua/wp-useragent.php';
include 'utils.php';
include 'services.php';
include 'tunnelbrokers.php';

$servname = preg_replace('#^ipv[64]\.#', null, $_SERVER['SERVER_NAME']);
if(is_ipv6($servname)){
	define('DUALSTACK_DOMAIN', '['.$servname.']');
	define('IPV4_DOMAIN', resolve_host(reverse_lookup($servname), 'A'));
	define('IPV6_DOMAIN', $servname);
} else if(is_ipv4($servname)){
	define('DUALSTACK_DOMAIN', $servname);
	define('IPV4_DOMAIN', $servname);
	define('IPV6_DOMAIN', '['.resolve_host(reverse_lookup($servname), 'AAAA').']');
} else {
	define('DUALSTACK_DOMAIN', $servname);
	define('IPV4_DOMAIN', 'ipv4.'.$servname);
	define('IPV6_DOMAIN', 'ipv6.'.$servname);
}

define('SCRIPT_PATH', '/browser/');

if(!empty($_GET['l'])){
	print '<style>*{background:#333;color:white}pre{font-family:Consolas,"Droid Sans Mono","DejaVu Sans Mono","Bitstream Vera Sans Mono","Lucida Console",Monaco,monospace;font-size:11pt}</style>';
	die('<pre>'.htmlspecialchars(@shell_exec('whois -dB '.escapeshellarg($_GET['l']))).'</pre>');
}

if(!empty($_GET['p']) && is_array($_GET['p'])){
	header('Content-Type: text/javascript; charset=UTF-8');
	
	foreach($_GET['p'] as $idx => $oip){
		$ip = inet_ntop(base64_decode($oip));
		$pr = is_proxy_dnsbl($ip);
		
		if($pr === null || $pr === false){
			$pr = is_proxy_google($ip);
		}
		
		if($pr !== null && $pr !== false){
			$var = dechex((int)$idx + 10);
			print 'var '.$var.'=[].concat($(\'.ip\')).pop()['.((int)$idx).'].parentNode;'.$var.'.innerHTML=\'<img src="//'.DUALSTACK_DOMAIN.SCRIPT_PATH.'other/proxy.png" title="Anonymous proxy detected: '.$pr.'" class="i1" /> \'+'.$var.'.innerHTML;';
		}
	}
	
	die();
}

//$_SERVER['REMOTE_ADDR'] = '79.119.215.229'; // ipv4
//$_SERVER['REMOTE_ADDR'] = '2a02:2f02:9020:e0ee:70:e190:c11d:2634'; // ipv6
//$_SERVER['REMOTE_ADDR'] = '2002:4f77:d7e5::1'; // 6to4
//$_SERVER['REMOTE_ADDR'] = '2001::4136:e378:8000:63bf:3fff:fdd2'; // teredo
//$_SERVER['REMOTE_ADDR'] = 'fe80::0200:5efe:4f77:d7e5'; // link-local
//$_SERVER['REMOTE_ADDR'] = '64:ff9b::79.119.215.229'; // nat64
//$_SERVER['REMOTE_ADDR'] = '2607:f298:1:105::8d8:796c'; // ipv6 us-dh
//$_SERVER['REMOTE_ADDR'] = '2001:470:28:744::1'; // ipv6 tunnel
//$_SERVER['REMOTE_ADDR'] = '2001:388:f000::2d'; // ipv6 tunnel 2
//$_SERVER['REMOTE_ADDR'] = '89.218.94.166'; // anonymous proxy
//$_SERVER['REMOTE_ADDR'] = '173.224.119.174'; // anonymous proxy
//$_SERVER['REMOTE_ADDR'] = '2002:ade0:77ae::1'; // 6to4 anonymous proxy
//$_SERVER['REMOTE_ADDR'] = '85.31.186.67'; // i2p
//$_SERVER['REMOTE_ADDR'] = '94.103.170.236'; // tor
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '69.163.231.16'; // ipv4 proxy
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '2607:f298:1:105::8d8:796c'; // ipv6 proxy
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '89.218.94.166'; // anonymous proxy
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '2002:59da:5ea6::1'; // 6to4 anonymous proxy

$addr  = $_SERVER['REMOTE_ADDR'];
$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];

if(!$proxy && $_SERVER['HTTP_VIA'] && preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $_SERVER['HTTP_VIA'], $mvia)) $proxy = $mvia[0];
if($_SERVER['HTTP_CLIENT_IP']) $proxy = $_SERVER['HTTP_CLIENT_IP'];
if($_SERVER['HTTP_X_CODEMUX_CLIENT']) $proxy = $_SERVER['HTTP_X_CODEMUX_CLIENT'];

$gi   = geoip_open('geodb/GeoLiteCity.dat', GEOIP_STANDARD);
$gi6  = geoip_open('geodb/GeoLiteCityv6.dat', GEOIP_STANDARD);
$gia  = geoip_open('geodb/GeoIPASNum.dat', GEOIP_ASNUM_EDITION);
$gia6 = geoip_open('geodb/GeoIPASNumv6.dat', GEOIP_ASNUM_EDITION_V6);

$li = new ip2location();
$li->open('geodb/IP-COUNTRY-REGION-CITY-ISP.BIN');
$li6 = new ip2location();
$li6->open('geodb/IPV6-COUNTRY.BIN');

if(isset($_GET['4'])){
	header('Content-Type: text/javascript; charset=UTF-8');
	
	if(is_ipv6($addr)){
		die('/* This function can only be accessed from an IPv4-only domain. */');
	}
	
	print '[].concat($(\'.ip\')).pop()[0].parentNode.innerHTML+=\' <span class="s">/</span> '.process_ip($addr, !empty($proxy)).'\';';
	
	$host = reverse_lookup($addr);
	if($host == $addr) $uhost = $host = reverse_address($addr, true);
	
	print '[].concat($(\'.host\')).pop()[0].parentNode.innerHTML+=\' <span class="s">/</span> <span class="host"'.($uhost?' style="color:gray"':'').'>'.$host.'</span>\';';
	
	if(isset($_GET['g'])){
		$gip = geoip_record_by_addr($gi, !empty($proxy) && $_GET['g'] == 1 ? $proxy : $addr);
		$ip = $gip->country_name.', '.capitalize_words($GEOIP_REGION_NAME[$gip->country_code][$gip->region]).', '.capitalize_words($gip->city);
		$ip = str_replace(', , ', ', ', rtrim($ip, ' ,'));
		$alt = $gip->country_name;
		$cc = strtolower($gip->country_code);
		
		if((empty($ip) || strpos($ip, ',') === false) && $li != null){
			$lip = $li->getAll($addr);
			
			if($lip->ipAddress != 'Invalid IP address.'){
				$alt = strtolower($lip->countryShort);
				$cc = capitalize_words(strtolower($lip->countryLong));
				$ip = capitalize_words(strtolower($lip->countryLong)).', '.capitalize_words(strtolower($lip->region)).', '.capitalize_words(strtolower($lip->city));
				$ip = str_replace(', -, ', ', ', rtrim($ip, ' -,'));
			}
		}
		
		print '$(\'.geoip\')['.((int)$_GET['g']).'].innerHTML=\''.$ip.'\';var a=$(\'.flag\')['.((int)$_GET['g']).'];a.src=\'//'.DUALSTACK_DOMAIN.SCRIPT_PATH.'flags/'.$cc.'.png\';a.title=\''.$alt.'\';document.title=document.title.replace(/GeoIP: [^$]+/, \'GeoIP: '.$ip.'\');';
	}
	
	if(isset($_GET['i'])){
		$isp = geoip_name_by_addr($gia, !empty($proxy) && $_GET['i'] == 1 ? $proxy : $addr);
		
		if(empty($isp)){
			list($cyas, , $cycc, , ) = explode(' | ', get_dns_txt(reverse_address(!empty($proxy) && $_GET['i'] == 1 ? $proxy : $addr).'.origin.asn.cymru.com'));
			list(, , , , $cyisp) = explode(' | ', get_dns_txt('as'.$cyas.'.asn.cymru.com'));
			
			if(!empty($cyas) && !empty($cyisp)){
				$isp = 'AS'.$cyas.' '.preg_replace('#^[^\s]+\s#', '', $cyisp);
			}
		}
		
		if(!empty($isp)){
			$isp = explode(' ', $isp, 2);
			print '$(\'.asnum\')['.((int)$_GET['i']).'].innerHTML=\'<a href="http://bgp.he.net/'.$isp[0].'">'.$isp[0].'</a>\';$(\'.isp\')['.((int)$_GET['i']).'].innerHTML=\''.$isp[1].'\';';
		}
	}
	
	die();
}

print '<meta name="HandheldFriendly" content="true" /><meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" /><style>*{margin:0}.c{color:black;font-family:Cambria;width:100%;height:205px;text-align:center;position:absolute;top:50%;margin:-100px auto 0px auto}.s{font-weight:bold}h1.s{font-size:28pt}h2.s{font-size:18pt}.i1{margin-bottom:-4px}.i2{margin-bottom:-3px}.in{margin-bottom:0px}.ib{margin-bottom:-5px}a{color:black;text-decoration:none}.asnum a{color:lightslategray;text-decoration:none}a:hover{border-bottom:1px dotted black}@media screen and (max-width:800px){h1,h2,h3{font-size:16px !important}h2,h3{font-weight:normal}img{height:21px;width:21px;margin-bottom:-4px !important}}</style><script>function $(a,b){return(b||document).querySelectorAll(a)}</script>';

if(is_ipv6($addr)){
	$v4scripts = '?4';
}

print '<div class="c">';
print '<h1>';
	print process_ip($addr, !empty($proxy));
	if(is_ipv6($addr) && list($tun, $v4) = is_tunnel($addr)){
		$addr = $v4;
		print ' <img src="'.SCRIPT_PATH.'other/arrow-s.png" class="in" title="'.$tun.' tunnel destination" /> '.process_ip($addr);
	}
	
	if(!empty($proxy)){
		print ' <img src="'.SCRIPT_PATH.'other/arrow.png" class="i1" title="X-Forwarded-For" /> '.process_ip($proxy);
		if(is_ipv6($proxy) && list($tun, $v4pr) = is_tunnel($proxy)){
			$proxy = $v4pr;
			print ' <img src="'.SCRIPT_PATH.'other/arrow-s.png" class="in" title="'.$tun.' tunnel destination" /> '.process_ip($proxy);
		}
	}
print '</h1>';

print '<h2>';
	$host = reverse_lookup($addr);
	if($host == $addr) $uhost = $host = reverse_address($addr, true);
	
	print '<span class="host"'.($uhost?' style="color:gray"':'').'>'.$host.'</span>';
	
	if($proxy){
		$prhost = reverse_lookup($proxy);
		if($prhost == $proxy) $uprhost = $prhost = reverse_address($proxy, true);
		
		print ' <img src="'.SCRIPT_PATH.'other/arrow-s.png" class="xforwardedfor i2" title="X-Forwarded-For" /> <span class="host"'.($uprhost?' style="color:gray"':'').'>'.$prhost.'</span>';
	}
print '</h2><br />';

print '<h2>';
	print lookup_isp($addr);
	
	if($proxy){
		print ' <img src="'.SCRIPT_PATH.'other/arrow-s.png" class="xforwardedfor i2" title="X-Forwarded-For" /> '.lookup_isp($proxy, 1);
	}
print '</h2><br />';

print '<h2>';
	print $geoip = lookup_ip($addr);
	if($proxy) print ' <img src="'.SCRIPT_PATH.'other/arrow-s.png" class="i2" title="X-Forwarded-For" /> '.lookup_ip($proxy, 1);
print '</h2><br />';

print '<h3>';
	print detect_platform();
	print detect_webbrowser();
	print $_SERVER['HTTP_USER_AGENT'];
print '</h3>';
print '</div>';

print '<title>IP: '.$addr.', GeoIP: '.trim(strip_tags($geoip)).'</title>';

if($scripts != null){
	print '<script defer src="'.SCRIPT_PATH.$scripts.'"></script>';
}
if($v4scripts != null){
	print '<script defer src="//'.IPV4_DOMAIN.SCRIPT_PATH.$v4scripts.'"></script>';
}
if($v6scripts != null){
	print '<script defer src="//'.IPV6_DOMAIN.SCRIPT_PATH.$v6scripts.'"></script>';
}

geoip_close($gi);

function process_ip($addr, $xfwd = false){
	global $ipidx;
	
	if($ipidx === null){
		$ipidx = 0;
	} else {
		$ipidx++;
	}
	
	$v6 = is_ipv6($addr);
	
	$ret = '<span>';
	
	if($v6 && $tun = is_tunnel_broker($addr)){
		if(!isset($tun['icon'])) $tun['icon'] = 'tunnel.png';
		$ret .= '<img src="'.SCRIPT_PATH.'other/'.$tun['icon'].'" title="'.$tun['name'].' IPv6 tunnel" class="i1" /> ';
	}
	
	if($tr = is_tor($addr)){
		$ret .= '<img src="'.SCRIPT_PATH.'other/tor.png" title="TOR exit node" class="tor i1" /> ';
	}
	
	if(!$tr && $tr = is_i2p($addr)){
		$ret .= '<img src="'.SCRIPT_PATH.'other/i2p.png" title="I2P outproxy" class="i2p i1" /> ';
	}
	
	if($op = is_opturbo($addr)){
		$ret .= '<img src="'.SCRIPT_PATH.'other/turbo.png" class="operaturbo ib" title="Opera Turbo proxy" /> ';
	}
	
	if($pl = is_planetlab($addr)){
		$ret .= '<img src="'.SCRIPT_PATH.'other/planetlab.png" class="planetlab ib" title="PlanetLab proxy" /> ';
	}
	
	if(!$tr && !$op && !$pl && $xfwd){
		$ret .= '<img src="'.SCRIPT_PATH.'other/proxy.png" title="Proxy detected" class="i1" /> ';
	}
	
	if(!$tr && !$op && !$pl && !$v6){
		$pr = is_proxy_cached($addr);
		
		if($pr !== null && $pr !== false){
			$ret .= '<img src="'.SCRIPT_PATH.'other/proxy.png" title="Anonymous proxy detected: '.$pr.'" class="i1" /> ';
		}
	}
	
	if(!$tr && !$op && !$pl && !$v6 && $pr === null){
		is_proxy($addr, $ipidx);
	}
	
	$ret .= '<span class="ip"><a href="'.SCRIPT_PATH.'?l='.$addr.'">'.$addr.'</a></span></span>';
	
	return $ret;
}

function lookup_ip($addr, $idx = 0){
	global $gi, $gi6, $li, $li6, $GEOIP_REGION_NAME, $v4scripts;
	
	$v6 = is_ipv6($addr);
	$s2 = false;
	
   lookup:
	if($v6){
		$gip = geoip_record_by_addr_v6($gi6, $addr);
	} else {
		$gip = geoip_record_by_addr($gi, $addr);
	}
	
	if(file_exists('flags/'.strtolower($gip->country_code).'.png')){
		$flag = '<img class="flag i1" src="'.SCRIPT_PATH.'flags/'.strtolower($gip->country_code).'.png" title="'.$gip->country_name.'" /> ';
	}
	
	$ip = $gip->country_name.', '.capitalize_words($GEOIP_REGION_NAME[$gip->country_code][$gip->region]).', '.capitalize_words($gip->city);
	$ip = str_replace(', , ', ', ', rtrim($ip, ' ,'));
	
	if((empty($ip) || (!$v6 && strpos($ip, ',') === false)) && $li != null && $li6 != null){
		if($v6){
			$lip = $li6->getAll($addr);
		} else {
			$lip = $li->getAll($addr);
		}
		
		if($lip->ipAddress != 'Invalid IP address.'){
			if(file_exists('flags/'.strtolower($lip->countryShort).'.png')){
				$flag = '<img class="flag i1" src="'.SCRIPT_PATH.'flags/'.strtolower($lip->countryShort).'.png" title="'.capitalize_words(strtolower($lip->countryLong)).'" /> ';
			}
			
			$ip = capitalize_words(strtolower($lip->countryLong));
			
			if(!$v6){
				$ip .= ', '.capitalize_words(strtolower($lip->region)).', '.capitalize_words(strtolower($lip->city));
			}
			
			$ip = str_replace(', -, ', ', ', rtrim($ip, ' -,'));
		}
	}
	
	if(!empty($ip)){
		$ip = $flag.'<span class="geoip">'.$ip.'</span>';
	}

	if(!$s2 && empty($ip)){
		$s2 = true;
		
		$host = reverse_lookup($addr);
		
		if(!$v6){
			$ip2  = resolve_host($host);
		}
		
		if(!$v6 && $host != $ip2){
			$addr = $ip2;
		} else {
			if(preg_match('/^(?:\w+:\/\/)?[^:?#\/\s]*?([^.\s]+\.(?:[a-z]{2,}|co\.uk|org\.uk|ac\.uk|org\.au|com\.au))(?:[:?#\/]|$)/i', $host, $m)){
				if($m[1]){
					$ip2 = resolve_host($m[1]);
					
					if($ip2 != $m[1]){
						$addr = $ip2;
					}
				}
			}
		}
		
		goto lookup;
	}
	
	if(empty($ip)){	
		$ip = ' <img class="flag i1" src="'.SCRIPT_PATH.'browsers/null.png" title="GeoIP lookup failed" /> <span class="geoip"><span style="color:gray">Reserved</span></span>';
	}
	
	if($v6 && !empty($gip->country_name) && empty($gip->city)){
		if($v4scripts == null){
			$v4scripts = '?4';
		}
		
		$v4scripts .= '&g='.$idx;
	}
	
	return $ip;
}

function lookup_isp($addr, $idx = 0){
	global $gia, $gia6, $v4scripts;
	
	$v6 = is_ipv6($addr);
	$s2 = false;
	
   lookup:
	if($v6){
		$isp = geoip_name_by_addr_v6($gia6, $addr);
	} else {
		$isp = geoip_name_by_addr($gia, $addr);
	}
	
	if(empty($isp)){
		list($cyas, , $cycc, , ) = explode(' | ', get_dns_txt(reverse_address($addr).'.origin'.($v6?'6':'').'.asn.cymru.com'));
		list(, , , , $cyisp) = explode(' | ', get_dns_txt('as'.$cyas.'.asn.cymru.com'));

		if(!empty($cyas) && !empty($cyisp)){
			$isp = 'AS'.$cyas.' '.preg_replace('#^[^\s]+\s#', '', $cyisp);
		}
	}

	if(!empty($isp)){
		$isp = explode(' ', $isp, 2);
		$isp = '<span class="asnum"><a href="http://bgp.he.net/'.$isp[0].'">'.$isp[0].'</a></span> <span class="isp">'.$isp[1].'</span>';
	}
	
	if(!$s2 && empty($isp)){
		$s2 = true;
		
		$host = reverse_lookup($addr);
		
		if(!$v6){
			$ip2  = resolve_host($host);
		}
		
		if(!$v6 && $host != $ip2){
			$addr = $ip2;
		} else {
			if(preg_match('/^(?:\w+:\/\/)?[^:?#\/\s]*?([^.\s]+\.(?:[a-z]{2,}|co\.uk|org\.uk|ac\.uk|org\.au|com\.au))(?:[:?#\/]|$)/i', $host, $m)){
				if($m[1]){
					$ip2 = resolve_host($m[1]);
					
					if($ip2 != $m[1]){
						$addr = $ip2;
					}
				}
			}
		}
		
		goto lookup;
	}
	
	if(empty($isp)){
		$isp = '<span class="asnum"></span> <span class="isp"><span style="color:gray">Unknown ISP</span></span>';
		
		if($v6){
			if($v4scripts == null){
				$v4scripts = '?4';
			}
			
			$v4scripts .= '&i='.$idx;
		}
	}
	
	return $isp;
}
?>