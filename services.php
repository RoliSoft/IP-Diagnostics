<?
function is_tor($addr){
	// https://www.torproject.org/projects/tordnsel.html.en
	return substr_count($addr, '.') != 0 && resolve_host(reverse_address($addr).'.'.$_SERVER['SERVER_PORT'].'.'.reverse_address($_SERVER['SERVER_ADDR']).'.ip-port.exitlist.torproject.org') == '127.0.0.2';
}

function is_i2p($addr){
	// https://github.com/hilbix/i2p.to-web/blob/master/header.php#L74
	return in_array($addr, array('66.111.51.110', '81.169.183.36', '62.75.246.186', '85.25.147.197', '217.160.107.151'));
}

function is_opturbo($addr){
	return ends_with(reverse_lookup($addr), '.opera-mini.net');
}

function is_planetlab($addr){
	return (bool)preg_match('/^planet(?:lab)?\d+\./i', reverse_lookup($addr));
}

function is_proxy($addr){
	global $scripts, $proxycheck;
	$scripts .= '<script defer src="'.SCRIPT_PATH.'?is_proxy='.urlencode(rtrim(base64_encode(inet_pton($addr)), '=')).'&placeholder='.$proxycheck.'"></script>';
	$proxycheck++;
	return '<span class="placeholder"></span>';
}

function is_proxy_cached($addr){
	global $proxydb;
	
	if($proxydb == null){
		$proxydb = new PDO('sqlite:proxy_check.db');
	}
	
	//$proxydb->exec('create table list ( addr integer primary key, type integer )');
	//$proxydb->exec('insert into list values ( '.ip2long('127.0.0.1').', 0 )');
	
	$q = $proxydb->query('select type from list where addr = '.((int)(ip2long($addr))).' limit 1')->fetchObject();
	return !$q ? -1 : $q->type;
}

function is_proxy_search($addr){
	global $proxydb;
	
	if($proxydb == null){
		$proxydb = new PDO('sqlite:proxy_check.db');
	}
	
	//$bing1 = @json_decode(@file_get_contents('http://api.bing.net/json.aspx?AppId=072CCFDBC52FB4552FF96CE87A95F8E9DE30C37B&Query='.urlencode('"'.$chip.'" intitle:proxy').'&Sources=Web&Version=2.0&Market=en-us&Adult=Off&Web.Count=1&Web.Offset=0&Web.Options=DisableHostCollapsing'), true);
	//$bing2 = @json_decode(@file_get_contents('http://api.bing.net/json.aspx?AppId=072CCFDBC52FB4552FF96CE87A95F8E9DE30C37B&Query='.urlencode('"'.$chip.'" intitle:proxies').'&Sources=Web&Version=2.0&Market=en-us&Adult=Off&Web.Count=1&Web.Offset=0&Web.Options=DisableHostCollapsing'), true);
	//$found = $bing1['SearchResponse']['Web']['Total'] != 0 || $bing2['SearchResponse']['Web']['Total'] != 0;
	
	$google = json_decode(file_get_contents('http://www.google.com/uds/GwebSearch?context=0&lstkp=0&rsz=small&hl=en&source=gsc&gss=.com&sig=22c4e39868158a22aac047a2c138a780&q='.urlencode('"'.$addr.'" intitle:proxy || intitle:proxies').'&gl=www.google.com&qid=12a9cb9d0a6870d28&key=AIzaSyA5m1Nc8ws2BbmPRwKu5gFradvD_hgq6G0&v=1.0'), true);
	$found  = count($google['responseData']['results']) != 0;
	
	$proxydb->exec('insert into list values ( '.ip2long($addr).', '.($found?1:0).' )');
	
	return $found ? 1 : 0;
}
?>