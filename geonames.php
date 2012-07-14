<?
function get_geoname($cc, $country, $region, $city, $linkify = true){
	global $geonamedb;
	
	if($geonamedb == null){
		if(!file_exists('geonames/geonames.db')){
			return;
		}
		
		$geonamedb = new PDO('sqlite:geonames/geonames.db');
	}
	
	$region = preg_replace('#[^a-z]#i', ' ', strtolower($region));
	$city = preg_replace('#[^a-z]#i', ' ', strtolower($city));
	
	if($linkify){
		// try to find a link for the country
		
		$ro = queryToObject($geonamedb, 'select geonameid, name from alternatenames where name match ? and lang = \'en\' limit 1', array($country));
		$rlo = queryToObject($geonamedb, 'select name from alternatenames where geonameid match ? and lang = \'link\' limit 1', array($ro->geonameid));
		
		if($rlo != null){
			$country = '<a href="'.$rlo->name.'">'.$country.'</a>';
		}
	}
	
	// try to find a matching region within the country
	
	$rr = queryToObject($geonamedb, 'select geonameid, name, code from admin1codes where ascii match ? limit 1', array($region));
	list(, $a1c) = explode('.', $rr->code);
	
	if($linkify){
		// try to find a link for the region
		
		$rlr = queryToObject($geonamedb, 'select name from alternatenames where geonameid match ? and lang = \'link\' limit 1', array($rr->geonameid));
		
		if($rlr != null){
			$rr->name = '<a href="'.$rlr->name.'">'.$rr->name.'</a>';
		}
	}
	
	// try to find a matching city within the region and country
	
	$rc = queryToObject($geonamedb, 'select geonameid, name from geonames where cc = ? and admin1code = ? and ascii match ? limit 1', array($cc, $a1c, $city));
	
	if($rc == null){
		$rc = queryToObject($geonamedb, 'select geonameid, name from geonames where cc = ? and admin1code = ? and alternates match ? limit 1', array($cc, $a1c, $city));
	}
	
	if($linkify){
		// try to find a link for the city
		
		$rlc = queryToObject($geonamedb, 'select name from alternatenames where geonameid match ? and lang = \'link\' limit 1', array($rc->geonameid));
		
		if($rlc != null){
			$rc->name = '<a href="'.$rlc->name.'">'.$rc->name.'</a>';
		}
	}
	
	return $country.', '.$rr->name.', '.$rc->name;
}
?>