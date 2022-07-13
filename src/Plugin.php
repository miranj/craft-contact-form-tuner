<?php
/**
 * Contact Form Tuner plugin for Craft CMS 3.x
 *
 * @link      https://miranj.in/
 * @copyright Copyright (c) Miranj Design LLP
 */

namespace miranj\contactformtuner;

use miranj\contactformtuner\models\Settings;

use Craft;
use craft\helpers\Html;
use craft\web\View;
use craft\contactform\events\SendEvent;
use craft\contactform\Mailer;
use yii\base\Event;

/**
 * Class Plugin
 *
 */
class Plugin extends \craft\base\Plugin
{
    
    public bool $hasCpSettings = true;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        Event::on(Mailer::class, Mailer::EVENT_BEFORE_SEND, function(SendEvent $e) {
            $settings = $this->getSettings();
            $message = $e->message;
            
            //
            // Override cc, bcc, reply-to headers
            //
            $message->setCc($settings->ccConfig);
            $message->setBcc($settings->bccConfig);
            
            if ($settings->hideReplyTo) {
                $message->setReplyTo(null);
            } elseif ($settings->replyToConfig) {
                // Override Reply-To only if it has a value
                $message->setReplyTo($settings->replyToConfig);
            }
            
            
            
            // 
            // Override message body templates
            // 
            if ($settings->textTemplate) {
                $oldTemplateMode = Craft::$app->view->getTemplateMode();
                Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_SITE);
                $textBody = Craft::$app->view->renderTemplate(
                    $settings->textTemplate,
                    $e->submission->toArray()
                );
                Craft::$app->view->setTemplateMode($oldTemplateMode);
                
                $textBody = Html::decode($textBody);
                $message->setTextBody($textBody);
            }
            
            if ($settings->htmlTemplate && !$settings->textOnly) {
                $oldTemplateMode = Craft::$app->view->getTemplateMode();
                Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_SITE);
                $htmlBody = Craft::$app->view->renderTemplate(
                    $settings->htmlTemplate,
                    $e->submission->toArray()
                );
                Craft::$app->view->setTemplateMode($oldTemplateMode);
                
                $message->setHtmlBody($htmlBody);
            }
            
            
            
            // 
            // Force plain text
            // 
            if ($settings->textOnly) {
                // We cannot simply set the HTML to null
                // because that does not remove the html part completely.
                // So instead, we re-create the entire underlying message
                // and re-add all parts except the text/html part
                $swiftMessage = $message->getSwiftMessage();
                $oldParts = $swiftMessage->getChildren();
                $oldParts = array_filter($oldParts, function ($part) {
                    return $part->getContentType() != 'text/html';
                });
                
                // reset message
                $swiftMessage->setBody(null);
                $swiftMessage->setContentType(null);
                $swiftMessage->setChildren([]);
                
                // If it remains a multi-part message, then simply re-add parts
                if (count($oldParts) > 1) {
                    $swiftMessage->setChildren($oldParts);
                } elseif (count($oldParts) == 1) {
                    // otherwise, add the single part directly, not as an attachment
                    $part = array_pop($oldParts);
                    $swiftMessage->setBody(
                        $part->getBody(),
                        $part->getContentType()
                    );
                }
            }
        });
        
        Craft::info(
            Craft::t(
                'contact-form-tuner',
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
        
        return Craft::$app->view->renderTemplate('contact-form-tuner/_settings', [
            'settings' => $this->getSettings(),
            'overrides' => array_keys($overrides),
        ]);
    }
}
