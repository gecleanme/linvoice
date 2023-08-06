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
            //TODO: Revise rules
            'companyName' => 'required|string|max:255|min:3',
            'logoURL' => 'required|url',
            'invoiceNum' => 'required|integer',
            'issueDate' => 'required|string|min:6',
            'dueDate' => 'required|string|min:6',
            'address' => 'required|string|max:500',
            'billedToEst' => 'required|string|max:255',
            'billedToAddress' => 'nullable|string|max:500',
            'billedToEmail' => 'nullable|email|max:255',
            'currency' => 'required|string|max:3',
            'paymentMethod' => 'required|string|max:255',
            'itemsNum' => 'required|integer|min:1',
            'invoiceTotal' => 'required|string|min:1',
            'issuerPhone' => 'required|string',
            'issuerEmail' => 'required|email|max:255',
            'paperSize' => 'required|string|in:A4,letter,legal',
            'Status' => 'required|string|in:Paid,Sent,Overdue',
            'items' => 'required|array',
            'items.*.description' => 'required|string|min:3|max:255',
            'items.*.price' => 'required|string',

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
            'billedToEmail.email' => 'Field Required',
            'companyName.required' => 'Issuer Name Required',
            'issuerEmail.required' => 'Issuer Email Required',
            'issuerEmail.email' => 'Issuer Email Required',
            'address.required' => 'Issuer Address Required',
            'issueDate.min' => 'Invalid Date',
            'dueDate.min' => 'Invalid Date',

            //TODO: Complete the rest

        ];
    }
}
