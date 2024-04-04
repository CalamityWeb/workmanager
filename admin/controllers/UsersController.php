<?php

namespace tframe\admin\controllers;

use tframe\common\components\table\GenerateTableData;
use tframe\common\models\Users;
use tframe\core\Application;
use tframe\core\auth\RegisterForm;
use tframe\core\auth\Roles;
use tframe\core\auth\UserRoles;
use tframe\core\Controller;
use tframe\core\Request;
use tframe\core\Response;

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
                Application::$app->session->setFlash('success', Application::t('auth', 'Register successful'));
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
                Application::$app->session->setFlash('success', Application::t('general', 'Update successful!'));
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