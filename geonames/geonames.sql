create virtual table geonames using fts4(geonameid int primary key, name varchar(200), ascii varchar(200), alternates varchar(2000), latitude double, longitude double, featureclass varchar(1) , featurecode varchar(10) , cc varchar(2), cc2 varchar(60), admin1code varchar(20), admin2code varchar(80), admin3code varchar(20), admin4code varchar(20), population int, elevation int, gtopo30 int, timezone varchar(40), modification_date date);
create virtual table admin1codes using fts4(code varchar(6), name varchar(200), ascii varchar(200), geonameid int primary key);
create virtual table admin2codes using fts4(code varchar(15), name varchar(200), ascii varchar(200), geonameid int primary key);
create virtual table alternatenames using fts4(alternatenameid int primary key, geonameid int, lang varchar(7), name varchar(200), ispref boolean, isshort boolean, iscolloquial boolean, ishistoric boolean);
.mode tabs
.import admin1CodesASCII.txt admin1codes
.import admin2Codes.txt admin2codes
.import alternateNames.txt alternatenames
.import allCountries.txt geonames
delete from geonames where featureclass != 'A' and featureclass != 'P';
vacuum;