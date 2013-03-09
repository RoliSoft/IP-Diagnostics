<?
$hosts = array(
	'localhost' => array(
		'DS'   => '::1',
		'A'    => '127.0.0.1',
		'AAAA' => '::1'
	)
);

$addrs = array(
	'::1'       => 'localhost',
	'127.0.0.1' => 'localhost'
);

$bogons = array(
	// http://tools.ietf.org/html/rfc3330#section-3
	'0.0.0.0/8' => 'Local Network',
	'10.0.0.0/8' => 'Private-Use Network',
	'14.0.0.0/8' => 'Public-Data Network',
	'24.0.0.0/8' => 'Cable Television Network',
	'127.0.0.0/8' => 'Loopback Interface',
	'169.254.0.0/16' => 'Link-Local Network',
	'172.16.0.0/12' => 'Private-Use Network',
	'192.0.2.0/24' => 'Test-Net',
	'192.88.99.0/24' => '6to4 Relay Anycast',
	'192.168.0.0/16' => 'Private-Use Network',
	'198.18.0.0/15' => 'Network Interconnect Device Benchmarking',
	'224.0.0.0/4' => 'Multicast Network',
	'240.0.0.0/4' => 'Reserved for Future Use',
	'255.255.255.255/32' => 'Limited Broadcast Network',
);

function starts_with($haystack, $needle){
	return stripos($haystack, $needle) === 0;
}

function starts_with_any($haystack, $needles){
	foreach($needles as $needle){
		if(starts_with($haystack, $needle)){
			return true;
		}
	}
	
	return false;
}

function ends_with($haystack, $needle){
	return stripos($haystack, $needle) === strlen($haystack) - strlen($needle);
}

function ends_with_any($haystack, $needles){
	foreach($needles as $needle){
		if(ends_with($haystack, $needle)){
			return true;
		}
	}
	
	return false;
}

function capitalize_words($words){
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

function queryToObject($db, $sql, $params = null){
	if($params != null){
		$q = $db->prepare($sql);
		$q->execute($params);
		return $q->fetchObject();
	} else {
		return $db->query($sql)->fetchObject();
	}
}

function execQuery($db, $sql, $params = null){
	if($params != null){
		$q = $db->prepare($sql);
		return $q->execute($params);
	} else {
		return $db->exec($sql);
	}
}

function is_ipv4($addr){
	return filter_var($addr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
}

function is_ipv6($addr){
	return filter_var($addr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
}

function expand_ipv6($addr){
	if(strpos($addr, '::') !== false){
		$missing = array();
		$part    = explode('::', $addr);
		$part[0] = explode(':', $part[0]);
		$part[1] = explode(':', $part[1]);
		
		$x = (8 - (count($part[0]) + count($part[1])));
		for($i = 0; $i < $x; $i++){
			array_push($missing, '0000');
		}
		
		$missing = array_merge($part[0], $missing);
		$part    = array_merge($missing, $part[1]);
	} else {
		$part = explode(':', $addr);
	}

	foreach($part as &$p){
		while(strlen($p) < 4){
			$p = '0'.$p;
		}
	}
	
	unset($p);
	
	$result = implode(':', $part);
	
	if(strlen($result) == 39){
		return $result;
	} else {
		return false;
	}
}

function compress_ipv6($addr){
	return inet_ntop(inet_pton($addr));
}

function reverse_address($addr, $arpa = false){
	if(is_ipv6($addr)){
		$addr = str_replace(':', null, expand_ipv6($addr));
		return implode('.', array_reverse(explode('.', trim(chunk_split($addr, 1, '.'), '.')))).($arpa?'.ip6.arpa':'');
	} else {
		return implode('.', array_reverse(explode('.', $addr))).($arpa?'.in-addr.arpa':'');
	}
}

function resolve_host($host, $type = 'DS'){
	global $hosts;
	
	if(isset($hosts[$host][$type])){
		return $hosts[$host][$type];
	}
	
	$dns = new Net_DNS2_Resolver(array('nameservers' => array('8.8.8.8', '8.8.4.4')));
	
	if($type == 'DS' || $type == 'AAAA'){
		try {
			$res = $dns->query($host, 'AAAA');
		} catch (Net_DNS2_Exception $e) {
			if($type == 'AAAA'){
				return;
			}
		}
	}
	
	if($type == 'A' || count($res->answer) == 0){
		try {
			$res = $dns->query($host, 'A');
		} catch (Net_DNS2_Exception $e) {
			return;
		}
	}
	
	if(count($res->answer) == 0){
		return $host;
	}
	
	return $hosts[$host][$type] = $res->answer[0]->address;
}

function reverse_lookup($addr){
	global $addrs;
	
	if(isset($addrs[$addr])){
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
	
	if(get_class($res->answer[0]) == 'Net_DNS2_RR_PTR'){
		return $addrs[$addr] = $res->answer[0]->ptrdname;
	} else if(get_class($res->answer[0]) == 'Net_DNS2_RR_CNAME') {
		return $addrs[$addr] = $res->answer[0]->cname;
	} else {
		return $addr;
	}
}

function get_dns_txt($host){
	$dns = new Net_DNS2_Resolver(array('nameservers' => array('8.8.8.8', '8.8.4.4')));
	
	try {
		$res = $dns->query($host, 'TXT');
	} catch (Net_DNS2_Exception $e) {
		return;
	}

	if(count($res->answer) == 0){
		return;
	}
	
	return $res->answer[0]->text[0];
}

function ip_in_range($ip, $range){
	if (strpos($range, '/') !== false)
	{
		list($range, $netmask) = explode('/', $range, 2);
		if (strpos($netmask, '.') !== false)
		{
			$netmask = str_replace('*', '0', $netmask);
			$netmask_dec = ip2long($netmask);
			return ((ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec));
		}
		else
		{
			$x = explode('.', $range);
			while (count($x) < 4) $x[] = '0';
			list($a, $b, $c, $d) = $x;
			$range = sprintf("%u.%u.%u.%u", empty($a) ? '0' : $a, empty($b) ? '0' : $b, empty($c) ? '0' : $c, empty($d) ? '0' : $d);
			$range_dec = ip2long($range);
			$ip_dec = ip2long($ip);

			#Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
			#$netmask_dec = bindec(str_pad('', $netmask, '1').str_pad('', 32 - $netmask, '0'));

			#Strategy 2 - Use math to create it
			$wildcard_dec = pow(2, (32 - $netmask)) - 1;
			$netmask_dec = ~$wildcard_dec;

			return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
		}
	}
	else
	{
		if (strpos($range, '*') !== false)
		{
			$lower = str_replace('*', '0', $range);
			$upper = str_replace('*', '255', $range);
			$range = "$lower-$upper";
		}

		if (strpos($range, '-') !== false)
		{
			list($lower, $upper) = explode('-', $range, 2);
			$lower_dec = (float) sprintf("%u", ip2long($lower));
			$upper_dec = (float) sprintf("%u", ip2long($upper));
			$ip_dec = (float) sprintf("%u", ip2long($ip));
			return (($ip_dec >= $lower_dec) && ($ip_dec <= $upper_dec));
		}

		//echo "\r\n\r\nRange argument $range is not in 1.2.3.4/24 or 1.2.3.4/255.255.255.0 format\r\n\r\n";
		return false;
	}
}

function resolve_reserved($addr){
	global $bogons;
	
	foreach($bogons as $range => $name){
		if(ip_in_range($addr, $range)){
			return $name;
		}
	}
	
	return 'Reserved';
}
?>