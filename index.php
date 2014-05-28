<?php

include(__DIR__."/config.php");

if ($_GET) {
    if ($_GET["command"] === "smsc") {
        $query_parameters = http_build_query(array(
            "smsc" => $_GET["smsc_id"],
            "password" => $admin_password
        ));
    } elseif ($_GET["command"] === "kannel") {
        $query_parameters = http_build_query(array(
            "password" => $admin_password
        ));
    } else {
        print_r("Invalid Command");
        die();
    }
    // STEP 2
    // build the url
    $url = $server . "/{$_GET["method"]}?{$query_parameters}";
    // create a new cURL resource
    $ch = curl_init();
    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
    // grab URL and pass it to the browser
    $response = curl_exec($ch);
    curl_close($ch);
}
// $kannel_status = file_get_contents("status.xml");
$kannel_status = file_get_contents($kannel_url);
$status_xml = simplexml_load_string($kannel_status);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Kannel Version 0.2</title>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
        <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="stylesheets/kannel.css">

        <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="lib/bootstrap/js/bootstrap-scrollspy.js" type="text/javascript"></script>
        <script src="lib/bootstrap/js/bootbox.min.js" type="text/javascript"></script>

        <!-- Demo page code -->
        <style type="text/css">
            #line-chart {
                height:300px;
                width:800px;
                margin: 0px auto;
                margin-top: 1em;
            }
            .brand { font-family: georgia, serif; }
            .brand .first {
                color: #ccc;
                font-style: italic;
            }
            .brand .second {
                color: #fff;
                font-weight: bold;
            }
        </style>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="../assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    </head>

    <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
    <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
    <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
    <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> 
    <body data-spy="scroll" data-target="#navbar-custom"> 
        <!--<![endif]-->

        <!-- <div class="navbar">
            <div class="navbar-inner">
                <a class="brand" href="#"><span class="first">Janaki Tech </span><span class="second">Kannel </span>Version 2.0.alpha</a>
            </div>
        </div> -->
        <div class="navbar navbar-fixed-top navbar-custom">
                    <div id="navbar-custom" class="navbar-inner">
                        <ul class="nav">
                            <li class="active"><a href="#">TOP</a></li>
                            <li><a href="#version-row">VERSION</a></li>
                            <li><a href="#wdp-dlr-row">WDP/DLR</a></li>
                            <li><a href="#boxes-row">BOXES</a></li>
                            <li><a href="#sms-row">SMS</a></li>
                            <li><a href="#smscs-row">SMSCS</a></li>
                        </ul>
                    </div>
                </div>
        <div class="sidebar-nav navbar-fixed-top">
            <!-- <a href="#" class="nav-header" >
                &nbsp;
            </a> -->
            <h2 style='padding:10px;'><center><img src="images/kannel.gif" class="thumbnail"></center></h2>
            <a href="index.php?command=kannel&method=suspend" class="nav-header" ><i class="btn btn-primary btn-mini icon-pause"></i> SUSPEND</a>
            <a href="index.php?command=kannel&method=isolate" class="nav-header" ><i class="btn btn-primary btn-mini icon-flag"></i> ISOLATE</a>
            <a href="index.php?command=kannel&method=resume" class="nav-header" ><i class="btn btn-primary btn-mini icon-repeat"></i> RESUME</a>
            <a href="index.php?command=kannel&method=restart" class="nav-header" ><i class="btn btn-primary btn-mini icon-refresh"></i> RESTART</a>
            <a href="index.php?command=kannel&method=shutdown" class="nav-header" ><i class="btn btn-primary btn-mini icon-off"></i> SHUTDOWN</a>
            <a href="index.php?command=kannel&method=flush-dlr" class="nav-header" ><i class="btn btn-primary btn-mini icon-random"></i> FLUSH-DLR</a>
            <a id="loglevel" href="#" class="nav-header" ><i class="btn btn-primary btn-mini icon-file"></i> LOG-LEVEL</a>
            <a href="index.php?command=kannel&method=reload-lists" class="nav-header" ><i class="btn btn-primary btn-mini icon-list-alt"></i> RELOAD-LISTS</a>

        </div>

        <div class="content content-custom">

            <div class="header">
                <div class="stats">
                    <p class="stat">Status: <span class="number"><?php echo $status_xml->status; ?></span></p>
                </div>
                <h1 class="page-title">Kannel Monitor</h1>
            </div>
            <!-- <ul class="breadcrumb">
                <li><a href="#">Kannel</a> <span class="divider">/</span></li>
                <li class="active">All</li> -->
                
            <!-- </ul> -->
            <div class="container-fluid">
                <div id="version-row" class="row-fluid">
                    <div class="row-fluid">
                        <?php if (isset($response)): ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Response: </strong><?php echo $response; ?>
                            </div>
                        <?php endif; ?>
                        <div class="block">
                            <a href="#version" class="block-heading" data-toggle="collapse">Version</a>
                            <div id="version" class="block-body collapse in">
                                <p>
                                    <br />
                                    <?php echo nl2br($status_xml->version); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="wdp-dlr-row" class="row-fluid">
                        <div class="block span6">
                            <a href="#wdp" class="block-heading" data-toggle="collapse">WDP</a>
                            <div id="wdp" class="block-body collapse in">
                                <table class="table table-bordered table-striped table-striped">
                                    <thead>
                                        <th></th>
                                        <th>Received</th>
                                        <th>Sent</th>
                                    </thead>
                                    <tr>
                                        <th>Total</th>
                                        <td><?php echo $status_xml->wdp->received->total; ?></td>
                                        <td><?php echo $status_xml->wdp->sent->total; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Queued</th>
                                        <td><?php echo $status_xml->wdp->received->queued; ?></td>
                                        <td><?php echo $status_xml->wdp->sent->queued; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="block span6">
                            <a href="#dlr" class="block-heading" data-toggle="collapse">DLR</a>
                            <div id="dlr" class="block-body collapse in">
                                <table class="table table-bordered table-striped table-striped">
                                    <tr>
                                        <th>Received</th>
                                        <td><?php echo "Total: (" . $status_xml->dlr->received->total . ")"; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sent</th>
                                        <td><?php echo "Total: (" . $status_xml->dlr->sent->total . ")"; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Inbound</th>
                                        <td><?php echo $status_xml->dlr->inbound; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Outbound</th>
                                        <td><?php echo $status_xml->dlr->outbound; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Queued</th>
                                        <td><?php echo $status_xml->dlr->queued; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Storage</th>
                                        <td><?php echo $status_xml->dlr->storage; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="boxes-row" class="row-fluid">
                        <div class="block">
                            <a href="#boxes" class="block-heading" data-toggle="collapse">Boxes</a>
                            <div id="boxes" class="block-body collapse in">
                                <table class="table table-bordered table-striped table-striped">
                                    <thead>
                                        <th>Type</th>
                                        <th>ID</th>
                                        <th>IP</th>
                                        <th>Queue</th>
                                        <th>Status</th>
                                        <th>SSL</th>
                                    </thead>
                                    <?php foreach ($status_xml->boxes->box as $some_key => $some_box): ?>
                                        <tr>
                                            <td ><?php echo $some_box->type; ?></td>
                                            <td><?php echo $some_box->id; ?></td>
                                            <td><?php echo $some_box->IP; ?></td>
                                            <td><?php echo $some_box->queue; ?></td>
                                            <td><?php echo $some_box->status; ?></td>
                                            <td><?php echo $some_box->ssl; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="sms-row" class="row-fluid">
                        <div class="block">
                            <a href="#sms" class="block-heading" data-toggle="collapse">SMS</a>
                            <div id="sms" class="block-body collapse in">
                                <table class="table table-bordered table-striped table-striped">
                                    <thead>
                                        <th></th>
                                        <th>Received</th>
                                        <th>Sent</th>
                                        <th>Store-size</th>
                                        <th>Inbound</th>
                                        <th>Outbound</th>
                                    </thead>
                                    <tr>
                                        <th>Total</th>
                                        <td><?php echo $status_xml->sms->received->total; ?></td>
                                        <td><?php echo $status_xml->sms->sent->total; ?></td>
                                        <td rowspan="2"><?php echo $status_xml->sms->storesize; ?></td>
                                        <td rowspan="2"><?php echo $status_xml->sms->inbound; ?></td>
                                        <td rowspan="2"><?php echo $status_xml->sms->outbound; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Queued</th>
                                        <td><?php echo $status_xml->sms->received->queued; ?></td>
                                        <td><?php echo $status_xml->sms->sent->queued; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="smscs-row" class="row-fluid">
                        <div class="block">
                            <a href="#smscs" class="block-heading" data-toggle="collapse">SMSCS</a>
                            <div id="smscs" class="block-body collapse in">
                                <table class="table table-bordered table-striped table-striped">
                                    <thead>
                                        <th>Action</th>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Failed</th>
                                        <th>Queued</th>
                                        <th></th>
                                        <th>SMS</th>
                                        <th>DLR</th>
                                    </thead>
                                    <?php foreach ($status_xml->smscs->smsc as $some_smsc): ?>
                                    <?php //if($some_smsc->id == "5001" || $some_smsc->id == "ncell" || $some_smsc->id == "5001v"):?>
                                        <tr>
                                            <td rowspan="2">
                                                <a href="index.php?command=smsc&method=start-smsc&smsc_id=<?php echo $some_smsc->id; ?>" class="btn btn-start btn-primary">START</a>
                                                <?php if ($some_smsc->status != "dead"): ?>
                                                    <a href="index.php?command=smsc&method=stop-smsc&smsc_id=<?php echo $some_smsc->id; ?>" class="btn btn-stop btn-danger">STOP</a>
                                                <?php endif; ?>
                                            </td>
                                            <td rowspan="2"><?php echo $some_smsc->id; ?></td>
                                            <td rowspan="2"><?php echo $some_smsc->status; ?></td>
                                            <td rowspan="2"><?php echo $some_smsc->failed; ?></td>
                                            <td rowspan="2"><?php echo $some_smsc->queued; ?></td>
                                            <th>Received</th>
                                            <td><?php echo $some_smsc->sms->received; ?></td>
                                            <td><?php echo $some_smsc->dlr->received; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Sent</th>
                                            <td><?php echo $some_smsc->sms->sent; ?></td>
                                            <td><?php echo $some_smsc->dlr->sent; ?></td>
                                        </tr>
                                    <?php //endif;?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <footer>
                        <hr>

                        <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
                        <p class="pull-right">A <a href="http://www.portnine.com/bootstrap-themes" target="_blank">Free Bootstrap Theme</a> by <a href="http://www.portnine.com" target="_blank">Portnine</a></p>

                        <p>&copy; 2012 <a href="http://www.portnine.com" target="_blank">Portnine</a></p>
                    </footer>
                </div>
            </div>
        </div>
<?php
    $loglevel_dialog = <<<EOT
        <span class="dialog-head">Choose a Log-Level</span>\
        <hr>\
        <div class="bootbox-dialog span3">\
            <ul>\
                <li><a href="index.php?command=kannel&method=loglevel&log-level=0"><span class="btn btn-primary">0</span> Debug</a></li>\
                <li><a href="index.php?command=kannel&method=loglevel&log-level=1"><span class="btn btn-primary">1</span> Info</a></li>\
                <li><a href="index.php?command=kannel&method=loglevel&log-level=2"><span class="btn btn-primary">2</span> Warning</a></li>\
                <li><a href="index.php?command=kannel&method=loglevel&log-level=3"><span class="btn btn-primary">3</span> Error</a></li>\
                <li><a href="index.php?command=kannel&method=loglevel&log-level=4"><span class="btn btn-primary">4</span> Panic</a></li>\
            </ul>\
        </div>
EOT;
?>
        <script src="lib/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript">
            var loglevel_content = '<?php echo $loglevel_dialog;?>';
            $("[rel=tooltip]").tooltip();
            $(function() {                
                $("#loglevel").click(function(e){
                    e.preventDefault();
                    bootbox.dialog(
                        loglevel_content,[{
                        "label" : "Cancel"
                    }]);
                });
            });
        </script>
    </body>