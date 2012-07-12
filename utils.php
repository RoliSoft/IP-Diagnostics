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
	
	return $addrs[$addr] = $res->answer[0]->ptrdname;
}
?>