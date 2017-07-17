<?php

/**
 * Turn register globals off.
 *
 * @since 2.1.0
 * @access private
 */

function wp_unregister_GLOBALS() {
	if ( !ini_get( 'register_globals' ) )
		return;
	if ( isset( $_REQUEST['GLOBALS'] ) )
		die( 'GLOBALS overwrite attempt detected' );
	// Variables that shouldn't be unset
	$no_unset = array( 'GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES', 'table_prefix' );
	$input = array_merge( $_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset( $_SESSION ) && is_array( $_SESSION ) ? $_SESSION : array() );
	foreach ( $input as $k => $v )
		if ( !in_array( $k, $no_unset ) && isset( $GLOBALS[$k] ) ) {
			unset( $GLOBALS[$k] );
		}
}

?>


//Code Explained

register_globals   This feature has been DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 5.4.0.

in this code wordpress doing the same, deprecating register global if it is on due to security reason.

ini_get()  — Gets the value of a configuration option.


## array_merge()

<?php

$a1=array("red","green");
$a2=array("blue","yellow");

print_r(array_merge($a1,$a2));

//output 
Array ( [0] => red [1] => green [2] => blue [3] => yellow )

?>


<?php
	
$var_name=array('A','B','C');

if (is_array($var_name)){  
     echo 'This is an array....';  
} else {  
    echo 'This is not an array....';  
}

//Output :
This is an array....
?>  

echo true ? "true" : "false";

//Output:
true
