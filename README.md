# IP Diagnostics

If you have a dynamic IP address you've probably been in the situation where you have to find your external IPv4/IPv6 address or hostname fast, so you google "what is my ip" and go to the first site. I generally used [ipcimed.hu](http://ipcimed.hu/), but like most of the sites, it only detects your IPv4 address and the domain of your hostname.

[rolisoft.net/b](http://rolisoft.net/b) is a similar page, however, it has more advanced detection mechanisms:

*   IPv4 address – to force an IPv4 connection go to  [ipv4.rolisoft.net/b](http://ipv4.rolisoft.net/b)
*   IPv6 address – to force an IPv6 connection go to  [ipv6.rolisoft.net/b](http://ipv6.rolisoft.net/b)
*   Translation of [6to4](http://en.wikipedia.org/wiki/6to4), [Teredo](http://en.wikipedia.org/wiki/Teredo_tunneling), [SIIT](http://en.wikipedia.org/wiki/IPv6_transition_mechanisms#Stateless_IP.2FICMP_Translation_.28SIIT.29), [NAT64](http://en.wikipedia.org/wiki/NAT64) and [ISATAP](http://en.wikipedia.org/wiki/ISATAP) IPv6 addresses to your original IPv4
*   Detection of IPv6 tunnel brokers – see Wikipedia article "[List of IPv6 tunnel brokers](http://en.wikipedia.org/wiki/List_of_IPv6_tunnel_brokers)" for an approximate list of recognized providers
*   Advanced Geolocation:
    *   Frequently updated city-level IPv4/IPv6 databases provided by MaxMind GeoIP and IP2Location
    *   [RIPE](http://www.ripe.net/)/[ARIN](https://www.arin.net/)/[APNIC](http://www.apnic.net/)/[LACNIC](http://www.lacnic.net/)/[AfriNIC](http://www.afrinic.net/) will be queried directly to resolve IP to AS, then ISP name and country will be extracted from AS
    *   In case of missing information, an IPv4 or IPv6 connection will be forced and the address will be processed
*   Detection of both IPv6 and IPv4 addresses on a dual-stack connection
*   Detection of proxy usage and address extraction from the [XFF](http://en.wikipedia.org/wiki/X-Forwarded-For) (or other variations) header
*   Detection of Opera Turbo proxy
*   Detection of PlanetLab proxies – CoDeeN and Coral
*   Detection of Tor exit nodes
*   Detection of I2P outproxies
*   Detection of anonymous and transparent proxies with 99.5% accuracy and almost no false positives:
    *   Proxy-specific DNS blacklists will be queried, but non-proxy-related reasons will be ignored (for example known spammer netblock)
    *   The IP address will be checked against all proxy-listing websites (via a nicely crafted Google and Bing query)
*   Identification of your operating system, device and/or browser &ndash; icons and logic were borrowed from [wp-useragent](http://wordpress.org/extend/plugins/wp-useragent/)

tl;dr: Goes NSA on your ass.

## Use it in your scripts

This script was crafted to return minimalistic HTML with classified `<span>` tags. You can use this script, for example, to test your proxy list and discover their anonimity and location. Or whether they work at all.

To extract a value programmatically from the server's response, for example the GeoIP, you can either use XPath or regular expressions, whichever is more accessible from your scripting language:

*   XPath: `//span[@class='geoip']`
*   RegEx: `<span class="geoip">([^<]+)</span>`

If a proxy is detected, the script will send 2 GeoIPs. The last one is always the user.

## TODO

### Check IP address against a list of DNS blacklists

This feature is currently not integrated, as the checking function is very slow.

Check `dnsbl.php` for the function I hacked together, and `dnsbl.txt` for 112 working DNS blacklist addresses.

The `checkdnsbl()` function will also report the blocking reason returned in the `TXT` record of the DNS check. (Something I haven't seen online DNSBL checking sites to do, although it's a pretty awesome feature.)

UPDATE: You'll have to go back a few commits, because I've removed these files. DNSBL checking is integrated nicely, but it won't check a massively huge list, only a few lists which are specifically targeted towards a purpose. For example IP to AS mapping or proxy blacklists.

## Source

The source code is available via git. You are welcome to install it on your server then fix things that aren't broken:

	git clone https://github.com/RoliSoft/IP-Diagnostics.git

Once you've checked it out, you'll need the free MaxMind databases. I wrote a script to take care of that for you:

	chmod +x geodb/update.sh
	geodb/update.sh

This will download and extract 4 databases (GeoLiteCity, GeoLiteCityv6, GeoIPASNum, GeoIPASNumv6), resulting in 40 MB. IP2Location does not provide free databases. It does provide a "complementary" IPv6 country-level database, but even that requires registration.

The script automatically assumes, that the domain name you're going to access it from is a dual-stack domain, which also has two subdomains:

*   `ipv4.*` containing only A records (IPv4 address)
*   `ipv6.*` containing only AAAA records (IPv6 address)

If this is not the case, open `index.php` and edit the appropriate fields. Please take a few anti-depressants before opening the file! You've been warned.

The reason why the code is the most beautiful thing you've seen in your life, `</sarcasm>`, and does not _yet_ include comments, not to talk about the number of swear words in and out of the git commit messages, is because I pushed my private repo in which I hacked together this script long ago. If you're a developer and you're offended by swear words, fuck you.

Due to some unique implementations, various people have emailed me and asked me to open-source the code or at least release parts of it. Mainly the anonymous proxy detection and Tor exit node detection parts were requested, so here they are.