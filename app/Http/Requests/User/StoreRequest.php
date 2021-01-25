<?php

namespace App\Http\Requests\User;

use App\Rules\User\CanadianProvinceRule;
use App\Rules\User\PostalCodeRule;
use App\Rules\User\ProfessionRule;
use App\Rules\User\PronounRule;
use App\Rules\User\RelationshipStatusRule;
use App\Rules\User\TopicRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'pronouns' => ['required', new PronounRule()],
            'relationship_status' => ['required', new RelationshipStatusRule()],
            'profession' => ['required', new ProfessionRule()],
            'province' => ['required', new CanadianProvinceRule()],
            'city' => 'required',
            'postal_code' => ['required', new PostalCodeRule()],
            'year_of_entry' => 'required|date_format:Y-m-d',
            'topics' => ['json'],
        ];
    }
}
