<?php

namespace BlogBundle\Controller;
require __DIR__.'/../../../src/SmartNET/SMetricBundle/InitApp.php';

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use function SmartNET\SMetricBundle\InitAll;
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
        global $uList;
        InitAll();
        $query = $_SERVER['QUERY_STRING'];
        $act = "";
//        $session = $request->getSession();
//        if (!$session->has('start')) {
//            $session->set('start', true);
//        }

        if (isset($_POST['btnSubmit'])) {
            if ($_POST['btnSubmit'] == 'btnSave') {
                // Сохраняем отредактированного пользователя в базу
                $act = "Редактирование #".$_POST['uNumber'];
            } elseif ($_POST['btnSubmit'] == 'btnNotSave') {
                $act = "Оставляем 'как есть' #".$_POST['uNumber'];
                // Ничего не сохраняем и переходим к списку
            } elseif ($_POST['btnSubmit'] == 'btnDelete') {
                // удаляем заданного пользователя
                $act = "Удаление #".$_POST['uNumber'];
            } elseif ($_POST['btnSubmit'] == 'btnNotDelete') {
                // Ничего не удаляем и переходим к списку
                $act = "НЕ удаляем #".$_POST['uNumber'];
            } elseif ($_POST['btnSubmit'] == 'SaveNew') {
                // Сохраняем нового пользователя
                $newUser = new Users\User();
                $newUser->userID = random_int(0, 1000000);
                $newUser->userName = $_POST['uName'];
                $newUser->userEMail = $_POST['uEMail'];
                $newUser->userPass = $_POST['uPass'];
                $uList[] = $newUser;
                $act = "Сохраняем нового пользователя";
            } elseif ($_POST['btnSubmit'] == 'DoNothing') {
                //  Ничего не делаем и переходим к списку
                $act = "Ничего не делаем!";
            }
        }
        $uNum = count($uList);

        return $this->render('@Blog/default/list.html.twig', [
            'uList' => $uList,
            'uNum'  => $uNum,
            'query' => $query,
            'action' => $act,
            'start' => $_SESSION['start']
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
