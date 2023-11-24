<?php

namespace tframe\admin\controllers;

use tframe\core\auth\AuthItem;
use tframe\core\Controller;

class RoutesManagement extends Controller {

    public function index(): string {
        $this->setLayout('main');

        return $this->render('routes-management.index');
    }

    /* * Items */
    public function listItems(): string {
        $this->setLayout('main');

        return $this->render('routes-management.items.list');
    }

    public function createItem(): string {
        $this->setLayout('main');

        $routeItem = new AuthItem();

        return $this->render('routes-management.items.create', ['routeItem' => $routeItem]);
    }

    public function manageItem(): string {
        $this->setLayout('main');

        return $this->render('routes-management.items.manage');
    }

    /* * Groups */
    public function listGroups(): string {
        $this->setLayout('main');

        return $this->render('routes-management.groups.list');
    }

    public function createGroup(): string {
        $this->setLayout('main');

        return $this->render('routes-management.groups.create');
    }

    public function manageGroup(): string {
        $this->setLayout('main');

        return $this->render('routes-management.groups.manage');
    }

    /* * Assignments */
    public function listAssignments(): string {
        $this->setLayout('main');

        return $this->render('routes-management.assignments.list');
    }

    public function createAssignment(): string {
        $this->setLayout('main');

        return $this->render('routes-management.assignments.create');
    }

    public function manageAssignment(): string {
        $this->setLayout('main');

        return $this->render('routes-management.assignments.manage');
    }
}