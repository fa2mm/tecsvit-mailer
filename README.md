Mailer
======
 Mailer for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
php composer.phar require --prefer-dist tecsvit/yii2-mailer "*"
```

or (dev)
```bash
composer require --prefer-dist tecsvit/yii2-mailer "@dev"
```

or add
```bash
"tecsvit/yii2-mailer": "*"
```
to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
...
'components' => [
        ...
        'mailer' => [
            'class' => '\tecsvit\mailer\components\Mailer',
            'useFileTransport'      => false,
            'defaultTemplates'      => [
                'YOUR_NAME_TEMPLATE'   => [
                    'subject'       => 'Your_mail_subject',
                    'template'      => 'Your_template_filename',
                    'senderMail'    => 'Sender_Email',
                    'senderName'    => 'Sender_Name',
                ],
            ],
            'transport' => [
                'class'         => 'Swift_SmtpTransport',
                'host'          => 'your_host',
                'username'      => 'your_username',
                'password'      => 'your_pass',
                'port'          => 'your_port',
                'encryption'    => 'your_encryption',
            ],
        ],
        ...

```

Example:

```php
...
'components' => [
        ...
        'mailer' => [
            'class' => '\tecsvit\mailer\components\Mailer',
            'useFileTransport'      => false,
            'defaultTemplates'      => [
                'confirmPassword'   => [
                    'subject'       => 'Hi',
                    'template'      => 'confirmPassword.php',
                    'senderMail'    => 'admin@admin.com',
                    'senderName'    => 'Admin',
                ],
                'subscribe'   => [
                    'subject'       => 'Hi2',
                    'template'      => 'subscribe.php',
                    'senderMail'    => 'subscribe@admin.com',
                    'senderName'    => 'Manager',
                ],
            ],
            'transport' => [
                'class'         => 'Swift_SmtpTransport',
                'host'          => 'smtp.gmail.com',
                'username'      => 'user@gmail.com',
                'password'      => '4565456464',
                'port'          => '587',
                'encryption'    => 'tls',
            ],
        ],
        ...

```

Create template(s) in directory ../app/mail/ (example):

confirmPassword.php
```php
<strong>Confirm Your Mail</strong>
<div>
	For confirm your mail click on link: <a href="http://site.com/user/confirm-email?hash=<?= $hash ?>">click</a>
</div>
```
In your code
```php
    $toMail = 'mail-your-friend@gmail.com';
    $data = ['hash' => $hash];
    /** @var \tecsvit\mailer\components\Mailer $mailer */
    $mailer = Yii::$app->mailer;
    $mailer->sendMail($toMail, $data, 'confirmPassword');
```