<?php
header('Content-Type: text/html; charset=UTF-8');

if(!empty($_GET['is_proxy'])){
	$prst = 'document.write(\'<img src="http://rolisoft.net/browser/other/proxy.png" title="Anonymous proxy detected" style="margin-bottom:-4px" /> \')';
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

//$_SERVER['REMOTE_ADDR'] = '79.119.213.42';
//$_SERVER['REMOTE_ADDR'] = '2002:4f77:d54e::4f77:d54e';
//$_SERVER['REMOTE_ADDR'] = '2607:f298:1:105::8d8:796c';
$_SERVER['REMOTE_ADDR'] = '2a02:2f02:9021:f00d::567d:bf36';
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '69.163.231.16';
//$_SERVER['HTTP_X_FORWARDED_FOR'] = '2002:0:0:0:0:0:d9d4:e60e';

$addr  = $_SERVER['REMOTE_ADDR'];
$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];

if(!$proxy && $_SERVER['HTTP_VIA'] && preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $_SERVER['HTTP_VIA'], $mvia)) $proxy = $mvia[0];
if($_SERVER['HTTP_CLIENT_IP']) $proxy = $_SERVER['HTTP_CLIENT_IP'];
if($_SERVER['HTTP_X_CODEMUX_CLIENT']) $proxy = $_SERVER['HTTP_X_CODEMUX_CLIENT'];

print '<style>*{margin:0}.c{font-family:Cambria;width:100%;height:205px;text-align:center;position:absolute;top:50%;margin:-100px auto 0px auto;}</style>';

include 'wp-useragent.php';
include 'geoipcity.inc';
include 'geoipregionvars.php';
$gi  = geoip_open('GeoIPCity.dat', GEOIP_STANDARD);
$gi2 = geoip_open('GeoIPOrg.dat', GEOIP_STANDARD);
$gi6 = geoip_open('GeoLiteCityv6.dat', GEOIP_STANDARD);

print '<div class="c">';
print '<h1>';
	print process_ip($addr, !empty($proxy));
	if(is_ipv6($addr) && $v4 = v6to4($addr)){
		$addr = $v4;
		print ' <img src="/browser/other/arrow-s.png" style="margin-bottom:0px" title="6to4 tunnel destination" /> '.process_ip($addr);
	}
	
	if(!empty($proxy)){
		print ' <img src="/browser/other/arrow.png" style="margin-bottom:-4px" title="X-Forwarded-For" /> '.process_ip($proxy);
		if(is_ipv6($proxy) && $v4pr = v6to4($proxy)){
			$proxy = $v4pr;
			print ' <img src="/browser/other/arrow-s.png" style="margin-bottom:0px" title="6to4 tunnel destination" /> '.process_ip($proxy);
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
		
		print ' <img src="/browser/other/arrow-s.png" style="margin-bottom:-3px" class="xforwardedfor" title="X-Forwarded-For" /> <span class="host"'.($uprhost?' style="color:gray"':'').'>'.$prhost.'</span>';
	}
print '</h2><br />';

print '<h2>';
	print lookup_isp($addr);
	
	if($proxy){
		print ' <img src="/browser/other/arrow-s.png" style="margin-bottom:-3px" class="xforwardedfor" title="X-Forwarded-For" /> '.lookup_isp($proxy);
	}
print '</h2><br />';

print '<h2>';
	print $geoip = lookup_ip($addr);
	if($proxy) print ' <img src="/browser/other/arrow-s.png" style="margin-bottom:-3px" title="X-Forwarded-For" /> '.lookup_ip($proxy);
print '</h2><br />';

print '<h3>';
	print detect_platform();
	print detect_webbrowser();
	print $_SERVER['HTTP_USER_AGENT'];
print '</h3>';
print '</div>';

print '<title>IP: '.$addr.', GeoIP: '.trim(strip_tags($geoip)).'</title>';

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
	if(!$tr && !$op && !$pl && $xfwd) $ret .= '<img src="/browser/other/proxy.png" title="Proxy detected" style="margin-bottom:-4px" /> ';
	if(!$tr && !$op && !$pl && !$v6 && !$xfwd) $ret .= ($pr = is_proxy_db($addr)) == 1 ? '<img src="/browser/other/proxy.png" title="Anonymous proxy detected" style="margin-bottom:-4px" /> ' : '';
	if(!$tr && !$op && !$pl && !$v6 && !$xfwd && $pr == -1) $ret .= is_proxy($addr);
	$ret .= '<span class="ip">'.$addr.'</span>';
	
	return $ret;
}

function is_tor($addr){
	if(substr_count($addr, '.') != 0 && gethostbynamec(revaddr($addr).'.'.$_SERVER['SERVER_PORT'].'.'.revaddr($_SERVER['SERVER_ADDR']).'.ip-port.exitlist.torproject.org') == '127.0.0.2'){
		return '<img src="/browser/other/tor.png" title="TOR exit node" class="tor" style="margin-bottom:-4px" /> ';
	}
}

function is_opturbo($addr){
	if(substr(gethostbyaddrc($addr), -15) == '.opera-mini.net'){
		return '<img src="/browser/other/turbo.png" style="margin-bottom:-5px" class="operaturbo" title="Opera Turbo proxy" /> ';
	}
}

function is_planetlab($addr){
	if(preg_match('/^planet(?:lab)?\d+\./i', gethostbyaddrc($addr))){
		return '<img src="/browser/other/planetlab.jpg" style="margin-bottom:-5px" class="planetlab" title="PlanetLab proxy" /> ';
	}
}

function is_proxy($addr){
	return '<script src="/browser/?is_proxy='.urlencode(rtrim(base64_encode(inet_pton($addr)), '=')).'"></script>';
}

function is_ipv6($addr){
	if(substr_count($addr, ':') > 0 && substr_count($addr, '.') == 0){
		return '<img src="/browser/other/ipv6.jpg" title="IPv6, fuck yeah!" style="margin-bottom:-4px" /> ';
	}
}

function lookup_ip($addr){
	global $gi, $gi6, $GEOIP_REGION_NAME;
	
	$v6 = is_ipv6($addr);
	$s2 = false;
	
   lookup:
	if($v6){
		$ip = geoip_record_by_addr_v6($gi6, $addr);
	} else {
		$ip = geoip_record_by_addr($gi, $addr);
	}
	
	if(file_exists('flags/'.strtolower($ip->country_code).'.png')) $flag = '<img src="/browser/flags/'.strtolower($ip->country_code).'.png" style="margin-bottom:-3px" title="'.$ip->country_name.'" /> ';
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
					} else {
						break;
					}
				} else {
					break;
				}
			}
		}
		
		goto lookup;
	}
	
	if(empty($ip)) $ip = ' <img src="/browser/browsers/null.png" title="GeoIP lookup failed" style="margin-bottom:-4px" /> <span class="geoip" style="color:gray">Reserved</span>';
	
	return $ip;
}

function lookup_isp($addr){
	global $gi2;
	
	$s2 = false;
	
   lookup:
	$isp = geoip_name_by_addr($gi2, $addr);
	
	if(!empty($isp)) $isp = '<span class="isp">'.$isp.'</span>';
	
	if(!$s2 && empty($isp)){
		$s2 = true;
		
		$host = gethostbyaddrc($addr);
		$v6 = is_ipv6($addr);
		
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
					} else {
						break;
					}
				} else {
					break;
				}
			}
		}
		
		goto lookup;
	}
	
	if(empty($isp)) $isp = '<span class="isp" style="color:gray">Unknown ISP</span>';
	
	return $isp;
}

function gethostbyaddrc($addr){
	global $addrs;
	
	if(!$addrs[$addr]){
		return $addrs[$addr] = gethostbyaddr($addr);
	} else {
		return $addrs[$addr];
	}
}

function gethostbynamec($host){
	global $hosts;
	
	if(!$hosts[$host]){
		return $hosts[$host] = gethostbyname($host);
	} else {
		return $hosts[$host];
	}
}

function gethostbynamee($host){
	$query = `nslookup -type=A -timeout=1 -retry=1 $host`;
	
	if(preg_match('/\nAddress: (.*)\n/', $query, $m)){
		return trim($m[1]);
	} else {
		return $host;
	}
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