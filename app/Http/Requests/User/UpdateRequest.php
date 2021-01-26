<?php

namespace App\Http\Requests\User;

use App\Rules\User\CanadianProvinceRule;
use App\Rules\User\PostalCodeRule;
use App\Rules\User\ProfessionRule;
use App\Rules\User\PronounRule;
use App\Rules\User\RelationshipStatusRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        if (!Auth::id()) {
//            return false;
//        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'min:8',
            'pronouns' => [new PronounRule()],
            'relationship_status' => [new RelationshipStatusRule()],
            'profession' => [new ProfessionRule()],
            'province' => [new CanadianProvinceRule()],
            'postal_code' => [new PostalCodeRule()],
            'year_of_entry' => 'date_format:Y-m-d',
            'topics' => ['json'],
        ];
    }
}
