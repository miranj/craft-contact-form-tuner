# Contact Form Tuner plugin for Craft CMS 3.x

This plugin extends functionality offered by the official [Contact Form][cf] plugin by allowing you to:
- Control Cc recipients
- Control Bcc recipients
- Control Reply-To recipients
- Force plain text only emails
- Use a custom template for the plain text email body
- Use a custom template for the HTML email body

[cf]:https://github.com/craftcms/contact-form

## Requirements

This plugin requires Craft CMS 3 and the [Contact Form plugin][cf] (v2.0.0 or later).

## Installation

You can install this plugin from the [Plugin Store][ps] or with Composer.

[ps]:https://plugins.craftcms.com/

#### From the Plugin Store
Go to the Plugin Store in your project’s Control Panel and search for “Contact Form Tuner”.
Then click on the “Install” button in its modal window.

#### Using Composer
Open your terminal and run the following commands:

    # go to the project directory
    cd /path/to/project
    
    # tell composer to use the plugin
    composer require miranj/craft-contact-form-tuner
    
    # tell Craft to install the plugin
    ./craft install/plugin contact-form-tuner

## Configuration

All settings for this plugin can be configured from the Control Panel under Settings → Contact Form Tuner. You can also configure the plugin programmatically by creating a `contact-form-tuner.php` file in your [config folder][config]. This file supports Craft's standard [multi-environment configurations][multi], and any values defined here will override those set via the Control Panel.

[config]:https://docs.craftcms.com/v3/config/
[multi]:https://docs.craftcms.com/v3/config/environments.html#multi-environment-configs

Here is a sample config file along with a list of all possible settings and their default values:

```php
<?php

return [
    'ccEmail'       => '',      // e.g. 'ccme@example.com' or ['one@example.com', 'two@example.com']
    'ccName'        => '',
    'bccEmail'      => '',
    
    'hideReplyTo'   => false,
    'replyToEmail'  => '',      // leaving this empty preserves the reply-to set by Contact Form
    'replyToName'   => '',
    
    'textOnly'      => false,   // enabling this forces the email to be sent in plain text only
    
    'textTemplate'  => '',      // templates have access to submitted values
    'htmlTemplate'  => '',      // such as `fromName`, `fromEmail`, `subject` and `message`
];
```

---

Brought to you by [Miranj](https://miranj.in/)
