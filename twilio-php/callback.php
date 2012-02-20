<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say>Starting your session with <?php echo $_REQUEST['name']?> </Say>
    <Dial><?php echo $_REQUEST['number']?></Dial>
</Response>
