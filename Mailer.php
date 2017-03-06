<?php

namespace app\components;

use \yii\console\Exception as ExceptionConsole;
use \yii\swiftmailer\Mailer as BaseMailer;

/**
 * Class Mailer
 * @package app\components
 * @author: Alexander Mohon`ko
 * @version: 1.0.0
 * Date: 14.02.17
 *
 * @property string $mailer
 * @property string $fromMail
 * @property string $toMail
 * @property string $fromName
 * @property string $subject
 * @property string $body
 * @property string $type
 * @property array $data
 * @property string $typeLetter
 * @property string $defaultTemplates
 *
 * @property string $_template
 */
class Mailer extends BaseMailer
{
    public $mailer;
    public $fromMail;
    public $toMail;
    public $fromName;
    public $subject;
    public $body;
    public $data;
    public $typeLetter;
    public $type                        = 'text/html';
    public $defaultTemplates            = [];

    private $_template;

    /**
     * @throws ExceptionConsole
     */
    public function init()
    {
        $this->useFileTransport = YII_ENV !== YII_ENV_PROD;
        parent::init();

        if(empty($this->defaultTemplates)) {
            throw new ExceptionConsole('Config is invalid.');
        }
    }

    /**
     * @param $toMail
     * @param $data
     * @param $typeLetter
     * @return bool
     */
    public function sendMail($toMail, $data, $typeLetter)
    {
        $this->toMail = $toMail;
        $this->data = $data;
        $this->typeLetter = $typeLetter;

        $this->_setSender();

        $this->_setTemplate();
        $this->_setSubject();

        $mail = $this->compose($this->_template, $data)
            ->setTo($this->toMail)
            ->setFrom([$this->fromMail => $this->fromName])
            ->setSubject($this->subject);

        return $mail->send();
    }

    /**
     *  @return null|string
     */
    private function _getSubject()
    {
        return $this->_getDefault('subject');
    }

    /**
     * @return null|string
     */
    private function _getTemplates()
    {
        return $this->_getDefault('template');
    }

    /**
     * @return null|string
     */
    private function _getFromMail()
    {
        return $this->_getDefault('senderMail');
    }

    /**
     * @return null|string
     */
    private function _getFromName()
    {
        return $this->_getDefault('senderName');
    }

    /**
     * @return void
     */
    private function _setTemplate()
    {
        $this->_template = isset($this->data['template']) ? $this->data['template'] : $this->_getTemplates();
    }

    /**
     * @return void
     */
    private function _setSender()
    {
        $this->fromMail = isset($this->data['fromMail']) ? $this->data['fromMail'] : $this->_getFromMail();
        $this->fromName = isset($this->data['fromName']) ? $this->data['fromName'] : $this->_getFromName();
    }

    /**
     * @return void
     */
    private function _setSubject()
    {
        $this->subject = isset($this->data['subject']) ? $this->data['subject'] : $this->_getSubject();
    }

    /**
     * @param $param
     * @return null
     */
    private function _getDefault($param)
    {
        return isset($this->defaultTemplates[$this->typeLetter][$param])
            ? $this->defaultTemplates[$this->typeLetter][$param]
            : null;
    }
}