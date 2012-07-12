<?
$dnsbls = array(
	array(
		'name' => 'TornevallNET',
		'addr' => 'dnsbl.tornevall.org',
		'mask' => array(
			1   => array('descr' => 'scanned', 'fail' => true),
			2   => array('descr' => 'working proxy', 'fail' => true),
			4   => array('descr' => 'originating from Blitzed', 'fail' => true),
			8   => array('descr' => 'connection timed out', 'fail' => false),
			16  => array('descr' => 'connection failed', 'fail' => false),
			32  => array('descr' => 'different exit IP', 'fail' => true),
			64  => array('descr' => 'marked as abusive', 'fail' => false),
			128 => array('descr' => 'exotic (Tor/web-proxy/etc)', 'fail' => true)
		)
	),
	array(
		'name' => 'SORBS',
		'addr' => 'proxies.dnsbl.sorbs.net',
		'resp' => array(
			'127.0.0.2'  => array('descr' => 'an open HTTP proxy server', 'fail' => true),
			'127.0.0.3'  => array('descr' => 'an open SOCKS proxy server', 'fail' => true),
			'127.0.0.4'  => array('descr' => 'an open proxy server', 'fail' => true),
			'127.0.0.5'  => array('descr' => 'an open SMTP relay server', 'fail' => false),
			'127.0.0.6'  => array('descr' => 'a known spammer netblock', 'fail' => false),
			'127.0.0.7'  => array('descr' => 'an address contains vulnerable scripts', 'fail' => true),
			'127.0.0.8'  => array('descr' => 'an address which forbids SORBS to test it', 'fail' => false),
			'127.0.0.9'  => array('descr' => 'an address which exhibits zombie-like behaviours', 'fail' => true),
			'127.0.0.10' => array('descr' => 'a dynamic IP address range', 'fail' => false),
			'127.0.0.11' => array('descr' => 'an address which contains bad A or MX records', 'fail' => false),
			'127.0.0.12' => array('descr' => 'an address whose owners said no mail should come from here', 'fail' => false)
		)
	),
	array(
		'name' => 'DroneBL',
		'addr' => 'dnsbl.dronebl.org',
		'resp' => array(
			'127.0.0.2'   => array('descr' => 'a sample record', 'fail' => false),
			'127.0.0.3'   => array('descr' => 'an IRC drone', 'fail' => false),
			'127.0.0.5'   => array('descr' => 'a bottler', 'fail' => false),
			'127.0.0.6'   => array('descr' => 'an unknown spambot or drone', 'fail' => false),
			'127.0.0.7'   => array('descr' => 'a DDoS drone', 'fail' => false),
			'127.0.0.8'   => array('descr' => 'an open SOCKS proxy server', 'fail' => true),
			'127.0.0.9'   => array('descr' => 'an open HTTP proxy server', 'fail' => true),
			'127.0.0.10'  => array('descr' => 'a proxy chain', 'fail' => true),
			'127.0.0.13'  => array('descr' => 'a bruteforce attacker', 'fail' => false),
			'127.0.0.14'  => array('descr' => 'an open Wingate proxy', 'fail' => true),
			'127.0.0.15'  => array('descr' => 'a compromised router or gateway', 'fail' => true),
			'127.0.0.17'  => array('descr' => 'an automatically determined botnet address', 'fail' => false),
			'127.0.0.255' => array('descr' => 'an unknown record', 'fail' => false)
		)
	),
	array(
		'name' => 'EFnet RBL',
		'addr' => 'rbl.efnetrbl.org',
		'resp' => array(
			'127.0.0.1' => array('descr' => 'an open proxy server', 'fail' => true),
			'127.0.0.2' => array('descr' => 'a spamtrap host with score of 666', 'fail' => false),
			'127.0.0.3' => array('descr' => 'a spamtrap host with score of 50', 'fail' => false),
			'127.0.0.4' => array('descr' => 'a TOR exit node', 'fail' => true),
			'127.0.0.5' => array('descr' => 'a DDoS drone', 'fail' => false)
		)
	),
);

function is_tor($addr){
	// https://www.torproject.org/projects/tordnsel.html.en
	return substr_count($addr, '.') != 0 && resolve_host(reverse_address($addr).'.'.$_SERVER['SERVER_PORT'].'.'.reverse_address($_SERVER['SERVER_ADDR']).'.ip-port.exitlist.torproject.org') == '127.0.0.2';
}

function is_i2p($addr){
	// https://github.com/hilbix/i2p.to-web/blob/master/header.php#L74
	return in_array($addr, array('85.31.186.67' /* false.i2p */, '66.111.51.110' /* i2p.net */, '81.169.183.36', '62.75.246.186', '85.25.147.197', '217.160.107.151'));
}

function is_opturbo($addr){
	return ends_with(reverse_lookup($addr), '.opera-mini.net');
}

function is_planetlab($addr){
	return (bool)preg_match('/^planet(?:lab)?\d+\./i', reverse_lookup($addr));
}

function is_proxy($addr){
	global $scripts, $proxycheck;
	$scripts .= '<script defer src="'.SCRIPT_PATH.'?p='.urlencode(rtrim(base64_encode(inet_pton($addr)), '=')).'@'.$proxycheck.'"></script>';
	$proxycheck++;
	return '<span class="placeholder"></span>';
}

function is_proxy_initdb(){
	global $proxydb;
	
	if($proxydb == null){
		$init = !file_exists('proxies.db');
		$proxydb = new PDO('sqlite:proxies.db');
		
		if($init){
			$proxydb->exec('create table list ( addr blob(16), type integer, date integer, reason string )');
			$proxydb->prepare('insert into list values ( ?, ?, ?, ? )')->execute(array(inet_pton('127.0.0.1'), 0, pow(2, 32) - 2, null));
			$proxydb->prepare('insert into list values ( ?, ?, ?, ? )')->execute(array(inet_pton('::1'), 0, pow(2, 32) - 2, null));
		} else {
			$proxydb->exec('delete from list where '.time().' - date > 259200');
		}
	}
}

function is_proxy_cached($addr){
	global $proxydb;
	is_proxy_initdb();
	
	$q = $proxydb->prepare('select type, reason from list where addr = ? limit 1');
	$q->execute(array(inet_pton($addr)));
	$r = $q->fetchObject();
	
	if($r == false){
		return null;
	}
	
	return $r->type == 0 ? false : $r->reason;
}

function is_proxy_dnsbl($addr){
	global $proxydb, $dnsbls;
	is_proxy_initdb();
	
	$rddr = reverse_address($addr);
	
	foreach($dnsbls as $dnsbl){
		$host = $rddr.'.'.$dnsbl['addr'];
		$resp = resolve_host($host);
		
		if($resp == $host){
			continue;
		}
		
		if(isset($dnsbl['resp'])){
			if(isset($dnsbl['resp'][$resp]) && $dnsbl['resp'][$resp]['fail']){
				$reason = $dnsbl['name'].' classified this address as '.$dnsbl['resp'][$resp]['descr'].'.';
				break;
			} else {
				continue;
			}
		} else if(isset($dnsbl['mask'])){
			list(, , , $bit) = explode('.', $resp);
			
			$masks = '';
			$fail = false;
			
			foreach($dnsbl['mask'] as $mask => $expl){
				if(($bit & $mask) == $mask){
					$masks .= $expl['descr'].', ';
					
					if(!$expl['fail']){
						$fail = true;
					}
				}
			}
			
			if($fail){
				$reason = $dnsbl['name'].' classified this address as: '.rtrim($masks, ', ').'.';
				break;
			}
		}
	}
	
	$proxydb->prepare('insert into list values ( ?, ?, ?, ? )')->execute(array(inet_pton($addr), isset($reason) ? 1 : 0, time(), isset($reason) ? $reason : null));
	
	return isset($reason) ? $reason : false;
}

function is_proxy_google($addr){
	global $proxydb;
	is_proxy_initdb();
	
	//$bing1 = @json_decode(@file_get_contents('http://api.bing.net/json.aspx?AppId=072CCFDBC52FB4552FF96CE87A95F8E9DE30C37B&Query='.urlencode('"'.$chip.'" intitle:proxy').'&Sources=Web&Version=2.0&Market=en-us&Adult=Off&Web.Count=1&Web.Offset=0&Web.Options=DisableHostCollapsing'), true);
	//$bing2 = @json_decode(@file_get_contents('http://api.bing.net/json.aspx?AppId=072CCFDBC52FB4552FF96CE87A95F8E9DE30C37B&Query='.urlencode('"'.$chip.'" intitle:proxies').'&Sources=Web&Version=2.0&Market=en-us&Adult=Off&Web.Count=1&Web.Offset=0&Web.Options=DisableHostCollapsing'), true);
	//$found = $bing1['SearchResponse']['Web']['Total'] != 0 || $bing2['SearchResponse']['Web']['Total'] != 0;
	
	$google = json_decode(file_get_contents('http://www.google.com/uds/GwebSearch?context=0&lstkp=0&rsz=small&hl=en&source=gsc&gss=.com&sig=22c4e39868158a22aac047a2c138a780&q='.urlencode('"'.$addr.'" intitle:proxy || intitle:proxies').'&gl=www.google.com&qid=12a9cb9d0a6870d28&key=AIzaSyA5m1Nc8ws2BbmPRwKu5gFradvD_hgq6G0&v=1.0'), true);
	$found  = count($google['responseData']['results']) != 0;
	
	if($found){
		$reason = 'listed on ';
		$i = 0;
		foreach($google['responseData']['results'] as $result){
			$reason .= preg_replace('#^www\.#', '', $result['visibleUrl']).', ';
			if(++$i == 3){
				break;
			}
		}
		$reason .= 'and so on...';
	}
	
	$proxydb->prepare('insert into list values ( ?, ?, ?, ? )')->execute(array(inet_pton($addr), $found ? 1 : 0, time(), $found ? $reason : null));
	
	return $found ? $reason : false;
}
?>