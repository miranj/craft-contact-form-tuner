# Contact Form Extras plugin for Craft CMS 3.x

Adds a bunch of additional controls (cc, bcc, reply-to, templates, plain text control) to the Craft CMS [Contact Form plugin][cf].


## Requirements

This plugin requires Craft CMS 3 and the [Contact Form plugin][cf] (v2.0.0 or later).

[cf]:https://github.com/craftcms/contact-form

## Installation

You can install this plugin from the [Plugin Store][ps] or with Composer.

[ps]:https://plugins.craftcms.com/

#### From the Plugin Store
Go to the Plugin Store in your project’s Control Panel and search for “Contact Form Extras”.
Then click on the “Install” button in its modal window.

#### Using Composer
Open your terminal and run the following commands:

    # go to the project directory
    cd /path/to/project
    
    # tell composer to use the plugin
    composer require miranj/craft-contact-form-extras
    
    # tell Craft to install the plugin
    ./craft install/plugin contact-form-extras

## Configuration

All settings for this plugin can be configured from the Control Panel under Settings → Contact Form Extras. You can also configure the plugin programmatically by creating a `contact-form-extras.php` file in your [config folder][config]. This file supports Craft's standard [multi-environment configurations][multi], and any values defined here will override those set via the Control Panel.

[config]:https://docs.craftcms.com/v3/config/
[multi]:https://docs.craftcms.com/v3/config/environments.html#multi-environment-configs

Here is a sample config file along with a list of all possible settings with their default values:

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
    'textTemplate'  => '',
    'htmlTemplate'  => '',
];
```

---

Brought to you by [Miranj](https://miranj.in/)
