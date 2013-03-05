<?php
require_once('dnservers.php');

function getPage($url) {
	// Build an array with cURL options.
	$options = array(
		CURLOPT_RETURNTRANSFER	=> true,
		CURLOPT_FOLLOWLOCATION 	=> true,
		CURLOPT_USERAGENT 		=> 'Page Scanner 3000',
		CURLOPT_AUTOREFERER 	=> true,
		CURLOPT_CONNECTTIMEOUT 	=> 120,
		CURLOPT_TIMEOUT 		=> 120,
		CURLOPT_MAXREDIRS 		=> 10
	);

	// Initialize a cURL session.
	$ch = curl_init($url);

	// Apply the options to the active session.
	curl_setopt_array($ch, $options);

	// Fetch the page.
	$pageData  					= curl_getinfo($ch);
    $pageData['content'] 	= strtolower(curl_exec($ch));
	
	// Close the cURL session.
	curl_close($ch);

	// Return the page.
	return $pageData;
}

function strip_html_tags($text) {
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text);
    return strip_tags($text);
}

function checkDomain($domain) {
	// Get the TLD.
	$tld = explode('.', $domain, 2);
	$extension = '.' . strtolower(trim($tld[1]));
	
	// Get the array of domain name servers.
	global $ext;
	
	// Extra check that the domain is > 2 characters.
	// Also check that we have a server supporting the TLD.
	if (strlen($domain) > 0 && isset($ext[$extension])) {
	
		// Select the correct server.
		$server = $ext[$extension][0];
		
		// Connect.
		if (!($sock = @fsockopen($server, 43))) {
			echo 'Connection to server failed.';
		}
		
		// Send request and get the response.
		fputs($sock, "$domain\r\n");
		while (!feof($sock)) {
			$buffer .= fgets($sock, 128);
		}
		
		// Close the connection.
		fclose($sock);
		
		// Output the domain name if it's availabile for registration.
		if (substr_count($buffer, $ext[$extension][1]) > 0) {
			echo $domain;
		} 
		// Prevent overload.
		unset($buffer);
	} else {
		// Throw an error if we don't have a server supporting the given TLD.
		if (strlen($domain) > 0) {
			echo 'TLD not supported.';
		}
	}
}

function fixArray($strWords) {	
	// Replace special characters with whitespace.
	$special = array('!','&','*','.','?','#8217;','#8230;','#8221;','@','$','(',')','-','nbsp;','amp;',':',',','/','\\','á','à','é','è','ü','\'',';','#0160','#160','©','"','#8220','#8211','+','´','’','”','|');
	$strWords = str_replace($special,' ',$strWords);
	$strWords = preg_replace('/\s\s+/', ' ', $strWords);
	$strWords = preg_replace('/\n\r|\n|\r/', ' ', $strWords);
	
	// Replace whitespace with comma, and explode into an array.
	$strWords = str_replace(' ', ',', $strWords);
	$arrWords = explode(',', $strWords);
	
	// Only keep words that are unique.
	$arrWords = array_unique($arrWords);
	
	// Remove empty elements.
	$arrWords = array_filter($arrWords);
	
	// No need to search for domains with 2 charcaters.
	foreach ($arrWords as $key => $value) { 
		if (strlen($value) <= 2) { 
			unset($arrWords[$key]); 
		} 
	}
	
	// Replace non-breaking spaces.
	foreach ($arrWords as $key => $value) { 
		$arrWords[$key] = str_replace('\u00a0', '', $value);
	}
	
	// Remove elements that isn't alphanumeric.
	foreach ($arrWords as $key => $value) { 
		if (!ctype_alnum($value)) {
			unset($arrWords[$key]); 
		}
	}
	
	// Return a clean array of words.
    return $arrWords;
}

// Request URL
function getWords($url) {
	$result = getPage($url);

	$strWords = $result['content'];
	$strWords = strip_html_tags($strWords);
	
	$arrWords = fixArray($strWords);
	$arrWords = array_values($arrWords);
	$arrWords = array('words' => $arrWords);
	$json = json_encode($arrWords);
	echo $json;
}

if ($_GET['action'] == 'getDomains') {
	getWords($_GET['url']);
} else if ($_GET['action'] == 'checkDomain') {
	checkDomain($_GET['domain']);
}
?>
