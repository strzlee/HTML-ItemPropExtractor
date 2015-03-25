<?php

/*****
 * 
 * HTML Itemprop-Attribute Extractor
 * 2015 by Strauss Manuel
 * www.strzlee.tk
 * 
 * Fetches a website, extracts the itemprop-attributes and optionally saves it as json file.
 * Returns array, assoc-array or false
 * 
 * array ItemPropExtractor::fetch(string URL, [string FILENAME], [boolean ASSOC-ARRAY])
 * 
 * Example: 
 * 
 *  $props = ItemPropExtractor::fetch('http://www.jausentest.at/detail/235/', 'props.json', true);
 * 
 *  Result: array { ["photo"]=>  "" 
 *                  ["rating"]=>  "" 
 *                  ["name"]=>  "Wimmer Stubn" 
 *                  ["address"]=>  "4751 Dorf an der Pram, Thalling 2" 
 *                  ["tel"]=>  "07764/20068" 
 *                  ["geo"]=>  " " 
 *                  ["latitude"]=>  "" 
 *                  ["longitude"]=>  "" 
 *                  ["url"]=>  "http://www.jausentest.at/#detail/235" } 
 * 
*****/


class ItemPropExtractor {
    
    private static $extract = 'itemprop';
    
    public static function fetch($target, $exportFile = false, $assocArray = false) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
        $html = curl_exec($ch);
        $responseCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);  
        curl_close($ch);
        
        if ($responseCode == 200) {
            
            $nodes = array();
            
            $d = new DOMDocument();
            libxml_use_internal_errors(true);
            $d->loadHTML($html);
            libxml_use_internal_errors(false);
            
            $xpath = new DOMXPath($d);
            $itemprobs = $xpath->query('//*[@'.self::$extract.']');
        
            foreach ($itemprobs as $item) {
                
                if ($assocArray) {
                    
                   $nodes[$item->getAttribute(self::$extract)] = $item->nodeValue; 
                   
                } else {
                    
                    $nodes[][$item->getAttribute(self::$extract)] = $item->nodeValue;
                    
                }
                
            }
            
            if ($exportFile) {
                $fp = fopen($exportFile, 'w');
                fwrite($fp, json_encode($nodes));
                fclose($fp); 
            }
            
            return $nodes;    
            
        } else {
            
            return false;
            
        }
        
    } 
    
}
