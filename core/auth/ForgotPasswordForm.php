<?php

namespace calamity\core\auth;

use calamity\common\components\text\Generator;
use calamity\common\models\Users;
use calamity\core\Calamity;
use calamity\core\Model;

class ForgotPasswordForm extends Model {
    public ?string $email = null;

    public static function labels(): array {
        return [
            'email' => Calamity::t('attributes', 'Email address'),
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_REQUIRED],
        ];
    }

    public function sendUpdateEmail(): bool {
        /** @var Users $user */
        $user = Users::findOne(['email' => $this->email]);

        if ($user == null) {
            $this->addError('email', Calamity::t('auth', 'This email is not in our system!'));
            return false;
        }

        $resetToken = new ResetToken();
        $resetToken->token = Generator::randomString(ResetToken::class, 'token');
        $resetToken->userId = $user->id;
        $resetToken->completed_at = null;
        $resetToken->save();

        $link = '<a href="' . Calamity::$URL['ADMIN'] . '/auth/reset-password/' . $resetToken->token . '">' . Calamity::$URL['ADMIN'] . '/auth/reset-password/'
            . $resetToken->token . '</a>';

        return Calamity::$app->mailer
            ->setAddress($user->email)
            ->setSubject(Calamity::t('auth', 'Recover account password'))
            ->setTemplate('forgot-password', ['resetLink' => $link, 'firstName' => $user->firstName])
            ->send();
    }
}