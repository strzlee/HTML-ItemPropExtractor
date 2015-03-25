# Straussn's HTML Itemprop-Attribute Extractor #

* Fetches a website, extracts the itemprop-attributes and optionally saves it as json file.*


	array ItemPropExtractor::fetch(string URL, [string FILENAME], [boolean ASSOC-ARRAY])
	
	Returns array, assoc-array or false
	
	
**Example:**
 
	$props = ItemPropExtractor::fetch('http://www.jausentest.at/detail/235/', 'props.json', true);
	
	Result: 
		array { ["photo"]=>  "" 
					["rating"]=>  "" 
					["name"]=>  "Wimmer Stubn" 
					["address"]=>  "4751 Dorf an der Pram, Thalling 2" 
					["tel"]=>  "07764/20068" 
					["geo"]=>  " " 
					["latitude"]=>  "" 
					["longitude"]=>  "" 
					["url"]=>  "http://www.jausentest.at/#detail/235" } 