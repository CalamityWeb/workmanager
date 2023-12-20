<?php

namespace tframe\admin\controllers;

use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\auth\AuthAssignment;
use tframe\core\auth\Role;
use tframe\core\auth\AuthItem;
use tframe\core\Controller;
use tframe\core\exception\UnauthorizedException;
use tframe\core\Request;

class ApiController extends Controller {

    public function __construct() {
        Application::$app->on(Application::EVENT_BEFORE_REQUEST, self::checkLogged());
    }

    public static function checkLogged(): void {
        if(Application::isGuest()) {
            throw new UnauthorizedException();
        }
    }

    public function usersListUsers(): false|string {
        $this->checkLogged();
        $users = User::findMany();
        return json_encode($users);
    }

    public function routesManagementItemsListItems(): false|string {
        $this->checkLogged();
        $authItems = AuthItem::findMany();
        return json_encode($authItems);
    }

    public function routesManagementGetItemById(Request $request): false|string {
        $this->checkLogged();
        $authItems = AuthItem::findOne([AuthItem::primaryKey() => $request->getRouteParam('id')]);
        return json_encode($authItems);
    }

    public function routesManagementRolesListGroups(): false|string {
        $this->checkLogged();
        $roles = Role::findMany();
        return json_encode($roles);
    }

    public function routesManagementAssignmentsListAssignments(): false|string {
        $this->checkLogged();
        $authAssignments = AuthAssignment::findMany();
        return json_encode($authAssignments);
    }
}