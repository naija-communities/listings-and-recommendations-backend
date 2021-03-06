<?php

namespace App\Rules\User;

use App\Rules\AllowedRule;

class RelationshipStatusRule extends AllowedRule
{
    /**
     * RelationshipStatusRule constructor.
     */
    public function __construct()
    {
        $this->attribute = "status";
        $this->allowed =  ['single', 'very single', 'taken'];
    }
}
