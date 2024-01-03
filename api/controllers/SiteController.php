<?php

namespace tframe\api\controllers;

use tframe\common\models\User;
use tframe\core\auth\AuthAssignment;
use tframe\core\auth\AuthItem;
use tframe\core\auth\Roles;
use tframe\core\Controller;
use tframe\core\Request;

class SiteController extends Controller {
    public function index(): false|string {
        return $this->renderViewOnly('@public.index');
    }
    public function usersListUsers(): false|string {
        $users = User::findMany();
        return json_encode($users);
    }

    public function routesManagementItemsListItems(): false|string {
        $authItems = AuthItem::findMany();
        return json_encode($authItems);
    }

    public function routesManagementListRoles(): false|string {
        $roles = Roles::findMany();
        return json_encode($roles);
    }
}