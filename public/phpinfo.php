<?php

if (extension_loaded('sqlsrv')) {
  echo "sqlsrv extension is loaded.\n";
} else {
  echo "sqlsrv extension is not loaded.\n";
}

if (extension_loaded('pdo_sqlsrv')) {
  echo "pdo_sqlsrv extension is loaded.\n";
} else {
  echo "pdo_sqlsrv extension is not loaded.\n";
}

// Show all information, defaults to INFO_ALL
// phpinfo();

?>