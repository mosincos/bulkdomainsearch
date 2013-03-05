<?php
/**
* Bulk domain availablity check script (Revision 7)		
*
* Created  by "Matthew." (up to revision 6) (45276) @ http://namepros.com / http://mattjewell.com
* Modified by "Eric"     (revision 7)       (14781) @ http://namepros.com / http://secondversion.com
*
* Feel free to modify/use however you wish, but keep credit comments in upon distribution.
*/

$ext = array(
	'.com'    		=> array('199.7.55.74', 'No match for'),
	'.net'   			=> array('whois.crsnic.net', 'No match for'),	
	'.biz'    		=> array('whois.biz', 'Not found'),
	'.mobi'   		=> array('whois.dotmobiregistry.net', 'NOT FOUND'),
	'.tv'     			=> array('whois.nic.tv', 'No match for'),
	'.in'     			=> array('whois.inregistry.net', 'NOT FOUND'),
	'.info'   		=> array('whois.afilias.net', 'NOT FOUND'),	
	'.co.uk'  		=> array('whois.nic.uk', 'No match'),		
	'.co.ug'  		=> array('wawa.eahd.or.ug', 'No entries found'),	
	'.or.ug'  		=> array('wawa.eahd.or.ug', 'No entries found'),
	'.nl'     			=> array('whois.domain-registry.nl', 'not a registered domain'),
	'.ro'     			=> array('whois.rotld.ro', 'No entries found for the selected'),
	'.com.au' 	=> array('whois.ausregistry.net.au', 'No data Found'),
	'.ca'     		=> array('whois.cira.ca', 'AVAIL'),
	'.org.uk' 		=> array('whois.nic.uk', 'No match'),
	'.name'   		=> array('whois.nic.name', 'No match'),
	'.us'     		=> array('whois.nic.us', 'Not Found'),
	'.ac.ug'  		=> array('wawa.eahd.or.ug', 'No entries found'),
	'.ne.ug'  		=> array('wawa.eahd.or.ug', 'No entries found'),
	'.sc.ug'  		=> array('wawa.eahd.or.ug', 'No entries found'),
	'.ws'     		=> array('whois.website.ws', 'No Match'),
	'.be'     		=> array('whois.ripe.net', 'No entries'),
	'.com.cn' 	=> array('whois.cnnic.cn', 'no matching record'),
	'.net.cn' 		=> array('whois.cnnic.cn', 'no matching record'),
	'.org.cn' 		=> array('whois.cnnic.cn', 'no matching record'),
	'.no'     		=> array('whois.norid.no', 'no matches'),
	'.se'     		=> array('whois.nic-se.se', 'No data found'),
	'.nu'     		=> array('whois.nic.nu', 'NO MATCH for'),
	'.com.tw' 	=> array('whois.twnic.net', 'No such Domain Name'),
	'.net.tw' 		=> array('whois.twnic.net', 'No such Domain Name'),
	'.org.tw' 		=> array('whois.twnic.net', 'No such Domain Name'),
	'.cc'     		=> array('whois.nic.cc', 'No match'),
	'.nl'     			=> array('whois.domain-registry.nl', 'is free'),
	'.pl'     			=> array('whois.dns.pl', 'No information about'),
	'.pt'     			=> array('whois.dns.pt', 'No match')
);

?>