# Minimalistic IP detection script with advanced features

If you have a dynamic IP address you've probably been in the situation where you have to find your external IPv4/IPv6 address or hostname fast, so you google "what is my ip" and go to the first site. I generally used [ipcimed.hu](http://ipcimed.hu/), but like most of the sites, it only detects your IPv4 address and the domain of your hostname.

## Features

- IPv4 address – to force an IPv4 connection go to [ipv4.rolisoft.net/b](http://ipv4.rolisoft.net/b)
- IPv6 address – to force an IPv6 connection go to [ipv6.rolisoft.net/b](http://ipv6.rolisoft.net/b)
- Translation of [6to4](http://en.wikipedia.org/wiki/6to4) IPv6 addresses to your original IPv4
- Advanced Geolocation: 
 - Frequently updated IPv4/IPv6 databases provided by MaxMind
 - [RIPE](http://www.ripe.net/ "Réseaux IP Européens Network Coordination Centre")/[ARIN](https://www.arin.net/ "American Registry for Internet Numbers")/[APNIC](http://www.apnic.net/ "Asia-Pacific Network Information Centre")/[LACNIC](http://www.lacnic.net/ "Latin American and Caribbean Internet Addresses Registry")/[AfriNIC](http://www.afrinic.net/ "African Network Information Center") will be queried and parsed in case of missing information
 - IPv4 will be tracked down with DNS trickery if the information extracted from IPv6 is still incomplete
- Detect proxy usage and show the address in the [XFF](http://en.wikipedia.org/wiki/X-Forwarded-For "X-Forwarded-For") (or other variations) header
- Detect [Opera Turbo](http://www.opera.com/browser/turbo/) proxy
- Detect [PlanetLab](http://www.planet-lab.org/) proxies – [CoDeeN](http://codeen.cs.princeton.edu/) and [Coral](http://www.coralcdn.org/)
- Detect [Tor](https://www.torproject.org/) exit nodes
- Detect anonymous and transparent proxies with 99.5% accuracy and almost no false positives
- Identify your operating system, device and/or browser – icons and logic was borrowed from [wp-useragent](http://wordpress.org/extend/plugins/wp-useragent/)

## Installation

 1. Copy the *.php files and images to a folder on your PHP-capable server
 2. Download the latest [MaxMind GeoLite City](http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz) (or [GeoIP City](http://www.maxmind.com/app/city)) database
 3. Optionally, download the [IPv6 database](http://geolite.maxmind.com/download/geoip/database/GeoLiteCityv6-beta/) as well
 4. Configure the file names in the `geoip_open()` calls in `index.php`
 5. Create the `proxy_check.db` file – consult the `is_proxy_db()` function in `index.php` for the `create table` string

## Use it in your script/software

This script was crafted to return minimalistic HTML with classified `<span>` tags.

To extract a value programmatically from the server's response, for example the GeoIP, you can either use XPath or regular expressions, whichever is more accessible from your scripting language.

XPath: `//span[@class='geoip']`
RegEx: `<span class="geoip">([^<]+)</span>`

If a proxy is detected, the script will send 2 GeoIPs. The last one is always the user.

## TODO

### Check IP address against a list of DNS blacklists

This feature is currently not integrated, as the checking function is very slow.

Check `dnsbl.php` for the function I hacked together, and `dnsbl.txt` for 112 working DNS blacklist addresses.

The `checkdnsbl()` function will also report the blocking reason returned in the `TXT` record of the DNS check. (Something I haven't seen online DNSBL checking sites to do, although it's a pretty awesome feature.)

## About this repo

The reason why this code is not *yet* commented, the installation is weird, and the commit messages contain swear words, is because I pushed my private repo in which I hacked together this script long ago.

Due to some unique implementations, various people have emailed me and asked me to open-source the code or at least release parts of it. Mainly the anonymous proxy detection and Tor exit node detection parts were requested, so here they are.

You are welcome to fork it.