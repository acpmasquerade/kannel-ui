<?php
$toggle_config = array(
    "kannel_table" => "enabled",
    "kannel_commands" => "enabled",
    "version" => "enabled",
    "status" => "enabled",
    "wdp" => "disabled",
    "sms" => "enabled",
    "dlr" => "enabled",
    "boxes" => "enabled",
    "smsc_table" => "enabled"
    );
$server = "http://192.168.144.47:15024";
$admin_password = "admin";
$status_password = "status";
if($_GET){
    $query_parameters = http_build_query(array(            
            "smsc" => $_GET["smsc_id"],
            "password" => $admin_password
        ));
         
        // STEP 2
        // build the url
        $url = $server."/{$_GET["method"]}?{$query_parameters}";

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
$kannel_status = file_get_contents("status.xml");
// $kannel_status = file_get_contents("{$server}/status.xml?password={$status_password}");
$status_xml = simplexml_load_string($kannel_status);
?>
<link href="bootstrap-combined.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="kannel.css" type="text/css" media="screen" /> -->
<html>
<body>
    <div class="container">
    <?php if(isset($response)):?>
        <div class="notification">
            <?php echo $response;?>
        </div>
    <?php endif;?>    
  
    <?php if($toggle_config["kannel_table"] === "enabled"):?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar">
            <ul class="nav nav-list">
              <li><a href="#">Suspend</a></li>
              <li><a href="#">Suspend</a></li>
              <li><a href="#">Suspend</a></li>
              <li><a href="#">Suspend</a></li>
              <li><a href="#">Suspend</a></li>
              <li><a href="#">Suspend</a></li>
            </ul>
    </div>
</div>
    <div id="content" class="span9">
      <table class="table table-bordered table-striped table-striped" id="kannel">
        <tr class="kannel-row" id="kannel-summary">
            <td colspan="7">
                <pre><?php echo trim($status_xml->version); ?></pre>
            </td>
        </tr>
        <tr>
            <th class="head">
                Status
            </th>
            <td colspan="6">
                <?php echo $status_xml->status; ?>
            </td>
        </tr>
        <tr>
            <th rowspan="3" class="head">
                WDP
            </th>    
            <th>
                Recieved
            </th>
            <th>
                Sent
            </th>
            <th colspan="4" rowspan="3"></th>        
        </tr>
        <tr>
            <td>
                <?php echo "Total: (" . $status_xml->wdp->received->total.")"; ?>
            </td>
            
            <td>
                <?php echo "Total: (" . $status_xml->wdp->sent->total.")"; ?>
            </td>
            
        </tr>
        <tr>
            <td>
                <?php echo "Queued: (" . $status_xml->wdp->received->queued.")"; ?>
            </td>
            <td>
                <?php echo "Queued: (" . $status_xml->wdp->sent->queued.")"; ?>
            </td>
        </tr>
        <tr>
            <th rowspan="3" class="head" >
                SMS
            </th>   
            <th>
                Recieved
            </th>
             <th>
                Sent
            </th>
            <th>
                Storesize
            </th>
            <th>
                Inbound
            </th>
            <th>
                Outbound
            </th>
            <th rowspan="3"></th>
            
            
        </tr>
        <tr>
            <td>
                <?php echo "Total: (" . $status_xml->sms->received->total.")"; ?>
            </td>
           
            <td>
                <?php echo "Total: (" . $status_xml->sms->sent->total.")"; ?>
            </td>
            <td rowspan="2">
                <?php echo $status_xml->sms->storesize; ?>
            </td>
            <td rowspan="2">
                <?php echo $status_xml->sms->inbound; ?>
            </td>
            <td rowspan="2">
                <?php echo $status_xml->sms->outbound; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo "Queued: (" . $status_xml->sms->received->queued.")"; ?>
            </td>
            <td>
                <?php echo "Queued: (" . $status_xml->sms->sent->queued.")"; ?>
            </td>
        </tr>
        <tr>
            <th rowspan="2" class="head">
                DLR
            </th>   
            <th>
                Recieved
            </th>
            <th>
                Sent
            </th>

            <th>
                Inbound
            </th>
            <th>
                Outbound
            </th>
            <th>
                Queued
            </th>
            <th>
                Storage
            </th>
            
        </tr>
        <tr>       
            <td>
                <?php echo "Total: (" . $status_xml->dlr->received->total.")"; ?>
            </td>
            
            <td>
                <?php echo "Total: (" . $status_xml->dlr->sent->total.")"; ?>
            </td>
            <td>
                <?php echo $status_xml->dlr->inbound; ?>
            </td>
            <td>
                <?php echo $status_xml->dlr->outbound; ?>
            </td>
            <td>
                <?php echo $status_xml->dlr->queued; ?>
            </td>
            <td>
                <?php echo $status_xml->dlr->storage; ?>
            </td>
        </tr>   
        <tr>
            <th rowspan="<?php echo count($status_xml->boxes->box)+1;?>" class="head">

                Boxes
            </th>
            <th>Type</th>
            <th>ID</th>
            <th>IP</th>
            <th>Queue</th>
            <th>Status</th>
            <th>SSL</th>
        </tr>


        <?php foreach ($status_xml->boxes->box as $some_key => $some_box): ?>
            <tr>            
                <td >
                    <?php echo $some_box->type; ?>
                </td>
                <td>
                    <?php echo $some_box->id; ?>
                </td>
                <td>
                    <?php echo $some_box->IP; ?>
                </td>
                <td><?php echo $some_box->queue; ?></td>
                <td>
                    <?php echo $some_box->status; ?>
                </td>
                <td>
                    <?php echo $some_box->ssl; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <a id="toggleSidebar" href="#" class="toggles"><i class="icon-chevron-right"></i></a>
  </div>
</div>    
<?php endif;?>
    <table class="table table-bordered table-striped table-striped" id="smscs">

        <thead>
            <th colspan="7" class="head">
                SMSCS
            </th>
        </thead>
        <tr>
            <th>Action</th>
            <th>ID</th>
            <th>Status</th>
            <th>SMS</th>
            <th>DLR</th>
            <th>Failed</th>
            <th>Queued</th>
        </tr>

        <?php foreach ($status_xml->smscs->smsc as $some_smsc): ?>        
            <tr>
                <td class="action" rowspan="2">
                    <a href="index.php?method=start-smsc&smsc_id=<?php echo $some_smsc->id;?>" class="btn btn-start btn-primary">START</a>
                    <?php if($some_smsc->status != "dead"):?>
                    <a href="index.php?method=stop-smsc&smsc_id=<?php echo $some_smsc->id;?>" class="btn btn-stop btn-danger">STOP</a>
                    <?php endif;?>
                </td>
                <td rowspan="2">
                    <?php echo $some_smsc->id; ?>
                </td>
                <td rowspan="2">
                    <?php echo $some_smsc->status; ?>
                </td>
                <td>
                    <?php echo "Received: (" . $some_smsc->received->sms . ")"; ?>
                </td>
                <td>
                    <?php echo "Received: (" . $some_smsc->received->dlr . ")"; ?>
                </td>        
                <td rowspan="2">
                    <?php echo $some_smsc->failed; ?>
                </td>
                <td rowspan="2"><?php echo $some_smsc->queued; ?></td>

            </tr>
            <tr>
                <td><?php echo  "Sent: (" . $some_smsc->sent->sms . ")"?></td>
                <td><?php echo  "Sent: (" . $some_smsc->sent->dlr . ")"?></td>
            </tr>
        <?php endforeach; ?>
    </div>
</body>
</html>