<?php
header('Content-Type: text/html; charset=UTF-8');

if(!empty($_GET['lookup'])){
	die('<pre>'.@shell_exec('whois -d '.escapeshellarg($_GET['lookup'])).'</pre>');
}

if(!empty($_GET['whois'])){
	$chip  = inet_ntop(base64_decode($_GET['whois']));
	$whois = @whois($chip);
	
	if($whois['country'][0]) $country = $whois['country'][0];
	if($whois['org-name'][0]) $isp = $whois['org-name'][0];
	if(!$isp && $whois['orgname'][0]) $isp = $whois['orgname'][0];
	
	if($country){
		include 'libs/geoip/geoip.inc';
		$gi = new GeoIP();
		$cname = $gi->GEOIP_COUNTRY_NAMES[$gi->GEOIP_COUNTRY_CODE_TO_NUMBER[strtoupper(trim($country))]];
	}
	
	if(isset($_GET['isp']) && $isp){
		print 'document.getElementsByClassName(\'isp\')['.((int)$_GET['isp']).'].innerHTML=\''.$isp.'\';';
	}
	
	if(isset($_GET['geoip']) && $cname){
		print 'document.getElementsByClassName(\'geoip\')['.((int)$_GET['geoip']).'].innerHTML=\''.$cname.'\';var a=document.getElementsByClassName(\'flag\')['.((int)$_GET['geoip']).'];a.src=\'/browser/flags/'.strtolower($country).'.png\';a.title=\''.$cname.'\';document.title=document.title.replace(\'GeoIP: Reserved\', \'GeoIP: '.$cname.'\');';
	}
	
	die();
}

if(!empty($_GET['is_proxy'])){
	$prst = 'document.getElementsByClassName(\'placeholder\')['.((int)$_GET['placeholder']).'].innerHTML=\'<img src="http://rolisoft.net/browser/other/proxy.png" title="Anonymous proxy detected" class="i1" /> \';';
	$chip = inet_ntop(base64_decode($_GET['is_proxy']));
	$ispr = is_proxy_db($chip);
	
	//print '/*'.$ispr.'*/';
	
	if($ispr == 1){
		print $prst;
	} else if($ispr == -1){
		/*$bing1 = @json_decode(@file_get_contents('http://api.bing.net/json.aspx?AppId=072CCFDBC52FB4552FF96CE87A95F8E9DE30C37B&Query='.urlencode('"'.$chip.'" intitle:proxy').'&Sources=Web&Version=2.0&Market=en-us&Adult=Off&Web.Count=1&Web.Offset=0&Web.Options=DisableHostCollapsing'), true);
		$bing2 = @json_decode(@file_get_contents('http://api.bing.net/json.aspx?AppId=072CCFDBC52FB4552FF96CE87A95F8E9DE30C37B&Query='.urlencode('"'.$chip.'" intitle:proxies').'&Sources=Web&Version=2.0&Market=en-us&Adult=Off&Web.Count=1&Web.Offset=0&Web.Options=DisableHostCollapsing'), true);
		$found = $bing1['SearchResponse']['Web']['Total'] != 0 || $bing2['SearchResponse']['Web']['Total'] != 0;*/
		
		$google = json_decode(file_get_contents('http://www.google.com/uds/GwebSearch?context=0&lstkp=0&rsz=small&hl=en&source=gsc&gss=.com&sig=22c4e39868158a22aac047a2c138a780&q='.urlencode('"'.$chip.'" intitle:proxy || intitle:proxies').'&gl=www.google.com&qid=12a9cb9d0a6870d28&key=AIzaSyA5m1Nc8ws2BbmPRwKu5gFradvD_hgq6G0&v=1.0'), true);
		$found = count($google['responseData']['results']) != 0;
		
		$db->exec('insert into list values ( '.ip2long($chip).', '.($found?1:0).' )');
		
		if($found){
			print $prst;
		}
	}
	
	die();
}

//$_SERVER['REMOTE_ADDR'] = '79.119.215.229';
//$_SERVER['REMOTE_ADDR'] = '2002:4f77:d54e::4f77:d54e';
//$_SERVER['REMOTE_ADDR'] = '2607:f298:1:105::8d8:796c';
//$_SERVER['REMOTE_ADDR'] = '2a02:2f02:9021:f00d::567d:bf36';
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '69.163.231.16';
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '2002:0:0:0:0:0:d9d4:e60e';

$addr  = $_SERVER['REMOTE_ADDR'];
$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];

if(!$proxy && $_SERVER['HTTP_VIA'] && preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $_SERVER['HTTP_VIA'], $mvia)) $proxy = $mvia[0];
if($_SERVER['HTTP_CLIENT_IP']) $proxy = $_SERVER['HTTP_CLIENT_IP'];
if($_SERVER['HTTP_X_CODEMUX_CLIENT']) $proxy = $_SERVER['HTTP_X_CODEMUX_CLIENT'];

print '<meta name="HandheldFriendly" content="true" /><meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" /><style>*{margin:0}.c{color:black;font-family:Cambria;width:100%;height:205px;text-align:center;position:absolute;top:50%;margin:-100px auto 0px auto}.i1{margin-bottom:-4px}.i2{margin-bottom:-3px}.in{margin-bottom:0px}.ib{margin-bottom:-5px}.ip a{color:black;text-decoration:none}.asnum a{color:lightslategray;text-decoration:none}a:hover{border-bottom:1px dotted black}@media screen and (max-width:800px){h1,h2,h3{font-size:16px !important}h2,h3{font-weight:normal}img{height:21px;width:21px;margin-bottom:-4px !important}}</style>';

include 'libs/wpua/wp-useragent.php';
include 'libs/geoip/geoipcity.inc';
include 'libs/geoip/geoipregionvars.php';
include 'libs/pear/Net/DNS2.php';
$gi   = geoip_open('geodb/GeoLiteCity.dat', GEOIP_STANDARD);
$gi6  = geoip_open('geodb/GeoLiteCityv6.dat', GEOIP_STANDARD);
$gia  = geoip_open('geodb/GeoIPASNum.dat', GEOIP_ASNUM_EDITION);
$gia6 = geoip_open('geodb/GeoIPASNumv6.dat', GEOIP_ASNUM_EDITION_V6);

$proxycheck = 0;

print '<div class="c">';
print '<h1>';
	print process_ip($addr, !empty($proxy));
	if(is_ipv6($addr) && $v4 = v6to4($addr)){
		$addr = $v4;
		print ' <img src="/browser/other/arrow-s.png" class="in" title="6to4 tunnel destination" /> '.process_ip($addr);
	}
	
	if(!empty($proxy)){
		print ' <img src="/browser/other/arrow.png" class="i1" title="X-Forwarded-For" /> '.process_ip($proxy);
		if(is_ipv6($proxy) && $v4pr = v6to4($proxy)){
			$proxy = $v4pr;
			print ' <img src="/browser/other/arrow-s.png" class="in" title="6to4 tunnel destination" /> '.process_ip($proxy);
		}
	}
print '</h1>';

print '<h2>';
	$host = gethostbyaddrc($addr);
	if($host == $addr) $uhost = $host = revaddr($addr, true);
	
	print '<span class="host"'.($uhost?' style="color:gray"':'').'>'.$host.'</span>';
	
	if($proxy){
		$prhost = gethostbyaddrc($proxy);
		if($prhost == $proxy) $uprhost = $prhost = revaddr($proxy, true);
		
		print ' <img src="/browser/other/arrow-s.png" class="xforwardedfor i2" title="X-Forwarded-For" /> <span class="host"'.($uprhost?' style="color:gray"':'').'>'.$prhost.'</span>';
	}
print '</h2><br />';

print '<h2>';
	print lookup_isp($addr);
	
	if($proxy){
		print ' <img src="/browser/other/arrow-s.png" class="xforwardedfor i2" title="X-Forwarded-For" /> '.lookup_isp($proxy, 1);
	}
print '</h2><br />';

print '<h2>';
	print $geoip = lookup_ip($addr);
	if($proxy) print ' <img src="/browser/other/arrow-s.png" class="i2" title="X-Forwarded-For" /> '.lookup_ip($proxy, 1);
print '</h2><br />';

print '<h3>';
	print detect_platform();
	print detect_webbrowser();
	print $_SERVER['HTTP_USER_AGENT'];
print '</h3>';
print '</div>';

print '<title>IP: '.$addr.', GeoIP: '.trim(strip_tags($geoip)).'</title>';
print $scripts;

geoip_close($gi);

function ucwords2($words){
    for($i = 0, $max = strlen($words), $next = true; $i < $max; $i++){
        if(strpos(' -', $words[$i]) !== false){
            $next = true;
        } else if($next){
            $next = false;
            $words[$i] = strtoupper($words[$i]);
        }
    }
    
    return $words;
}

function revaddr($ip, $arpa = false){
	if(is_ipv6($ip)){
		$ip = str_replace(':', null, inet6_expand($ip));
		return implode('.', array_reverse(explode('.', trim(chunk_split($ip, 1, '.'), '.')))).($arpa?'.ip6.arpa':'');
	} else {
		return implode('.', array_reverse(explode('.', $ip))).($arpa?'.in-addr.arpa':'');
	}
}

function inet6_expand($addr){
    if (strpos($addr, '::') !== false) {
        $part = explode('::', $addr);
        $part[0] = explode(':', $part[0]);
        $part[1] = explode(':', $part[1]);
        $missing = array();
        for ($i = 0; $i < (8 - (count($part[0]) + count($part[1]))); $i++)
            array_push($missing, '0000');
        $missing = array_merge($part[0], $missing);
        $part = array_merge($missing, $part[1]);
    } else {
        $part = explode(":", $addr);
    }
	
    foreach ($part as &$p) {
        while (strlen($p) < 4) $p = '0' . $p;
    }
	
    unset($p);
    $result = implode(':', $part);
	
    if (strlen($result) == 39) {
        return $result;
    } else {
        return false;
    }
}

function v6to4($addr){
	if(substr($addr, 0, 5) == '2002:'){
		$expaddr = inet6_expand($addr);
		return hexdec(substr($expaddr, 30, 2)).'.'.hexdec(substr($expaddr, 32, 2)).'.'.hexdec(substr($expaddr, 35, 2)).'.'.hexdec(substr($expaddr, 37, 2));
	}
}

function process_ip($addr, $xfwd = false){
	$ret .= $v6 = is_ipv6($addr);
	$ret .= $tr = is_tor($addr);
	$ret .= $op = is_opturbo($addr);
	$ret .= $pl = is_planetlab($addr);
	if(!$tr && !$op && !$pl && $xfwd) $ret .= '<img src="/browser/other/proxy.png" title="Proxy detected" class="i1" /> ';
	if(!$tr && !$op && !$pl && !$v6 && !$xfwd) $ret .= ($pr = is_proxy_db($addr)) == 1 ? '<img src="/browser/other/proxy.png" title="Anonymous proxy detected" class="i1" /> ' : '';
	if(!$tr && !$op && !$pl && !$v6 && !$xfwd && $pr == -1) $ret .= is_proxy($addr);
	$ret .= '<span class="ip"><a href="/browser/?lookup='.$addr.'">'.$addr.'</a></span>';
	
	return $ret;
}

function is_tor($addr){
	if(substr_count($addr, '.') != 0 && gethostbynamec(revaddr($addr).'.'.$_SERVER['SERVER_PORT'].'.'.revaddr($_SERVER['SERVER_ADDR']).'.ip-port.exitlist.torproject.org') == '127.0.0.2'){
		return '<img src="/browser/other/tor.png" title="TOR exit node" class="tor i1" /> ';
	}
}

function is_opturbo($addr){
	if(substr(gethostbyaddrc($addr), -15) == '.opera-mini.net'){
		return '<img src="/browser/other/turbo.png" class="operaturbo ib" title="Opera Turbo proxy" /> ';
	}
}

function is_planetlab($addr){
	if(preg_match('/^planet(?:lab)?\d+\./i', gethostbyaddrc($addr))){
		return '<img src="/browser/other/planetlab.jpg" class="planetlab ib" title="PlanetLab proxy" /> ';
	}
}

function is_proxy($addr){
	global $scripts, $proxycheck;
	$scripts .= '<script defer src="/browser/?is_proxy='.urlencode(rtrim(base64_encode(inet_pton($addr)), '=')).'&placeholder='.$proxycheck.'"></script>';
	$proxycheck++;
	return '<span class="placeholder"></span>';
}

function is_ipv6($addr){
	if(substr_count($addr, ':') > 0 && substr_count($addr, '.') == 0){
		return '<img src="/browser/other/ipv6.png" title="IPv6, fuck yeah!" class="i1" /> ';
	}
}

function lookup_ip($addr, $idx = 0){
	global $gi, $gi6, $GEOIP_REGION_NAME, $scripts;
	
	$v6 = is_ipv6($addr);
	$s2 = false;
	
   lookup:
	if($v6){
		$ip = geoip_record_by_addr_v6($gi6, $addr);
	} else {
		$ip = geoip_record_by_addr($gi, $addr);
	}
	
	if(file_exists('flags/'.strtolower($ip->country_code).'.png')) $flag = '<img class="flag i1" src="/browser/flags/'.strtolower($ip->country_code).'.png" title="'.$ip->country_name.'" /> ';
	$ip = $ip->country_name.', '.ucwords2($GEOIP_REGION_NAME[$ip->country_code][$ip->region]).', '.ucwords2($ip->city);
	$ip = rtrim($ip, ' ,');
	
	if(!empty($ip)) $ip = $flag.'<span class="geoip">'.$ip.'</span>';
	
	if(!$s2 && empty($ip)){
		$s2 = true;
		
		$host = gethostbyaddrc($addr);
		
		if(!$v6){
			$ip2  = gethostbynamec($host);
		}
		
		if(!$v6 && $host != $ip2){
			$addr = $ip2;
		} else {
			if(preg_match('/^(?:\w+:\/\/)?[^:?#\/\s]*?([^.\s]+\.(?:[a-z]{2,}|co\.uk|org\.uk|ac\.uk|org\.au|com\.au))(?:[:?#\/]|$)/i', $host, $m)){
				if($m[1]){
					$ip2 = gethostbynamec($m[1]);
					
					if($ip2 != $m[1]){
						$addr = $ip2;
					}
				}
			}
		}
		
		goto lookup;
	}
	
	if(empty($ip)){	
		$ip = ' <img class="flag i1" src="/browser/browsers/null.png" title="GeoIP lookup failed" /> <span class="geoip"><span style="color:gray">Reserved</span></span>';
		if($v6){
			$param = '?whois='.urlencode(rtrim(base64_encode(inet_pton($addr)), '='));
			if(strstr($scripts, $param) != -1){
				$scripts = str_replace($param, $param.'&geoip='.$idx, $scripts);
			} else {
				$scripts .= '<script defer src="/browser/'.$param.'&geoip='.$idx.'"></script>';
			}
		}
	}
	
	return $ip;
}

function lookup_isp($addr, $idx = 0){
	global $gia, $gia6, $scripts;
	
	$v6 = is_ipv6($addr);
	$s2 = false;
	
   lookup:
	if($v6){
		$isp = geoip_name_by_addr_v6($gia6, $addr);
	} else {
		$isp = geoip_name_by_addr($gia, $addr);
	}
	
	if(!empty($isp)){
		$isp = explode(' ', $isp, 2);
		$isp = '<span class="asnum"><a href="http://bgp.he.net/'.$isp[0].'">'.$isp[0].'</a></span> <span class="isp">'.$isp[1].'</span>';
	}
	
	if(!$s2 && empty($isp)){
		$s2 = true;
		
		$host = gethostbyaddrc($addr);
		
		if(!$v6){
			$ip2  = gethostbynamec($host);
		}
		
		if(!$v6 && $host != $ip2){
			$addr = $ip2;
		} else {
			if(preg_match('/^(?:\w+:\/\/)?[^:?#\/\s]*?([^.\s]+\.(?:[a-z]{2,}|co\.uk|org\.uk|ac\.uk|org\.au|com\.au))(?:[:?#\/]|$)/i', $host, $m)){
				if($m[1]){
					$ip2 = gethostbynamec($m[1]);
					
					if($ip2 != $m[1]){
						$addr = $ip2;
					}
				}
			}
		}
		
		goto lookup;
	}
	
	if(empty($isp)){
		$isp = '<span class="isp"><span style="color:gray">Unknown ISP</span></span>';
		if($v6) $scripts .= '<script defer src="/browser/?whois='.urlencode(rtrim(base64_encode(inet_pton($addr)), '=')).'&isp='.$idx.'"></script>';
	}
	
	return $isp;
}

function gethostbyaddrc($addr){
	global $addrs;
	
	if($addrs[$addr]){
		return $addrs[$addr];
	}
	
	$dns = new Net_DNS2_Resolver(array('nameservers' => array('8.8.8.8', '8.8.4.4')));
	
	try {
		$res = $dns->query($addr, 'PTR');
	} catch (Net_DNS2_Exception $e) {
		return $addr;
	}
	
	if(count($res->answer) == 0){
		return $addr;
	}
	
	return $addrs[$addr] = $res->answer[0]->ptrdname;
}

function gethostbynamec($host){
	global $hosts;
	
	if($hosts[$host]){
		return $hosts[$host];
	}
	
	$dns = new Net_DNS2_Resolver(array('nameservers' => array('8.8.8.8', '8.8.4.4')));
	
	try {
		$res = $dns->query($host, 'AAAA');
	} catch (Net_DNS2_Exception $e) { }
	
	if(count($res->answer) == 0){
		try {
			$res = $dns->query($host, 'A');
		} catch (Net_DNS2_Exception $e) {
			return;
		}
	}
	
	if(count($res->answer) == 0){
		return $host;
	}
	
	return $hosts[$host] = $res->answer[0]->address;
}

function whois($ip) {
    $fp = @fsockopen('whois.lacnic.net', 43, $errno, $errstr, 10) or die("Socket Error " . $errno . " - " . $errstr);
    fputs($fp, $ip."\r\n");
	
    $out = '';
    while(!feof($fp)){
        $out .= fgets($fp);
    }
    fclose($fp);

    $res = array();
    if((strpos(strtolower($out), 'error') === FALSE) && (strpos(strtolower($out), 'not allocated') === FALSE)) {
        $rows = explode("\n", $out);
        foreach($rows as $row) {
            $row = trim($row);
            if(($row != '') && ($row{0} != '#') && ($row{0} != '%')) {
                list($key, $value) = explode(':', $row, 2);
				$res[strtolower($key)][] = trim($value);
            }
        }
    }
	
    return $res;
}

function is_proxy_db($addr){
	global $db;
	
	if($db == null) $db = new PDO('sqlite:proxy_check.db');
	
	$ip = (int)(ip2long($addr));
	//$db->exec('create table list ( addr integer primary key, type integer )');
	//$db->exec('insert into list values ( '.ip2long('127.0.0.1').', 0 )');
	
	$q = $db->query('select type from list where addr = '.$ip.' limit 1')->fetchObject();
	
	if(!$q) return -1;
	
	return $q->type;
}
?>