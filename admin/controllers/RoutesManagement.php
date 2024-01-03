<?php

namespace tframe\admin\controllers;

use tframe\common\components\text\Generator;
use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\auth\AuthAssignment;
use tframe\core\auth\Roles;
use tframe\core\auth\AuthItem;
use tframe\core\Controller;
use tframe\core\exception\NotFoundException;
use tframe\core\Request;
use tframe\core\Response;

class RoutesManagement extends Controller {
    /* * Items */
    public function listItems(): string {
        $this->setLayout('main');

        return $this->render('routes-management.items.list');
    }

    public function createItem(Request $request, Response $response): string {
        $this->setLayout('main');

        $routeItem = new AuthItem();
        if($request->isPost()) {
            $routeItem->loadData($request->getBody());
            if($routeItem->validate() and $routeItem->validateAliases()) {
                $routeItem->id = null;
                $routeItem->save();
                Application::$app->session->setFlash('success', Application::t('auth', 'Route creation successful'));
            }
        }

        return $this->render('routes-management.items.create', ['routeItem' => $routeItem]);
    }

    public function manageItem(Request $request, Response $response): string {
        $this->setLayout('main');

        /** @var AuthItem $authItem */
        $authItem = AuthItem::findOne(['id' => $request->getRouteParam('id')]);

        if(!$authItem) {
            throw new NotFoundException();
        }

        if($request->isPost()) {
            $authItem->loadData($request->getBody());
            if($authItem->validate() and $authItem->validateAliases()) {
                $authItem->save();
                Application::$app->session->setFlash('success', Application::t('general', 'Update successful!'));
            }
        }

        return $this->render('routes-management.items.manage', ['authItem' => $authItem]);
    }

    /* * Roles */
    public function listRoles(Request $request, Response $response): string {
        $this->setLayout('main');

        return $this->render('routes-management.roles.list');
    }

    public function createRole(Request $request, Response $response): string {
        $this->setLayout('main');

        $role = new Roles();
        if($request->isPost()) {
            $role->loadData($request->getBody());
            if($role->validate()) {
                $role->save();
                Application::$app->session->setFlash('success', Application::t('auth', 'Role creation successful'));
            }
        }

        return $this->render('routes-management.roles.create', ['role' => $role]);
    }

    public function manageRole(Request $request, Response $response): string {
        $this->setLayout('main');

        /** @var Roles $role */
        $role = Roles::findOne([Roles::primaryKey() => $request->getRouteParam('id')]);

        if(!$role) {
            throw new NotFoundException();
        }

        $authAssignments = AuthAssignment::findMany(['role' => $role->id]);
        $adminAuthItems = AuthItem::queryMany('item LIKE "@admin/%"', 'item');
        $publicAuthItems = AuthItem::queryMany('item LIKE "@public/%"', 'item');
        $apiAuthItems = AuthItem::queryMany('item LIKE "@api/%"', 'item');

        if($request->isPost()) {
            $role->loadData($request->getBody());
            if($role->validate()) {
                /** @var $assignment AuthAssignment */
                foreach (AuthAssignment::findMany(['role' => $role->id]) as $assignment) {
                    $assignment->delete();
                }
                if(isset($request->getBody()["routes"])) {
                    foreach ($request->getBody()["routes"] as $id) {
                        $assignment = new AuthAssignment();
                        $assignment->role = $role->id;
                        $assignment->item = $id;
                        $assignment->save();
                    }
                }
                $role->save();
                Application::$app->session->setFlash('success', Application::t('general', 'Update successful!'));
            }
        }

        return $this->render('routes-management.roles.manage',
            [
                'role' => $role,
                'authAssignments' => $authAssignments,
                'adminAuthItems' => $adminAuthItems,
                'publicAuthItems' => $publicAuthItems,
                'apiAuthItems' => $apiAuthItems
            ]
        );
    }
}