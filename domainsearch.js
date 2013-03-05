var arrayStep 		= 0;
var arraySize 		= 0;
var freeDomains 	= 0
var arrayWords 	   = '';
var tld 		    			= '.com'; // Change this for different TLDs.

function getDomains() {
	// Get the URL.
	var strURL = $('#url').val();
		
	// Give the user some info about what's going on.
	$('#status').html('Retrieving unique words from ' + strURL);
	
	// Make a request to our search-file to retrieve a list of words from the URL.
	$.getJSON('search.php?action=getDomains&url=' + strURL, function(data) {
		// Redeclare some variables.
		arraySize = data.words.length-1;
		arrayWords = data.words;

		// Begin checking the domains.
		checkDomain(arrayWords[arrayStep]);
	});
}

function checkDomain(domain) {
	// If we're done checking domains, we should let the user now that.
	if (arrayStep == arraySize) {
		$('#status').html('Found a total of <strong>' + freeDomains + '</strong> available domain names.');
	}
	arrayStep++;
	// Make a request to check the current domain.
	$.get('search.php?action=checkDomain&domain=' + domain + tld, function(data) {
		if(data.length > 4) {
			// Output the domain name if we get a response.
			$('#freeDomains').prepend(data + '<br />');
			freeDomains++; 
		}
		// Give the user some info about what's going on.
		if (arrayStep <= arraySize) {
			$('#status').html('Checking: ' + arrayWords[arrayStep] + tld + '<br />Progress: ' + ((arrayStep/arraySize)*100).toPrecision(3) + '%');
			//  Repeat until we've processed all the words.
			checkDomain(arrayWords[arrayStep]);
		}
	});
}