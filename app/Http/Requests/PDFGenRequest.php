<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PDFGenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'companyName' => 'required|string|max:255|min:3',
            'logoURL' => 'required|url',
            'invoiceNum' => 'required|integer',
            'issueDate' => 'required|string',
            'dueDate' => 'required|string',
            'address' => 'required|string|max:500',
            'billedToEst' => 'required|string|max:255',
            'billedToAddress' => 'required|string|max:500',
            'billedToEmail' => 'email|max:255',
            'currency' => 'required|string|max:3',
            'paymentMethod' => 'required|string|max:255',
            'itemsNum' => 'required|integer|min:1',
            'invoiceTotal' => 'required|string|min:1',
            'issuerPhone' => 'required|string',
            'issuerEmail' => 'required|email|max:255',
            'paperSize'=> 'required|string|in:A4,letter,legal',
            'Status'=> 'required|string|in:Paid,Sent,Overdue',
            'items' => 'required|array',
            'items.*.description' => 'required|string|min:3|max:255',
            'items.*.price' => 'required|numeric|min:0',

        ];

    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.*.description.required' => 'Description Required',
            'items.*.price.required' => 'Price Required',
            'items.*.price.numeric' => 'Price Must be a number',
            'billedToEst.required' => 'Field Required',
            'billedToAddress.required' => 'Field Required',
            'billedToEmail.required' => 'Field Required',
            //TODO: Complete the rest



        ];
    }

}
