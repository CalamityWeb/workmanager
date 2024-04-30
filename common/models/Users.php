<?php

namespace calamity\common\models;

use calamity\common\components\auth\AuthAssignments;
use calamity\common\components\auth\AuthItem;
use calamity\common\components\auth\UserRoles;
use calamity\common\models\core\Calamity;
use calamity\common\models\core\database\MagicRecord;

/**
 * @property integer $id
 * @property string  $email
 * @property string  $firstName
 * @property string  $lastName
 * @property string  $password
 * @property boolean $email_confirmed
 * @property string $auth_provider
 * @property string  $created_at
 * @property string  $updated_at
 */
class Users extends MagicRecord {
    public static function tableName(): string {
        return "users";
    }

    public static function primaryKey(): string|array { return 'id'; }

    public static function attributes(): array {
        return [
            'email',
            'firstName',
            'lastName',
            'password',
            'email_confirmed',
            'auth_provider',
        ];
    }

    public static function labels(): array {
        return [
            'email' => Calamity::t('attributes', 'Email address'),
            'firstName' => Calamity::t('attributes', 'Given name'),
            'lastName' => Calamity::t('attributes', 'Family name'),
            'password' => Calamity::t('attributes', 'Password'),
            'email_confirmed' => Calamity::t('attributes', 'Email confirmed'),
            'auth_provider' => Calamity::t('attributes', 'Auth provider'),
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class], 'attribute'],
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, self::RULE_PASSWORD],
        ];
    }

    public static function canRoute(Users|null $user, string $route): bool {
        $can = false;
        if (is_null($user)) {
            $auths = AuthAssignments::findMany(['role' => 2]);
            /** @var $auth AuthAssignments */
            $can = self::isItemMatches($auths, $route);
        } else {
            $roles = UserRoles::findMany(['userId' => $user->id]);
            /** @var $assignment UserRoles */
            foreach ($roles as $assignment) {
                /** @var $role Roles */
                $role = Roles::findOne([Roles::primaryKey() => $assignment->roleId]);
                $auths = AuthAssignments::findMany(['role' => $role->id]);
                /** @var $auth AuthAssignments */
                $can = self::isItemMatches($auths, $route);
            }
        }
        return $can;
    }

    private static function isItemMatches(false|array $auths, string $route): bool {
        $can = false;
        foreach ($auths as $auth) {
            /** @var $item AuthItem */
            $item = AuthItem::findOne([AuthItem::primaryKey() => $auth->item]);
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', static fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', trim(substr($item->item, 1), '/')) . "$@";
            if (preg_match($routeRegex, trim(substr($route, 1), '/'))) {
                $can = true;
                break;
            }
        }
        return $can;
    }

    public function getFullName(): string {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getPicture(): string {
        return file_exists('./assets/images/profile-pictures/' . $this->{self::primaryKey()} . '.png') ? '/assets/images/profile-pictures/' . $this->{self::primaryKey()} . '.png' : '/assets/images/user-dummy.png';
    }

    public function getActiveRole(): Roles|null {
        if (empty($this->getRoles())) {
            return null;
        }

        /** @var $role Roles */
        $maxCount = 0;
        $maxRole = null;
        foreach ($this->getRoles() as $role) {
            $assignments = AuthAssignments::findMany(['role' => $role->id]);
            if (count($assignments) > $maxCount) {
                $maxCount = count($assignments);
                $maxRole = $role;
            }
        }
        return $maxRole;
    }

    public function getRoles(): array|false {
        $roles = [];
        /** @var $ids UserRoles */
        foreach (UserRoles::findMany(['userId' => $this->id]) as $ids) {
            $roles[] = Roles::findOne([Roles::primaryKey() => $ids->roleId]);
        }
        return $roles;
    }

    public function sendConfirmationEmail(): bool {
        $link = Calamity::$URL['@admin'] . '/auth/verify-account/' . bin2hex($this->email);

        return Calamity::$app->mailer
            ->setAddress($this->email)
            ->setSubject(Calamity::t('auth', 'Confirm your account'))
            ->setTemplate('confirm-account', ['confirm_link' => $link, 'firstName' => $this->firstName])
            ->send();
    }
}