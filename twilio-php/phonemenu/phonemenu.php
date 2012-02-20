<?php

// @start snippet
/* Define Menu */
$web = array();
$web['default'] = array('receptionist','hours', 'location', 'duck');
$web['location'] = array('receptionist','east-bay', 'san-jose', 'marin');
$web['days'] = array('monday','tuesday','wednesday','thursday','friday','default');
$web['choice_monday'] = array('','monday');
$web['choice_tuesday'] = array('tuesday');
$web['choice_wednesday'] = array('wednesday');
$web['choice_thursday'] = array('thursday');
$web['choice_friday'] = array('friday');
$web['choice_monday_time'] = array('','monday_time');
$web['choices'] = array('1','2');

/* Get the menu node, index, and url */
$node = $_REQUEST['node'];
$index = (int) $_REQUEST['Digits'];
$url = 'http://'.dirname($_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']).'/phonemenu.php';
//$day = $_REQUEST['day'];
/* get the day and the choice */
//$day_index  = array_search($_REQUEST['day'], $web['days']);

/* Check to make sure index is valid */
if(isset($web[$node]) || count($web[$node]) >= $index && !is_null($_REQUEST['Digits'])){
    $destination = $web[$node][$index];
}
else{
    $destination = NULL;   
}
// @end snippet

// @start snippet
/* Render TwiML */
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Response>\n";
switch($destination) {
    case 'hours': ?>
        <Say>Initech is open Monday through Friday, 9am to 5pm</Say>
        <Say>Saturday, 10am to 3pm and closed on Sundays</Say>
        <?php break;
    case 'location': ?>
        <Say>Initech is located at 101 4th St in San Francisco California</Say>
        <Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=location'; ?>" numDigits="1">
            <Say>For directions from the East Bay, press 1</Say>
            <Say>For directions from San Jose, press 2</Say>
        </Gather>
    <?php break;

    case 'monday'; ?>
        <Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=choice_monday_time'; ?>" numDigits="1">
                <Say>If you are free on Monday morning between 8 to 10 press 1 else press 2</Say>
        </Gather>
        <?php break;
    case 'monday_time'; ?>
        <Say> Great, we have fixed a session for you on Monday with a Raise Voice teacher. We will send you a reminder text before the session </Say>
        
        <?php break;
    case 'tuesday'; ?>
     <Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=choice_tuesday'; ?>" numDigits="1">
               
                <Say>If you are free on Tuesday morning between 8 to 10 press 1 else press 2</Say>
    </Gather>
        <?php break;
    case 'wednesday'; ?>
     <Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=choice_wednesday'; ?>" numDigits="1">

                <Say>If you are free on Wednesday morning between 8 to 10 press 1 else press 2</Say>
    </Gather>
    <?php break;    
    case 'thursday'; ?>
     <Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=choice_thursday'; ?>" numDigits="1">
                <Say>If you are free on Thursday morning between 8 to 10 press 1 else press 2</Say>
    </Gather>
        <?php break;
    case 'friday'; ?>
     <Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=choice_friday'; ?>" numDigits="1">
                <Say>If you are free on Friday morning between 8 to 10 press 1 else press 2</Say>
    </Gather>
        <?php break;
    default: ?>
        <Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=choice_monday'; ?>" numDigits="1">
            <Say>Hello and welcome to the Raise Voice Menu</Say>
            <Say>Lets complete our registration process</Say>
            <Say>Press 1 to start telling us the days else press 2 to hang up</Say>
        </Gather>
        <?php
    break;
}
// @end snippet

// @start snippet
if($destination && $destination != 'receptionist') { ?>
    <Pause/>
   <Say>Main Menu</Say>
    <Redirect><?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php' ?></Redirect>
<?php }
// @end snippet

?>

</Response>

