<?php
/**
 * Created by PhpStorm.
 * User: smartnet
 * Date: 12.11.17
 * Time: 0:30
 */

namespace SMetricBundle\Users;


use SmartNET\SMetricBundle\Users\User;

class UsersList
{
    function __construct()
    {
        $u1 = new User();
        $u1->userID = 0;
        $u1->userName = 'Иван';
        $u1->userEMail = 'ivan@kachinskiy.ru';
        $u1->userPass = 'u0pass';

        $u2 = new User();
        $u2->userID = 1;
        $u2->userName = 'Таня';
        $u2->userEMail = 'tak@pisem.net';
        $u2->userPass = 'u1pass';

        $u3 = new User();
        $u3->userID = 2;
        $u3->userName = 'Настя';
        $u3->userEMail = 'nastya@kachinskaya.ru';
        $u3->userPass = 'u2pass';

        $this->usersList =[];
        $this->usersList[0] = $u1;
        $this->usersList[1] = $u2;
        $this->usersList[2] = $u3;

        return $this->usersList;
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return "Это список юзеров";
    }

}