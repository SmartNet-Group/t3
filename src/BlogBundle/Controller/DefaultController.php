<?php

namespace BlogBundle\Controller;
require __DIR__ . '/../../../src/SmartNET/SMetricBundle/InitAll.php';

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use function SmartNET\SMetricBundle\InitAll;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SmartNET\SMetricBundle\Dep;
use SmartNET\SMetricBundle\Users;
use Doctrine\DBAL\Driver\Connection;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        if (!isset($_SESSION['start'])) {
            $_SESSION['start'] = true;
            InitAll();
        }
        return $this->render('@Blog/default/index.html.twig', [
        ]);
    }

    public function dblistAction(Request $request, Connection $conn)
    {
        $result = $conn->query('SELECT * FROM users');
        $users = $result->fetchAll();
        $action = "";
        $params = [];
        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                if ($request->query->get('formName') == 'UserEdit') {
                    $action = "Обрабатываем отредактированного пользователя";
                }
                if ($request->query->get('formName') == 'UserDelete') {
                    $action = "Обрабатываем удаление пользователя";
                }
                if ($request->query->get('fomName') == 'NewUser') {
                    $action = 'Обрабатываем создание нового пользователя';
                }
                $params = &$_GET;
                break;
            case 'POST':
                if ($request->request->get('formName') == 'UserEdit') {
                    $action = "Обрабатываем отредактированного пользователя";
                }
                if ($request->request->get('formName') == 'UserDelete') {
                    $action = "Обрабатываем удаление пользователя";
                }
                if ($request->request->get('fomName') == 'NewUser') {
                    $action = 'Обрабатываем создание нового пользователя';
                }
                $params = &$_GET;
                break;
            default:
        }
//        if (!isset($_SESSION['start'])) {
//            $_SESSION['start'] = true;
//            InitAll();
//        }
        return $this->render('@Blog/default/dblist.html.twig', [
            'users'     => $users,
            'action'    => $action,
            'params'    => $params
        ]);
    }


    public function newAction(Request $request, Connection $conn)
    {
        return $this->render('@Blog/default/new.html.twig', [
        ]);
    }


    public function dbeditAction(Request $request, $uN, Connection $conn)
    {

        $result = $conn->query('SELECT * FROM users WHERE id='.$uN);
        $user = $result->fetch();

        $uName = $user['name'];
        $uEMail = $user['email'];
        $uPass = $user['pass'];
        return $this->render('@Blog/default/dbedit.html.twig', [
            'uN'    => $uN,
            'uName' =>  $uName,
            'uEMail' => $uEMail,
            'uPass' => $uPass
        ]);
    }

    public function deleteAction(Request $request, $uN, Connection $conn)
    {
        $result = $conn->query('SELECT * FROM users WHERE id='.$uN);
        $user = $result->fetch();

        $uName = $user['name'];
        $uEMail = $user['email'];
        $uPass = $user['pass'];
        return $this->render('@Blog/default/delete.html.twig', [
            'uN'    => $uN,
            'uName' =>  $uName,
            'uEMail' => $uEMail,
            'uPass' => $uPass
        ]);
    }
}
