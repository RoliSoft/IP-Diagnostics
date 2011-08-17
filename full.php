<?php
header('Content-Type: text/html; charset=UTF-8');

print '<style>*{margin:0}pre{margin:7px 13px;}td{padding-right:5px;}table{margin-bottom:7px;}body{margin:15px;font-family:Cambria;}sup,sub{height:0;line-height:1;vertical-align:baseline;position:relative;}sup{bottom:1ex;}</style>';

if(!function_exists('getallheaders')){
	function getallheaders(){
		foreach($_SERVER as $name => $value){
			if(substr($name, 0, 5) == 'HTTP_'){
				$headers[ucwords2(strtolower(str_replace('_', '-', substr($name, 5))))] = $value;
			}
		}
		
		return $headers;
	}
}

// browser #1

include 'Browscap.php';
$bc = new Browscap('.');
$bc->doAutoUpdate = false;
$br = $bc->getBrowser($_SERVER['HTTP_USER_AGENT']);
$br = (empty($br->Parent) ? '<em>unknown</em>' : $br->Parent).' on '.($br->Platform == 'unknown' ? '<em>unknown</em>' : $br->Platform);
$br .= ($br->isMobileDevice ? ', mobile device' : '').($br->isSyndicationReader ? ', bot' : '');

// browser #2

include 'browser_detection.php';
$br2 = ucfirst(browser_detection('browser')).' '.browser_detection('number').' on '.ucfirst(browser_detection('os')).' '.browser_detection('os_number');

// ip geo #1

include 'geoipcity.inc';
include 'geoipregionvars.php';
$gi = geoip_open('GeoLiteCity.dat', GEOIP_STANDARD);
$ip = geoip_record_by_addr($gi, $_SERVER['REMOTE_ADDR']);
geoip_close($gi);

$ip = $ip->country_name.', '.ucwords2($GEOIP_REGION_NAME[$ip->country_code][$ip->region]).', '.ucwords2($ip->city);
$ip = trim($ip, ' ,');
if(empty($ip)) $ip = '<em>lookup failed</em>';

// ip geo #2

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://api.ipinfodb.com/v2/ip_query.php?key=85a150d3088084deb4c4e78a0e2ea0018c4cbd98ffc54c64bc5db3e8eb1ec1a4&ip='.$_SERVER['REMOTE_ADDR']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
$ip2 = curl_exec($ch);
curl_close($ch);

if(empty($ip2)) $ip2 = '<em>lookup timed out</em>';
else {
	$ip2 = simplexml_load_string($ip2);
	
	if($ip2->Status == 'OK'){
		$ip2 = $ip2->CountryName.', '.ucwords2((string)$ip2->RegionName).', '.ucwords2((string)$ip2->City);
		$ip2 = trim($ip2, ' ,');
		
		if(empty($ip2)) $ip2 = '<em>lookup failed</em>';
	} else $ip2 = '<em>lookup failed</em>';
}

// ip forms

$ipe = explode('.', $_SERVER['REMOTE_ADDR']);

$frms .= '0x'.dechex($ipe[0]).dechex($ipe[1]).dechex($ipe[2]).dechex($ipe[3]).', '.
         '0x'.dechex($ipe[0]).'.0x'.dechex($ipe[1]).'.0x'.dechex($ipe[2]).'.0x'.dechex($ipe[3]).', '.
		 ip2long($_SERVER['REMOTE_ADDR']);

print '<table border="0" cellspacing="0" cellpadding="0">';
print '<tr><td><strong>User-Agent</strong></td><td>'.$_SERVER['HTTP_USER_AGENT'].'</td></tr>';
print '<tr><td><strong>Browser <sup>#1</sup></strong></td><td>'.$br.'</td></tr>';
print '<tr><td><strong>Browser <sup>#2</sup></strong></td><td>'.$br2.'</td></tr>';
print '<tr><td><strong>IP, Host</strong></td><td>'.$_SERVER['REMOTE_ADDR'].', '.gethostbyaddr($_SERVER['REMOTE_ADDR']).'</td></tr>';
print '<tr><td><strong>Location <sup>#1</sup></strong></td><td>'.$ip.'</td></tr>';
print '<tr><td><strong>Location <sup>#2</sup></strong></td><td>'.$ip2.'</td></tr>';
print '<tr><td><strong>IP Froms</strong></td><td>'.$frms.'</td></tr>';
print '</table>';

print '<strong>Request Headers</strong><pre>';
print $_SERVER['REQUEST_METHOD'].' '.htmlspecialchars($_SERVER['REQUEST_URI']).' '.$_SERVER['SERVER_PROTOCOL'].'<br />';

$headers = getallheaders();
foreach($headers as $header => $value){
	print $header.': '.htmlspecialchars($value).'<br />';
}

print '</pre>';
print '<title>IP: '.$_SERVER['REMOTE_ADDR'].', GeoIP: '.$ip2.'</title>';

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
?>