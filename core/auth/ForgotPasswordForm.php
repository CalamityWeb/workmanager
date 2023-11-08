<?php

namespace tframe\core\auth;

use tframe\common\components\text\Generator;
use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\Model;

class ForgotPasswordForm extends Model {
    public ?string $email = null;

    public function labels(): array {
        return [
            'email' => Application::t('attributes', 'Email address'),
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_REQUIRED],
        ];
    }

    public function sendUpdateEmail(): bool {
        /** @var User $user */
        $user = User::findOne(['email' => $this->email]);

        if ($user == null) {
            $this->addError('email', Application::t('auth', 'This email is not in our system!'));
            return false;
        }

        $resetToken = new ResetToken();
        $resetToken->token = Generator::randomString(ResetToken::class, 'token');
        $resetToken->userId = $user->id;
        $resetToken->completed_at = null;
        $resetToken->save();

        $link = '<a href="' . Application::$URL['ADMIN'] . '/auth/reset-password/' . $resetToken->token . '">' . Application::$URL['ADMIN'] . '/auth/reset-password/'
            . $resetToken->token . '</a>';

        return Application::$app->mailer
            ->setAddress($user->email)
            ->setSubject(Application::t('auth', 'Recover account password'))
            ->setTemplate('forgot-password', ['resetLink' => $link, 'firstName' => $user->firstName])
            ->send();
    }
}