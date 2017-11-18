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

        $params = [];
        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':

                // Редактирование пользователя
                //
                if (($request->query->get('formName') == 'UserEdit') &&
                    ($request->query->get('btnSubmit') == 'btnSave')) {
                    $guid =   $request->query->get('uNumber');                // берём ID юзера
                    $name   =   $request->query->get('uName');
                    $email  =   $request->query->get('uEMail');
                    $pass   =   $request->query->get('uPass');
                    $bday   =   $request->query->get('uBDay');

                    $result = $conn->query("SELECT * FROM users WHERE guid ='".$guid."'");
                    $user = $result->fetch();

                    if ($name == '')
                        $name = $user['name'];
                    if ($email == '')
                        $email = $user['email'];
                    if ($pass == '')
                        $pass = $user['pass'];
                    if ($bday == '')
                        $bday = $user['bday'];

                    $conn->update('users', [
                            'name'  =>  $name,
                            'email' =>  $email,
                            'pass'  =>  $pass,
                            'bday'  =>  $bday
                        ],
                        [
                            'guid' => $guid
                        ]);
                }

                // Удаление пользователя
                //
                if (($request->query->get('formName') == 'UserDelete') &&   // если запрос от формы UserDelete
                    ($request->query->get('btnSubmit') == 'btnDelete')) {   // и нажата кнопка "Удалить"
                    $guid =   $request->query->get('uNumber');                // берём ID юзера
                    $conn->delete('users', [                                    // и удаляем его по этому ID
                        'guid'    =>  $guid
                    ]);
                }

                // создание нового пользователя
                //
                if (($request->query->get('formName') == 'NewUser') &&
                    ($request->query->get('btnSubmit') == 'btnSaveNew')) {
                    $name   =   $request->query->get('uName');
                    $email  =   $request->query->get('uEMail');
                    $pass   =   $request->query->get('uPass');
                    $conn->insert('users', [
                        'name'  => $name,
                        'email' => $email,
                        'pass'  => $pass
                    ]);
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
        // вывод текущего списка пользователей
        //
        $result = $conn->query("SELECT * FROM users ORDER BY name");
        $users = $result->fetchAll();
        return $this->render('@Blog/default/dblist.html.twig', [
            'users'     => $users
        ]);
    }


    public function newAction(Request $request, Connection $conn)
    {
        return $this->render('@Blog/default/new.html.twig', [
        ]);
    }


    public function dbviewAction(Request $request, $uN, Connection $conn)
    {

        $result = $conn->query("SELECT * FROM users WHERE guid ='".$uN."'");
        $user = $result->fetch();

        $uName = $user['name'];
        $uEMail = $user['email'];
        $uPass = $user['pass'];
        return $this->render('@Blog/default/dbview.html.twig', [
            'uN'    => $uN,
            'uName' =>  $uName,
            'uEMail' => $uEMail,
            'uPass' => $uPass
        ]);
    }

    public function dbeditAction(Request $request, $uN, Connection $conn)
    {

        $result = $conn->query("SELECT * FROM users WHERE guid ='".$uN."'");
        $user = $result->fetch();

        return $this->render('@Blog/default/dbedit.html.twig', [
            'user'    => $user
        ]);
    }

    public function deleteAction(Request $request, $uN, Connection $conn)
    {
        $result = $conn->query("SELECT * FROM users WHERE guid ='".$uN."'");
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
