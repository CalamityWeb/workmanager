<?php

namespace calamity\admin\controllers;

use calamity\common\components\auth\AuthAssignments;
use calamity\common\components\auth\AuthItem;
use calamity\common\components\auth\UserRoles;
use calamity\common\components\table\GenerateTableData;
use calamity\common\models\core\Calamity;
use calamity\common\models\core\Controller;
use calamity\common\models\core\exception\NotFoundException;
use calamity\common\models\core\Request;
use calamity\common\models\core\Response;
use calamity\common\models\Roles;
use calamity\common\models\Users;

class RoutesManagement extends Controller {
    /* * Items */
    public function listItems(): string {
        $this->setLayout('main');

        return $this->render('routes-management.items.list', ['items' => GenerateTableData::convertData(AuthItem::findMany())]);
    }

    public function createItem(Request $request, Response $response): string {
        $this->setLayout('main');

        $routeItem = new AuthItem();
        if ($request->isPost()) {
            $routeItem->loadData($request->getBody());
            if ($routeItem->validate() and $routeItem->validateAliases()) {
                $routeItem->id = null;
                $routeItem->save();
                Calamity::$app->session->setFlash('success', Calamity::t('auth', 'Route creation successful'));
            }
        }

        return $this->render('routes-management.items.create', ['routeItem' => $routeItem]);
    }

    public function manageItem(Request $request, Response $response): string {
        $this->setLayout('main');

        /** @var AuthItem $authItem */
        $authItem = AuthItem::findOne(['id' => $request->getRouteParam('id')]);

        if (!$authItem) {
            throw new NotFoundException();
        }

        if ($request->isPost()) {
            $authItem->loadData($request->getBody());
            if ($authItem->validate() and $authItem->validateAliases()) {
                $authItem->save();
                Calamity::$app->session->setFlash('success', Calamity::t('general', 'Update successful!'));
            }
        }

        return $this->render('routes-management.items.manage', ['authItem' => $authItem]);
    }

    /* * Roles */
    public function listRoles(Request $request, Response $response): string {
        $this->setLayout('main');

        return $this->render('routes-management.roles.list', ['roles' => GenerateTableData::convertData(Roles::findMany())]);
    }

    public function createRole(Request $request, Response $response): string {
        $this->setLayout('main');

        $role = new Roles();
        if ($request->isPost()) {
            $role->loadData($request->getBody());
            if ($role->validate()) {
                $role->id = null;
                $role->save();
                Calamity::$app->session->setFlash('success', Calamity::t('auth', 'Role creation successful'));
            }
        }

        return $this->render('routes-management.roles.create', ['role' => $role]);
    }

    public function deleteRole(Request $request, Response $response): void {
        $flag = true;
        /** @var Roles $role */
        $role = Roles::findOne([Roles::primaryKey() => $request->getRouteParam('id')]);

        /** @var \calamity\common\models\Users $sessionUser */
        $sessionUser = Users::findOne([Users::primaryKey() => Calamity::$app->session->get('sessionUser')]);
        /** @var Roles $userRole */
        foreach ($sessionUser->getRoles() as $userRole) {
            if ($userRole->id == $role->id) {
                $flag = false;
            }
        }

        if ($flag) {
            $role->delete();
        }
        Calamity::$app->response->redirect('/routes-management/roles/list-all');
    }

    public function manageRole(Request $request, Response $response): string {
        $this->setLayout('main');

        /** @var Roles $role */
        $role = Roles::findOne([Roles::primaryKey() => $request->getRouteParam('id')]);
        $users = [];
        /** @var UserRoles $assign */
        foreach (UserRoles::findMany(['roleId' => $role->id]) as $assign) {
            $users[] = Users::findOne([Users::primaryKey() => $assign->userId]);
        }

        if (!$role) {
            throw new NotFoundException();
        }

        $authAssignments = AuthAssignments::findMany(['role' => $role->id]);
        $adminAuthItems = AuthItem::queryMany('item LIKE "@admin/%"', 'item');
        $publicAuthItems = AuthItem::queryMany('item LIKE "@public/%"', 'item');

        if ($request->isPost()) {
            $role->loadData($request->getBody());
            if ($role->validate()) {
                /** @var $assignment AuthAssignments */
                foreach (AuthAssignments::findMany(['role' => $role->id]) as $assignment) {
                    $assignment->delete();
                }
                if (isset($request->getBody()["routes"])) {
                    foreach ($request->getBody()["routes"] as $id) {
                        $assignment = new AuthAssignments();
                        $assignment->role = $role->id;
                        $assignment->item = $id;
                        $assignment->save();
                    }
                }
                $role->save();
                Calamity::$app->session->setFlash('success', Calamity::t('general', 'Update successful!'));
            }
        }

        return $this->render('routes-management.roles.manage',
            [
                'role' => $role,
                'users' => $users,
                'authAssignments' => $authAssignments,
                'adminAuthItems' => $adminAuthItems,
                'publicAuthItems' => $publicAuthItems,
            ],
        );
    }
}