<?php
/**
 * Created by PhpStorm.
 * User: smartnet
 * Date: 11.11.17
 * Time: 22:52
 */

namespace SmartNET\SMetricBundle\Users;


class User
{
    public $userID;
    public $userName;
    public $userEMail;
    public $userPass;

    function __construct($uName, $uEMail, $uPass)
    {
        if (!isset($_SESSION['uList']))
            $this->userID = 0;
        if (count($_SESSION['uList']) == 0)
            $this->userID = 0;
        else
            $this->userID = count($_SESSION['uList']);
        $this->userName = $uName;
        $this->userEMail = $uEMail;
        $this->userPass = password_hash($uPass, PASSWORD_DEFAULT);
    }

    public function Add() {

        $_SESSION['uList'][] = $this;
        return true;
}
}