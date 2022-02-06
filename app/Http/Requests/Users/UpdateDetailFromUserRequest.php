<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailFromUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        //dd($this->request->all());
        return [
            'citizenship_country_id' => 'required|exists:countries,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required'
        ];
    }
}
