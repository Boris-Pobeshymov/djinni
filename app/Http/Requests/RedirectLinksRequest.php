<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Domain;
use Illuminate\Validation\Rule;

class RedirectLinksRequest extends FormRequest
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
        $rules =  [
            'user_id' => 'required',
            'old_slug' => [
                'required',
                new Domain(),
            ],
            'slug' => 'required|unique:redirect_links',
            'status' => 'boolean',
        ];

        switch ($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                        'id' => 'required|integer|exists:redirect_links,id',
                        'slug' => [
                            'required',
                            Rule::unique('redirect_links')->ignore($this->slug)
                        ]
                    ] + $rules; // и берем все остальные правила
            case 'PATCH':
                return [
                        'id' => 'required|integer|exists:redirect_links,id',
                        'status' => 'required|boolean'
                    ];
            case 'DELETE':
                return [
                    'id' => 'required|integer|exists:redirect_links,id'
                ];
        }

    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        switch ($this->getMethod())
        {
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                $data['id'] = $this->route('link');
        }

        $data['user_id'] = Auth::user()->id;
        return $data;
    }


}
