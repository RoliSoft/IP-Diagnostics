<?
function checkdnsbl($ip){
	$dnsbl = explode("\n", file_get_contents('dnsbl.txt'));
	$revip = implode('.', array_reverse(explode('.', $ip)));
	$result = false;
	
	foreach($dnsbl as $bl){
		if(dns_check_record($revip.'.'.$bl, 'A')){
			$result[$bl] = null;
			
			$txt = dns_get_record($revip.'.'.$bl, DNS_TXT);
			if(isset($txt[0]) && isset($txt[0]['txt'])){
				$result[$bl] = $txt[0]['txt'];
			}
		}
	}
	
	return $result;
}

var_dump(checkdnsbl('79.119.211.34'));
?>