<?php

namespace calamity\admin\controllers;

use calamity\common\components\table\GenerateTableData;
use calamity\common\models\Users;
use calamity\core\Calamity;
use calamity\core\auth\RegisterForm;
use calamity\core\auth\Roles;
use calamity\core\auth\UserRoles;
use calamity\core\Controller;
use calamity\core\Request;
use calamity\core\Response;

class UsersController extends Controller {
    public function listUsers (): string {
        $this->setLayout('main');

        return $this->render('users.list', ['users' => GenerateTableData::convertData(Users::findMany())]);
    }

    public function createUser (Request $request): string {
        $this->setLayout('main');

        $registerForm = new RegisterForm();
        if ($request->isPost()) {
            $registerForm->loadData($request->getBody());
            $registerForm->agreeTerms = true;
            if ($registerForm->validate() and $registerForm->register()) {
                Calamity::$app->session->setFlash('success', Calamity::t('auth', 'Register successful'));
            }
        }

        return $this->render('users.create', ['registerForm' => $registerForm]);
    }

    public function manageUser (Request $request, Response $response): string {
        $this->setLayout('main');

        /** @var Users $user */
        $user = Users::findOne(['id' => $request->getRouteParam('id')]);
        $roles = Roles::findMany();
        $userRoles = $user->getRoles();

        if ($request->isPost()) {
            $user->loadData($request->getBody());
            if ($user->validate()) {
                $user->email_confirmed = isset($request->getBody()['email_confirmed']) ? true : $user->email_confirmed;

                /** @var $assignment UserRoles */
                foreach (UserRoles::findMany(['userId' => $user->id]) as $assignment) {
                    if ($assignment->roleId != 1) {
                        $assignment->delete();
                    }
                }
                if (isset($request->getBody()["roles"])) {
                    foreach ($request->getBody()["roles"] as $id) {
                        $assignment = new UserRoles();
                        $assignment->userId = $user->id;
                        $assignment->roleId = $id;
                        $assignment->save();
                    }
                }

                $user->save();
                Calamity::$app->session->setFlash('success', Calamity::t('general', 'Update successful!'));
            }
        }

        return $this->render('users.manage',
            [
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $userRoles,
            ],
        );
    }
}