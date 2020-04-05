<?php $this->extend('/layout/TwitterBootstrap/dashboard');
//DateTimeZone::listIdentifiers ([ int $what = DateTimeZone::ALL [, string $country = NULL ]] ) : array

$country = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, 'AU');
$zones = timezone_identifiers_list();
$abbrevs = DateTimeZone::listAbbreviations();

pr($country);
pr($zones);
pr($abbrevs);