<?php

namespace App\Rules\User;

use App\Rules\AllowedRule;

class ProfessionRule extends AllowedRule
{
    public function __construct()
    {
        $this->attribute = "selected profession";

        $this->allowed = [
            'accountant',
            'architect',
            'artist',
            'banker',
            'civil engineer',
            'forex trader',
            'family doctor',
            'farmer',
            'health care professional',
            'medical doctor',
            'music teacher',
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
            'yputuber',
            'rather not say'
        ];
    }
}
