wget http://download.geonames.org/export/dump/admin1CodesASCII.txt
wget http://download.geonames.org/export/dump/admin2Codes.txt
wget http://download.geonames.org/export/dump/alternateNames.zip
wget http://download.geonames.org/export/dump/allCountries.zip
unzip alternateNames.zip
unzip allCountries.zip
sqlite3 geonames.db < geonames-fts4.sql
rm allCountries.zip
rm allCountries.txt
rm alternateNames.zip
rm alternateNames.txt
rm iso-languagecodes.txt
rm admin1CodesASCII.txt
rm admin2Codes.txt