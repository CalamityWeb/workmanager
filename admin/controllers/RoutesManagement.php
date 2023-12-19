<?php

namespace tframe\admin\controllers;

use tframe\core\Application;
use tframe\core\auth\AuthAssignments;
use tframe\core\auth\AuthGroup;
use tframe\core\auth\AuthItem;
use tframe\core\Controller;
use tframe\core\exception\NotFoundException;
use tframe\core\Request;
use tframe\core\Response;

class RoutesManagement extends Controller {

    public function index(Request $request, Response $response): string {
        $this->setLayout('main');

        return $this->render('routes-management.index');
    }

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

    /* * Groups */
    public function listGroups(Request $request, Response $response): string {
        $this->setLayout('main');

        return $this->render('routes-management.groups.list');
    }

    public function createGroup(Request $request, Response $response): string {
        $this->setLayout('main');

        $groupItem = new AuthGroup();
        if($request->isPost()) {
            $groupItem->loadData($request->getBody());
            $groupItem->code = strtoupper($groupItem->code);
            if($groupItem->validate()) {
                $groupItem->save();
                Application::$app->session->setFlash('success', Application::t('auth', 'Group creation successful'));
            }
        }

        return $this->render('routes-management.groups.create', ['groupItem' => $groupItem]);
    }

    public function manageGroup(Request $request, Response $response): string {
        $this->setLayout('main');

        /** @var AuthGroup $groupItem */
        $groupItem = AuthGroup::findOne([AuthGroup::primaryKey() => $request->getRouteParam('id')]);

        if(!$groupItem) {
            throw new NotFoundException();
        }

        $authAssignments = AuthAssignments::findMany(['code' => $groupItem->id]);
        $adminAuthItems = AuthItem::queryMany('item LIKE "@admin/%"', 'item');
        $publicAuthItems = AuthItem::queryMany('item LIKE "@public/%"', 'item');

        if($request->isPost()) {
            $groupItem->loadData($request->getBody());
            if($groupItem->validate()) {
                if(isset($request->getBody()["routes"])) {
                    /** @var $assignment AuthAssignments */
                    foreach (AuthAssignments::findMany(['code' => $groupItem->id]) as $assignment) {
                        $assignment->delete();
                    }
                    foreach ($request->getBody()["routes"] as $id) {
                        $assignment = new AuthAssignments();
                        $assignment->code = $groupItem->id;
                        $assignment->item = $id;
                        $assignment->save();
                    }
                }
                $groupItem->save();
                Application::$app->session->setFlash('success', Application::t('general', 'Update successful!'));
            }
        }

        return $this->render('routes-management.groups.manage',
            [
                'groupItem' => $groupItem,
                'authAssignments' => $authAssignments,
                'adminAuthItems' => $adminAuthItems,
                'publicAuthItems' => $publicAuthItems
            ]
        );
    }
}