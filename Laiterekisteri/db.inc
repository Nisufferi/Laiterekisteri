<?php
function getUsername($username){
    $username = $_SESSION['username'];
    return $username;
}
function testi( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Testi: " . $output . "' );</script>";
}

	
?>