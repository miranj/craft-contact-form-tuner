<?php
/**
 * @link      https://miranj.in/
 * @copyright Copyright (c) Miranj Design LLP
 */

namespace miranj\contactformtuner\models;

use craft\base\Model;
use craft\helpers\StringHelper;

class Settings extends Model
{
    // Public Properties
    // =========================================================================
    
    /**
     * @var string|string[]|null
     */
    public $ccEmail = null;
    public $ccName = null;
    
    /**
     * @var string|string[]|null
     */
    public $bccEmail = null;
    
    /**
     * @var bool
     */
    public $hideReplyTo = false;
    
    /**
     * @var string|string[]|null
     */
    public $replyToEmail = null;
    public $replyToName = null;
    
    /**
     * @var bool
     */
    public $textOnly = false;
    
    /**
     * @var string|null
     */
    public $textTemplate = null;
    public $htmlTemplate = null;
    
    // Public Methods
    // =========================================================================
    
    public function getCcConfig()
    {
        $emails = $this->prepEmailConfig($this->ccEmail, $this->ccName);
        return $emails;
    }
    
    public function getBccConfig()
    {
        $emails = $this->prepEmailConfig($this->bccEmail);
        return $emails;
    }
    
    public function getReplyToConfig()
    {
        $emails = $this->prepEmailConfig($this->replyToEmail, $this->replyToName);
        return $emails;
    }
    
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['hideReplyTo'], 'boolean'],
            [['textTemplate', 'htmlTemplate'], 'string'],
        ];
    }
    
    
    
    // Protected Methods
    // =========================================================================
    
    /*
     * @returns string[]
     */
    protected function prepCommaSeparatedValue($value)
    {
        if (!$value) {
            return [];
        }
        
        if (is_string($value)) {
            $value = StringHelper::split($value);
        } else {
            $value = array_map('trim', $value);
        }
        
        return $value;
    }
    
    /*
     * @returns string[] | null
     */
    protected function prepEmailConfig($emails, $names = null)
    {
        $emails = $this->prepCommaSeparatedValue($emails);
        $names = $this->prepCommaSeparatedValue($names);
        
        if (empty($emails)) {
            return null;
        }
        
        // Create a matching [ email => name ] array, accounting for empty/extra spots
        if (!empty($names)) {
            $names = array_merge($names, array_fill(0, max(count($emails) - count($names), 0), ''));
            $names = array_slice($names, 0, count($emails));
            $emails = array_combine($emails, $names);
        }
        
        return $emails;
    }
}
