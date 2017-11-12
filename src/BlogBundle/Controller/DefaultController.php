<?php

namespace BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SMetricBundle\Users\UsersList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SmartNET\SMetricBundle\Dep;
use SmartNET\SMetricBundle\Users;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('@Blog/default/index.html.twig', [
        ]);
    }

    public function listAction(Request $request)
    {
        global $uL;
        $uList = $uL->usersList;
        $uNum = count($uList);
        $query = $_SERVER['QUERY_STRING'];
        return $this->render('@Blog/default/list.html.twig', [
            'uList' => $uList,
            'uNum'  => $uNum,
            'query' => $query
        ]);
    }

    public function newAction(Request $request)
    {
        return $this->render('@Blog/default/new.html.twig', [
        ]);
    }

    public function editAction(Request $request, $uN)
    {
        global $uL;
        $uName = $uL->usersList[$uN]->userName;
        $uEMail = $uL->usersList[$uN]->userEMail;
        $uPass = $uL->usersList[$uN]->userPass;
        return $this->render('@Blog/default/edit.html.twig', [
            'uN'    => $uN,
            'uName' =>  $uName,
            'uEMail' => $uEMail,
            'uPass' => $uPass
        ]);
    }

    public function deleteAction(Request $request, $uN)
    {
        global $uL;
        $uName = $uL->usersList[$uN]->userName;
        $uEMail = $uL->usersList[$uN]->userEMail;
        $uPass = $uL->usersList[$uN]->userPass;
        return $this->render('@Blog/default/delete.html.twig', [
            'uN'    => $uN,
            'uName' =>  $uName,
            'uEMail' => $uEMail,
            'uPass' => $uPass
        ]);
    }
}
