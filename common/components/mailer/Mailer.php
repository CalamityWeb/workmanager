<?php

namespace tframe\common\components\mailer;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use tframe\core\Application;
use tframe\core\exception\BadParameterException;

class Mailer {
    public PHPMailer $mail;

    public function __construct(array $config = []) {
        $this->mail = new PHPMailer();

        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Host = $config['host'] ?? '';
        $this->mail->Username = $config['username'] ?? '';
        $this->mail->Password = $config['password'] ?? '';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
        $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
    }

    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function setFrom(string $address, $name = ''): static {
        try {
            $this->mail->setFrom($address, $name);
        } catch (Exception $e) {
            throw new BadParameterException();
        }
        return $this;
    }


    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function setReplyTo(string|array $addresses, $name = ''): static {
        if(is_array($addresses)) {
            foreach ($addresses as $address) {
                try {
                    if(is_array($address)) {
                        $this->mail->addReplyTo($address[0], $address[1]);
                    } else {
                        $this->mail->addReplyTo($address);
                    }
                } catch (Exception $e) {
                    throw new BadParameterException();
                }
            }
        } else {
            try {
                $this->mail->addReplyTo($addresses);
            } catch (Exception $e) {
                throw new BadParameterException();
            }
        }
        return $this;
    }


    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function setAddress(string|array $recipients): static {
        if(is_array($recipients)) {
            foreach ($recipients as $recipient) {
                try {
                    if(is_array($recipient)) {
                        $this->mail->addAddress($recipient[0], $recipient[1]);
                    } else {
                        $this->mail->addAddress($recipient);
                    }
                } catch (Exception $e) {
                    throw new BadParameterException();
                }
            }
        } else {
            try {
                $this->mail->addAddress($recipients);
            } catch (Exception $e) {
                throw new BadParameterException();
            }
        }
        return $this;
    }


    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function setCC(string|array $recipients): static {
        if(is_array($recipients)) {
            foreach ($recipients as $recipient) {
                try {
                    if(is_array($recipient)) {
                        $this->mail->addCC($recipient[0], $recipient[1]);
                    } else {
                        $this->mail->addCC($recipient);
                    }
                } catch (Exception $e) {
                    throw new BadParameterException();
                }
            }
        } else {
            try {
                $this->mail->addCC($recipients);
            } catch (Exception $e) {
                throw new BadParameterException();
            }
        }
        return $this;
    }


    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function setBCC(string|array $recipients): static {
        if(is_array($recipients)) {
            foreach ($recipients as $recipient) {
                try {
                    if(is_array($recipient)) {
                        $this->mail->addBCC($recipient[0], $recipient[1]);
                    } else {
                        $this->mail->addBCC($recipient);
                    }
                } catch (Exception $e) {
                    throw new BadParameterException();
                }
            }
        } else {
            try {
                $this->mail->addBCC($recipients);
            } catch (Exception $e) {
                throw new BadParameterException();
            }
        }
        return $this;
    }

    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function addAttachment(string|array $attachments): static {
        if(is_array($attachments)) {
            foreach ($attachments as $attachment) {
                try {
                    $this->mail->addAttachment($attachment);
                } catch (Exception $e) {
                    throw new BadParameterException();
                }
            }
        } else {
            try {
                $this->mail->addAttachment($attachments);
            } catch (Exception $e) {
                throw new BadParameterException();
            }
        }
        return $this;
    }

    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function setTemplate(string $subject, string $templateName, array $args = []): static {
        try {
            $this->mail->Subject = $subject;
            $this->mail->isHTML(true);
            $content = file_get_contents(Application::$ROOT_DIR . '/common/components/mailer/template/' . $templateName . '.html');
            foreach ($args as $key => $value) {
                $content = str_replace('['.$key.']', $value, $content);
            }
            $this->mail->Body = $content;
        } catch (Exception $e) {
            throw new BadParameterException();
        }
        return $this;
    }

    /**
     * @throws \tframe\core\exception\BadParameterException
     */
    public function send(): true {
        try {
            if($this->mail->send()) {
                return true;
            } else {
                throw new BadParameterException();
            }
        } catch (Exception $e) {
            throw new BadParameterException();
        }
    }
}