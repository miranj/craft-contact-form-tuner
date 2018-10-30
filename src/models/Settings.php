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
    
    
    
    // Public Methods
    // =========================================================================
    
    public function getCcConfig()
    {
        if (!$this->ccEmail) {
            return null;
        }
        
        $emails = $this->ccEmail;
        if (!is_array($emails)) {
            $emails = explode(',', $this->ccEmail);
        }
        
        if (count($emails) < 1) {
            return null;
        }
        
        $emails = array_map('trim', $emails);
        
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
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccEmail', 'ccName'], 'string'],
        ];
    }
}
