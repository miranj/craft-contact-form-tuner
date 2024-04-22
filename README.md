<img align="right" src="./src/icon.svg" width="100" height="100" alt="Contact Form Tuner icon">


# Contact Form Tuner

This [Craft CMS][] plugin extends functionality offered by the official [Contact Form][cf] plugin by allowing you to:
- Control Cc recipients
- Control Bcc recipients
- Control Reply-To recipients
- Force plain text only emails
- Use a custom template for the plain text email body
- Use a custom template for the HTML email body

[craft cms]:https://craftcms.com
[cf]:https://github.com/craftcms/contact-form

## Contents

- [Configuration](#configuration)
- [Installation](#installation)
- [Requirements](#requirements)
- [Changelog](./CHANGELOG.md)
- [License](./LICENSE.md)



## Configuration

All settings for this plugin can be configured from the Control Panel under _Settings → Contact Form Tuner_. You can also configure the plugin programmatically by creating a `contact-form-tuner.php` file in your [`config/`][config] folder. This file supports Craft's standard [multi-environment configurations][multi], and any values defined here will override those set via the Control Panel.

[config]:https://craftcms.com/docs/5.x/system/directory-structure.html#config
[multi]:https://craftcms.com/docs/5.x/configure.html#multi-environment-configs

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



## Installation

You can install this plugin from the [Plugin Store][ps] or with Composer.

[ps]:https://plugins.craftcms.com/contact-form-tuner

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
    ./craft plugin/install contact-form-tuner



## Requirements

This plugin requires Craft CMS 3, 4, or 5 and the [Contact Form plugin][cf] (v2.0, v3.0 or later).



---

Brought to you by [Miranj](https://miranj.in/)
