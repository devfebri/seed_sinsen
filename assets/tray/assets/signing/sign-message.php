<?php
/*
 * Echoes the signed message and exits
 */

// #########################################################
// #             WARNING   WARNING   WARNING               #
// #########################################################
// #                                                       #
// # This file is intended for demonstration purposes      #
// # only.                                                 #
// #                                                       #
// # It is the SOLE responsibility of YOU, the programmer  #
// # to prevent against unauthorized access to any signing #
// # functions.                                            #
// #                                                       #
// # Organizations that do not protect against un-         #
// # authorized signing will be black-listed to prevent    #
// # software piracy.                                      #
// #                                                       #
// # -QZ Industries, LLC                                   #
// #                                                       #
// #########################################################

// Sample key.  Replace with one used for CSR generation
// $KEY = 'key.pem';
// $PASS = 'sinsen';

$KEY = 'private-key.pem';

$req = $_GET['request'];
$privateKey = openssl_get_privatekey(file_get_contents($KEY), $PASS);
// $privateKey = openssl_get_privatekey(file_get_contents($KEY));

$signature = null;
openssl_sign($req, $signature, $privateKey);

/*
// Or alternately, via phpseclib
include('Crypt/RSA.php');
$rsa = new Crypt_RSA();
$rsa->loadKey(file_get_contents($KEY));
$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
$signature = $rsa->sign($req);
*/

if ($signature) {
	header("Content-type: text/plain");
	echo base64_encode($signature);
	exit(0);
}

echo '<h1>Error signing message</h1>';
exit(1);

?>
