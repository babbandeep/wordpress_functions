<?php

function wp_get_server_protocol() {
	$protocol = $_SERVER['SERVER_PROTOCOL'];
	if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
		$protocol = 'HTTP/1.0';
	}
	return $protocol;
}

?>


//code explained

## $_SERVER['SERVER_PROTOCOL']	  Returns the name and revision of the information protocol (such as HTTP/1.1)


## in_array()

<?php
$people = array("Peter", "Joe", "Glenn", "Cleveland");

if(in_array("Glenn", $people)){
       echo "Match found";
 } else {
       echo "Match not found";
 }

//output
Match found
	
?>

