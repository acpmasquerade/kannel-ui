<?php
## ---------------- Configuration Parameters ----------------------------------

error_reporting(0);

# Kannel provided default administration interface endpoint
$server = "some-server-url:some-port";
# Admin password to access the administration commands in Kannel
$admin_password = "some-admin-password";
# Kannel status URL / File
#$kannel_url = "status.xml";
$kannel_url = "{$server}/status.xml?password=some-password";

## ---------------- Configuration ends ----------------------------------------