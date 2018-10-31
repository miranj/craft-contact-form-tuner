<?php
/**
 * @link      https://miranj.in/
 * @copyright Copyright (c) Miranj Design LLP
 */

namespace miranj\contactformnuances\models;

use craft\base\Model;

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
    
    
    // Public Methods
    // =========================================================================
    
    public function getCcConfig()
    {
        $emails = $this->prepEmailConfig($this->ccEmail);
        
        if ($this->ccName && $emails !== null) {
            $names = $this->ccName;
            $names = $this->prepCommaSeparatedValue($names);
            
            // Create a matching email => name array, accounting for empty & extra spots
            $names = array_merge($names, array_fill(0, count($emails) - count($names), ''));
            $names = array_slice($names, 0, count($emails));
            $emails = array_combine($emails, $names);
        }
        
        return $emails;
    }
    
    public function getBccConfig()
    {
        $emails = $this->prepEmailConfig($this->bccEmail);
        return $emails;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hideReplyTo'], 'boolean'],
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
        
        if (!is_array($value)) {
            $value = explode(',', $value);
        }
        $value = array_map('trim', $value);
        
        return $value;
    }
    
    /*
     * @returns string[] | null
     */
    protected function prepEmailConfig($emails)
    {
        $emails = $this->prepCommaSeparatedValue($emails);
        
        if (empty($emails)) {
            return null;
        }
        
        return $emails;
    }
}
