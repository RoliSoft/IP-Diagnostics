<?
$tunnelBrokers = array(
	array(
		'name' => 'SixXS',
		'icon' => 'sixxs.png',
		'snet' => array('2001:1291:200:', '2001:1418:100:', '2001:1418:200:', '2001:14b8:100:', '2001:15c0:65ff:', '2001:15c0:6600:', '2001:15c0:6700:', '2001:1620:f00:', '2001:16d8:cc00:', '2001:16d8:dd00:', '2001:16d8:ee00:', '2001:16d8:ff00:', '2001:1938:100:', '2001:1938:200:', '2001:1938:80:', '2001:1938:81:', '2001:1af8:fe00:', '2001:1af8:ff00:', '2001:4428:200:', '2001:4830:1100:', '2001:4830:1600:', '2001:4830:1700:', '2001:4978:100:', '2001:4978:200:', '2001:4978:300:', '2001:4978:400:', '2001:4978:f:', '2001:4dd0:f800:', '2001:4dd0:f900:', '2001:4dd0:fb00:', '2001:4dd0:fc00:', '2001:4dd0:fd00:', '2001:4dd0:fe00:', '2001:4dd0:ff00:', '2001:4dd0:ff00:', '2001:610:600:', '2001:610:700:', '2001:648:ff00:', '2001:6a0:100:', '2001:6a0:200:', '2001:6a0:300:', '2001:6a8:200:', '2001:6f8:1000:', '2001:6f8:1100:', '2001:6f8:1200:', '2001:6f8:1300:', '2001:6f8:1400:', '2001:6f8:1c00:', '2001:6f8:1d00:', '2001:6f8:202:', '2001:6f8:300:', '2001:6f8:900:', '2001:770:100:', '2001:7b8:1500:', '2001:7b8:2ff:', '2001:7b8:300:', '2001:7e8:2200:', '2001:808:100:', '2001:808:e100:', '2001:838:300:', '2001:960:2:', '2001:960:600:', '2001:960:700:', '2001:a60:f000:', '2001:a60:f100:', '2001:ad0:900:', '2001:b18:2000:', '2001:b18:4000:', '2401:e800:100:', '2404:e400:fe00:', '2604:8800:100:', '2607:f878:ff00:', '2610:100:4fff:', '2610:100:6000:', '2a00:14f0:e000:', '2a00:15b8:100:', '2a01:198:200:', '2a01:198:300:', '2a01:198:400:', '2a01:198:500:', '2a01:198:600:', '2a01:198:700:', '2a01:1e8:e100:', '2a01:240:fe00:', '2a01:348:100:', '2a01:348:200:', '2a01:348:6:', '2a01:368:e000:', '2a01:368:e100:', '2a01:8c00:ff00:', '2a02:2528:ff00:', '2a02:578:3fe:', '2a02:578:5002:', '2a02:578:5400:', '2a02:578:5500:', '2a02:578:5600:', '2a02:578:5700:', '2a02:578:c00:', '2a02:578:d00:', '2a02:578:e00:', '2a02:578:f00:', '2a02:78:200:', '2a02:e90:c00:')
	),
	array(
		'name' => 'Freenet6',
		'icon' => 'freenet6.png',
		'snet' => '2001:5c0:'
	),
	array(
		'name' => 'Hurricane Electric',
		'icon' => 'henet.png',
		'snet' => '2001:470:'
	),
	array(
		'name' => 'XS4ALL',
		'icon' => 'xs4all.png',
		'snet' => '2001:888:'
	),
	array(
		'name' => 'Indonesian-IPv6TaskForce',
		'snet' => '2001:d68:'
	),
	array(
		'name' => 'NetNam',
		'snet' => '2401:e800:'
	),
	array(
		'name' => 'AARNet',
		'snet' => '2001:388:'
	),
	array(
		'name' => '6fei',
		'snet' => '2001:e88:'
	),
	array(
		'name' => 'Internode',
		'snet' => '2001:44b8:'
	),
	array(
		'name' => 'IPv6Now',
		'snet' => '2406:a000:'
	),
	array(
		'name' => 'NetAssist',
		'snet' => '2a01:d0:8000:'
	),
	array(
		'name' => 'Saudi Arabia CITC',
		'snet' => '2001:67c:130:'
	),
);

function is_tunnel_broker($addr){
	global $tunnelBrokers;
	
	foreach($tunnelBrokers as $tunnelBroker){
		if(is_array($tunnelBroker['snet'])){
			foreach($tunnelBroker['snet'] as $subnet){
				if(starts_with($addr, $subnet)){
					return $tunnelBroker;
				}
			}
		} else {
			if(starts_with($addr, $tunnelBroker['snet'])){
				return $tunnelBroker;
			}
		}
	}
	
	return false;
}

function is_tunnel($addr){
	$expaddr = expand_ipv6($addr);
	
	if(starts_with($expaddr, '2002:')){
		$a = hexdec(substr($expaddr, 5, 2));
		$b = hexdec(substr($expaddr, 7, 2));
		$c = hexdec(substr($expaddr, 10, 2));
		$d = hexdec(substr($expaddr, 12, 2));
		return array('6to4', $a.'.'.$b.'.'.$c.'.'.$d);
	}
	
	if(starts_with($expaddr, '2001:0000:')){
		$a = hexdec(substr($expaddr, 30, 2)) ^ 0xFF;
		$b = hexdec(substr($expaddr, 32, 2)) ^ 0xFF;
		$c = hexdec(substr($expaddr, 35, 2)) ^ 0xFF;
		$d = hexdec(substr($expaddr, 37, 2)) ^ 0xFF;
		return array('Teredo', $a.'.'.$b.'.'.$c.'.'.$d);
	}
	
	if(starts_with($expaddr, '0000:0000:ffff:0000:')){
		return array('SIIT', substr($addr, strrpos($addr, ':') + 1));
	}
	
	if(starts_with($expaddr, '0064:ff9b:')){
		return array('NAT64', substr($addr, strrpos($addr, ':') + 1));
	}
	
	if(starts_with($expaddr, 'fe80:')){
		if(strpos($addr, '.') !== false){
			return array('ISATAP', substr($addr, strrpos($addr, ':') + 1));
		} else {
			$a = hexdec(substr($expaddr, 30, 2));
			$b = hexdec(substr($expaddr, 32, 2));
			$c = hexdec(substr($expaddr, 35, 2));
			$d = hexdec(substr($expaddr, 37, 2));
			return array('ISATAP', $a.'.'.$b.'.'.$c.'.'.$d);
		}
	}
}
?>