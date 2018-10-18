<?php

function serverMonitoring_ConfigOptions($params) {
    global $product;
    $serviceid = $params['serviceid'];
    $userid = $params['clientsdetails']['userid'];
    $package = $params['configoption1'];

    if (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php");
    } elseif (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php");
    }

    $minutes = $_ADDONLANG['minutes'];
    $minute = $_ADDONLANG['minute'];
    $hours = $_ADDONLANG['hours'];
    $hour = $_ADDONLANG['hour'];
    $yes = $_ADDONLANG['yes'];
    $no = $_ADDONLANG['no'];

    $configarray = array(
        "package" => array(
            "FriendlyName" => $_ADDONLANG['package'],
            "Type" => "dropdown",
            "Options" => "1 " . $minute . ",2 " . $minutes . ",5 " . $minutes . ",10 " . $minutes . ",15 " . $minutes . ",20 " . $minutes . ",30 " . $minutes . ",45 " . $minutes . ",60 " . $minutes . "",
            "Default" => "2 Minutes",
        ),
        "limit" => array(
            "FriendlyName" => $_ADDONLANG['limit'],
            "Type" => "dropdown",
            "Options" => "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100",
            "Default" => "1",
        ),
        "allowbl" => array(
            "FriendlyName" => $_ADDONLANG['allowbl'],
            "Type" => "yesno",
        ),
        "blpackage" => array(
            "FriendlyName" => $_ADDONLANG['blpackage'],
            "Type" => "dropdown",
            "Options" => "1 " . $hour . ",2 " . $hours . ",5 " . $hours . ",8 " . $hours . ",16 " . $hours . ",24 " . $hours . ",32 " . $hours . ",40 " . $hours . ",48 " . $hours . "",
            "Default" => "24 " . $hours,
        ),
        "smscredits" => array(
            "FriendlyName" => $_ADDONLANG['smscredits'],
            "Type" => "text",
            "Size" => "15",
            "Default" => "0",
        ),
        "allowcustomports" => array(
            "FriendlyName" => $_ADDONLANG['allowcustomports'],
            "Type" => "yesno",
        ),
        "allowsolusvm" => array(
            "FriendlyName" => $_ADDONLANG['allowsolusvmmonitoring'],
            "Type" => "yesno",
        ),
        "allowmonitoring" => array(
            "FriendlyName" => $_ADDONLANG['allowservermonitoring'],
            "Type" => "yesno",
        ),
        "KeywordMonitoring" => array(
            "FriendlyName" => $_ADDONLANG['KeywordMonitoring2'],
            "Type" => "yesno",
        ),
        "MaintenanceWindows" => array(
            "FriendlyName" => $_ADDONLANG['MaintenanceWindows2'],
            "Type" => "yesno",
        ),
        "PublicStatsCount" => array(
            "FriendlyName" => $_ADDONLANG['PublicStatsCount'],
            "Type" => "dropdown",
            "Options" => "none,unlimited,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100",
            "Default" => "1",
        ),
    );
    return $configarray;
}

function serverMonitoring_CreateAccount($params) {
    global $debug;
    $serviceid = $params['serviceid'];
    $userid = $params['clientsdetails']['userid'];
    $package = $params['configoption1'];
    $defaultcredits = (int) $params['configoption5'];
    $minutes = serverMonitoring_getMinutes($package);

    $query = mysql_query("SELECT * FROM `mod_servermonitoring_services` WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "'");
    $tot = mysql_num_rows($query);

    if (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php");
    } elseif (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php");
    }

    // Order Configuration
    if ($tot == 0) {
        $query = mysql_query("INSERT INTO `mod_servermonitoring_services` SET `uid`='" . $userid . "', `smscredits`='" . $defaultcredits . "', `serviceid`='" . $serviceid . "', `emaillimit`='1', `smslimit`='0',`status`='Active'");
        return 'success';
    } else {
        return "" . $_ADDONLANG['errorCreate'] . "";
    }
}

function serverMonitoring_ChangePackage($params) {
    global $debug;
    $serviceid = $params['serviceid'];
    $userid = $params['clientsdetails']['userid'];
    $package = $params['configoption1'];

    if (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php");
    } elseif (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php");
    }

    $query = mysql_query("SELECT * FROM `mod_servermonitoring_services` WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "'");
    $tot = mysql_num_rows($query);

    if ($tot == 1) {
        return "success";
    } else {
        return "" . $_ADDONLANG['errorChangePackage'] . "";
    }
}

function serverMonitoring_SuspendAccount($params) {
    global $debug;
    $serviceid = $params['serviceid'];
    $userid = $params['clientsdetails']['userid'];
    $package = $params['configoption1'];

    $query = mysql_query("SELECT * FROM `mod_servermonitoring_services` WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "' AND `status`='Active'");
    $tot = mysql_num_rows($query);

    if (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php");
    } elseif (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php");
    }

    if ($tot == 1) {
        $query = mysql_query("UPDATE `mod_servermonitoring_services` SET `status`='Suspended' WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "'");
        return 'success';
    } else {
        return "" . $_ADDONLANG['errorSuspend'] . "";
    }
}

function serverMonitoring_UnsuspendAccount($params) {
    global $debug;
    $serviceid = $params['serviceid'];
    $userid = $params['clientsdetails']['userid'];
    $package = $params['configoption1'];

    $query = mysql_query("SELECT * FROM `mod_servermonitoring_services` WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "' AND `status`='Suspended'");
    $tot = mysql_num_rows($query);

    if (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php");
    } elseif (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php");
    }

    if ($tot == 1) {
        $query = mysql_query("UPDATE `mod_servermonitoring_services` SET `status`='Active' WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "'");
        return 'success';
    } else {
        return "" . $_ADDONLANG['errorUnsuspend'] . "";
    }
}

function serverMonitoring_TerminateAccount($params) {
    global $debug;
    $serviceid = $params['serviceid'];
    $userid = $params['clientsdetails']['userid'];
    $package = $params['configoption1'];

    $query = mysql_query("SELECT * FROM `mod_servermonitoring_services` WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "'");
    $data = mysql_fetch_assoc($query);
    $tot = mysql_num_rows($query);

    if (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php");
    } elseif (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php");
    }

    if ($tot == 1) {
        $query = mysql_query("DELETE FROM `mod_servermonitoring_services` WHERE `uid`='" . $userid . "' AND `serviceid`='" . $serviceid . "'");
        $query = mysql_query("DELETE FROM `mod_servermonitoring_monitors` WHERE `serviceid`='" . $data['id'] . "'");
        return 'success';
    } else {
        return "" . $_ADDONLANG['errorTerminate'] . "";
    }
}

function serverMonitoring_getMinutes($string) {
    $string = explode(" ", $string);
    $string = preg_replace("/[^0-9]/", "", $string[0]);
    return trim($string);
}

function serverMonitoring_ClientArea($params) {
    global $CONFIG;

    $serviceid = $params['serviceid'];
    $userid = $params['clientsdetails']['userid'];
    $package = $params['configoption1'];

    if (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/" . $CONFIG['Language'] . ".php");
    } elseif (file_exists(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php")) {
        include(ROOTDIR . "/modules/addons/servermonitoring/lang/english.php");
    }

    $code = '<a href="index.php?m=servermonitoring&id=' . $serviceid . '"><button type="button" class="btn btn-success">' . $_ADDONLANG['managemonitors'] . '</button></a>';

    return $code;
}

?>