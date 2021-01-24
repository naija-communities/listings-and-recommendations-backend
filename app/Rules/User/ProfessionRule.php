<?php

namespace App\Rules\User;

use App\Rules\AllowedRule;

class ProfessionRule extends AllowedRule
{
    public function __construct()
    {
        $this->allowed = [
            'accountant',
            'architect',
            'banker',
            'civil engineer',
            'forex trader',
            'family doctor',
            'farmer',
            'health care professional',
            'medical doctor',
            'nurse',
            'social worker',
            'network engineer',
            'software engineer (web)',
            'software engineer (mobile)',
            'ui/ux designer',
            'project management',
            'student',
            'tutor/educator',
            'real estate agent',
            'retail business owner',
            'small business owner',
            'lawyer',
            'immigration lawyer',
            'military',
            'military veteran',
            'religious leader',
            'writer',
            'other',
            'rather not say'
        ];
    }
}
