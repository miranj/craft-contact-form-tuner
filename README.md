# Contact Form Nuances plugin for Craft CMS 3.x

Adds a bunch of additional controls (cc, bcc, reply-to) to the Craft CMS [Contact Form plugin][cf].


## Requirements

This plugin requires Craft CMS 3 and the [Contact Form plugin][cf] (v2.0.0 or later).

[cf]:https://github.com/craftcms/contact-form

## Installation

You can install this plugin from the [Plugin Store][ps] or with Composer.

[ps]:https://plugins.craftcms.com/

#### From the Plugin Store
Go to the Plugin Store in your project’s Control Panel and search for “Contact Form Nuances”.
Then click on the “Install” button in its modal window.

#### Using Composer
Open your terminal and run the following commands:

    # go to the project directory
    cd /path/to/project
    
    # tell composer to use the plugin
    composer require miranj/craft-contact-form-nuances
    
    # tell Craft to install the plugin
    ./craft install/plugin contact-form-nuances

## Configuration

All settings for this plugin can be configured from the Control Panel under Settings → Contact Form Nuances. You can also configure the plugin programmatically by creating a `contact-form-nuances.php` file in your [config folder][config]. This file supports Craft's standard [multi-environment configurations][multi], and any values defined here will override those set via the Control Panel.

[config]:https://docs.craftcms.com/v3/config/
[multi]:https://docs.craftcms.com/v3/config/environments.html#multi-environment-configs

Here is a sample config file along with a list of all possible settings:

```php
<?php

return [
    'ccEmail'       => 'copyme@example.com',
    'ccName'        => 'In the loop',
    'bccEmail'      => 'batman@example.com',
    'hideReplyTo'   => false,
    'replyToEmail'  => 'sales@example.com',
    'replyToName'   => 'Sales',
];
```

## Roadmap
- Plaintext only


---

Brought to you by [Miranj](https://miranj.in/)
