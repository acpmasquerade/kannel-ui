<?php
## ---------------- Configuration Parameters ----------------------------------

error_reporting(0);

# Kannel provided default administration interface endpoint
$server = "http://127.0.0.1:13000";

# Admin password to access the administration commands in Kannel
$admin_password = "some-admin-password";

# Kannel status URL / File
$kannel_url = "{$server}/status.xml?password=";

## ---------------- Configuration ends ----------------------------------------