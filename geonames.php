<?
function get_geoname($cc, $country, $region, $city){
	global $geonamedb;
	
	if($geonamedb == null){
		if(!file_exists('geonames/geonames.db')){
			return;
		}
		
		$geonamedb = new PDO('sqlite:geonames/geonames.db');
	}
	
	$region = preg_replace('#[^a-z]#i', ' ', strtolower($region));
	$city = preg_replace('#[^a-z]#i', ' ', strtolower($city));
	
	$q = $geonamedb->prepare('select name, code from admin1codes where ascii match ? limit 1');
	$q->execute(array($region));
	$rr = $q->fetchObject();
	list(, $a1c) = explode('.', $rr->code);
	
	$q = $geonamedb->prepare('select name from geonames where cc = ? and admin1code = ? and ascii match ? limit 1');
	$q->execute(array($cc, $a1c, $city));
	$rc = $q->fetchObject();
	
	if($rc == null){
		$q = $geonamedb->prepare('select name, admin1code from geonames where cc = ? and admin1code = ? and alternates match ? limit 1');
		$q->execute(array($cc, $a1c, $city));
		$rc = $q->fetchObject();
	}
	
	return $country.', '.$rr->name.', '.$rc->name;
}
?>