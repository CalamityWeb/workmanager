<?php

namespace calamity\common\components\auth;

use calamity\common\components\text\Generator;
use calamity\common\models\core\Calamity;
use calamity\common\models\core\Model;
use calamity\common\models\Users;

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

        $link = Calamity::$URL['@admin'] . '/auth/reset-password/' . $resetToken->token;

        return Calamity::$app->mailer
            ->setAddress($user->email)
            ->setSubject(Calamity::t('auth', 'Recover account password'))
            ->setTemplate('forgot-password', ['reset_link' => $link, 'firstName' => $user->firstName])
            ->send();
    }
}