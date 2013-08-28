<?php

class CountryUtil {

    public static function detectCountryById() {
        $response = @file_get_contents('http://www.netip.de/search?query=' . $ip);
        if (empty($response)) {
            throw new InvalidArgumentException("Error contacting Geo-IP-Server");
        }

        //Array containing all regex-patterns necessary to extract ip-geoinfo from page
        $patterns = array();
        $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
        $patterns["country"] = '#Country: (.*?)&nbsp;#i';
        $patterns["state"] = '#State/Region: (.*?)<br#i';
        $patterns["town"] = '#City: (.*?)<br#i';

        //Array where results will be stored
        $ipInfo = array();

        //check response from ipserver for above patterns
        foreach ($patterns as $key => $pattern) {
            //store the result in array
            $ipInfo[$key] = preg_match($pattern, $response, $value) && !empty($value[1]) ? $value[1] : 'not found';
        }
        $countryCode = strtolower(substr($ipInfo['country'], 0, 2));
        return $countryCode;
    }

}