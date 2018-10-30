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
    
    /**
     * @var string
     */
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
        if (!$emails) {
            return null;
        }
        
        if ($this->ccName) {
            $names = explode(',', $this->ccName);
            $names = array_map('trim', $names);
            
            // Create a matching email => name array, accounting for empty spots
            if (count($names) < count($emails)) {
                $names = array_merge(
                    $names,
                    array_fill(0, count($emails) - count($names), '')
                );
            }
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
            [['ccEmail', 'ccName'], 'string'],
        ];
    }
    
    
    
    // Protected Methods
    // =========================================================================
    
    protected function prepEmailConfig($emails)
    {
        if (!$emails) {
            return null;
        }
        
        if (!is_array($emails)) {
            $emails = explode(',', $emails);
        }
        
        if (count($emails) < 1) {
            return null;
        }
        
        $emails = array_map('trim', $emails);
        
        return $emails;
    }
}
