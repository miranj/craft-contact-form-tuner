<?php
/**
 * Contact Form Nuances plugin for Craft CMS 3.x
 *
 * Adds a bunch of additional controls (cc, bcc, reply-to, plaintext) to the Craft CMS Contact Form plugin.
 *
 * @link      https://miranj.in/
 * @copyright Copyright (c) Miranj Design LLP
 */

namespace miranj\contactformnuances;

use miranj\contactformnuances\models\Settings;

use Craft;
use craft\contactform\events\SendEvent;
use craft\contactform\Mailer;
use yii\base\Event;

/**
 * Class Plugin
 *
 */
class Plugin extends craft\base\Plugin
{
    
    public $hasCpSettings = true;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        Event::on(Mailer::class, Mailer::EVENT_BEFORE_SEND, function(SendEvent $e) {
            $settings = $this->getSettings();
            $message = $e->message;
            
            $message->setCc($settings->ccConfig);
            $message->setBcc($settings->bccConfig);
            
            if ($settings->hideReplyTo) {
                $message->setReplyTo(null);
            
            // Override Reply-To only if it has a value
            } elseif ($settings->replyToConfig) {
                $message->setReplyTo($settings->replyToConfig);
            }
        });
        
        Craft::info(
            Craft::t(
                'contact-form-nuances',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
    
    // Protected Methods
    // =========================================================================
    
    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }
    
    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        // Get and pre-validate the settings
        $settings = $this->getSettings();
        $settings->validate();
        
        // Get the settings that are being defined by the config file
        $overrides = Craft::$app->getConfig()->getConfigFromFile(strtolower($this->handle));
        
        return Craft::$app->view->renderTemplate('contact-form-nuances/_settings', [
            'settings' => $this->getSettings(),
            'overrides' => array_keys($overrides),
        ]);
    }
}
