<?php

namespace App\Rules\User;

use App\Rules\AllowedRule;

class CanadianProvinceRule extends AllowedRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->attribute = "province";

        $this->allowed = [
            'Alberta AB',
            'British Columbia BC',
            'Manitoba MAN',
            'Newfoundland and Labrador NFL',
            'Nova Scotia NS',
            'New Brunswick NB',
            'Nunavut NVT',
            'Northwest Territories NWT',
            'Ontario ON',
            'Prince Edward Island PEI',
            'Quebec QUE',
            'Saskatchewan SASK',
            'Yukon YT'
        ];
    }
}
