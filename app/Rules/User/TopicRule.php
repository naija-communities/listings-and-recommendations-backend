<?php

namespace App\Rules\User;

use App\Rules\AllowedRule;

class TopicRule extends AllowedRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->attribute = "selection";

        $this->allowed =  [
            'food and drink',
            'sports',
            'technology',
            'men`s fashion',
            'women`s fashion',
            'lifestyle',
            'family',
            'antenatal',
            'pregnancy',
            'children',
            'business',
            'finance',
            'tax',
            'account',
            'real estate',
            'apartment rental',
            'groceries',
            'pharmaceuticals',
            'diy crafts',
            'events',
            'car rental',
            'rental',
            'car deals',
            'driving',
            'leisure',
            'shopping',
            'self care',
            'books',
            'weddings',
            'photography',
            'family health'
        ];
    }
}
