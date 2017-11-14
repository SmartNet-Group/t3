<?php
/**
 * Created by PhpStorm.
 * User: smartnet
 * Date: 13.11.17
 * Time: 20:06
 */

namespace SmartNET\SMetricBundle;

function InitAll() {

/*
    $uL = new \SMetricBundle\Users\UsersList();
    $uList = &$uL->usersList;
*/
    if (isset($_SESSION['start'])) {
        $_SESSION['uList'] = null;
    }

    return true;
}

