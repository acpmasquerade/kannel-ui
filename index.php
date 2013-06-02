<?php
$password = "some_password";
$kannel_status = file_get_contents("status.xml");
$status_xml = simplexml_load_string($kannel_status);
?>
<link rel="stylesheet" href="kannel.css" type="text/css" media="screen" />
<table>
    <tr>
        <td colspan="7" class="head">
            Version
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <?php echo $status_xml->version; ?>
        </td>
    </tr>
    <tr>
        <td class="head">
            Status
        </td>
        <td colspan="6">
            <?php echo $status_xml->status; ?>
        </td>
    </tr>
    <tr>
        <td rowspan="3" class="head">
            WDP
        </td>    
        <th>
            Recieved
        </th>
        <th>
            Sent
        </th>        
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
        <td rowspan="3" class="head" >
            SMS
        </td>   
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
        <td rowspan="2" class="head">
            DLR
        </td>   
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
        <td rowspan="3" class="head">

            Boxes
        </td>
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

    <tr>
        <td colspan="7" class="head">
            SMSCS
        </td>
    </tr>
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
                <a href="start-smsc?smsc={$some_smsc->id}&password={$password}" class="btn btn-start">START</a>
                <a href="stop-smsc?smsc={$some_smsc->id}&password={$password}" class="btn btn-stop">STOP</a>
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
    