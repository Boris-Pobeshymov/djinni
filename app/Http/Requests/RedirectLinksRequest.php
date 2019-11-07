<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Domain;

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
        return [
            'user_id' => 'required',
            'old_slug' => [
                'required',
                new Domain(),
            ],
            'slug' => 'required|unique:redirect_links',
            'status' => 'boolean',
        ];
    }


    public function all($keys = null)
    {
        // return $this->all();
        $data = parent::all($keys);
        $data['user_id'] = Auth::user()->id;
        return $data;
    }


}
