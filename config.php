<?php
## ---------------- Configuration Parameters ----------------------------------

error_reporting(0);

# Kannel provided default administration interface endpoint
$server = "http://kannel-server:30000";

# Admin password to access the administration commands in Kannel
$admin_password = "some-admin-password";

# Kannel status URL / File
$kannel_url = "{$server}/status.xml?password=status-password";

## ---------------- Configuration ends ----------------------------------------

$users_config = parse_ini_file(__DIR__."/users.ini", TRUE);

