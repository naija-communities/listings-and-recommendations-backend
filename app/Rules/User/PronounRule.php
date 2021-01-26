<?php

namespace App\Rules\User;

use App\Rules\AllowedRule;

class PronounRule extends AllowedRule
{
    /**
     * PronounRule constructor.
     */
    public function __construct()
    {
        $this->attribute = "selected pronoun";
        $this->allowed =   ['she/her', 'he/him', 'they/them', 'rather not say'];
    }
}
