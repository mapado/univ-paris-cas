<?php declare(strict_types=1);

/**
 *   Example for a simple cas 2.0 client
 *
 * PHP Version 7
 *
 * @file     example_simple.php
 *
 * @category Authentication
 *
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @see     https://wiki.jasig.org/display/CASC/phpCAS
 */

// Load the settings from the central config file
require 'vendor/autoload.php';

require_once 'config.php';
// Load the CAS lib
// require_once $phpcas_path . '/CAS.php';

// Enable debugging
phpCAS::setLogger();
// Enable verbose error messages. Disable in production!
phpCAS::setVerbose(true);



// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, $client_service_name);
// phpCAS::client(SAML_VERSION_1_1, $cas_host, $cas_port, $cas_context, $client_service_name);

// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
phpCAS::setCasServerCACert($cas_server_ca_cert_path);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
// phpCAS::setNoCasServerValidation();


// phpCAS::setServerServiceValidateURL('https://autht1.app.u-paris.fr/idp/profile/cas/serviceValidate');
$query = http_build_query(
  [
    'service' => $client_service_name,
    'ticket' => $_REQUEST['ticket'] ?? ''
  ]
  );

$validateUrl = 'https://autht1.app.u-paris.fr/idp/profile/cas/serviceValidate?' . $query;

phpCAS::setServerServiceValidateURL($validateUrl);
phpCAS::setServerSamlValidateURL($validateUrl);

// force CAS authentication
phpCAS::forceAuthentication();

// at this step, the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().

// logout if desired
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}


// logout if desired
if (isset($_REQUEST['renew'])) {
  phpCAS::renewAuthentication();
}

// for this test, simply print that the authentication was successfull
?>
<html>
  <head>
    <title>phpCAS simple client</title>
  </head>
  <body>
    <h1>Successfull Authentication!</h1>

    <dl style='border: 1px dotted; padding: 5px;'>
      <dt>Current dir</dt><dd><?php echo __DIR__; ?></dd>
      <dt>Current script</dt><dd><?php echo basename($_SERVER['SCRIPT_NAME']); ?></dd>
      <dt>session_name():</dt><dd> <?php echo session_name(); ?></dd>
      <dt>session_id():</dt><dd> <?php echo session_id(); ?></dd>
    </dl>

    <p>the user's login is <b><?php echo phpCAS::getUser(); ?></b>.</p>

    <?php var_dump(phpCAS::getAttributes());
    
    foreach (phpCAS::getAttributes() as $key => $value) {
      if (is_array($value)) {
          echo '<li>', $key, ':<ol>';
          foreach ($value as $item) {
              echo '<li><strong>', $item, '</strong></li>';
          }
          echo '</ol></li>';
      } else {
          echo '<li>', $key, ': <strong>', $value, '</strong></li>' . PHP_EOL;
      }
  }
    
    ?>
    
    <p>phpCAS version is <b><?php echo phpCAS::getVersion(); ?></b>.</p>
    <p><a href="?logout=">Logout</a></p>
  </body>
</html>