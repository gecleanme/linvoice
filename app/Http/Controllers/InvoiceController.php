<?php

namespace App\Http\Controllers;

class InvoiceController extends Controller
{
    /*
     * Show the create invoice page
     */
    public function __invoke()
    {
        return inertia('CreateInvoice');
    }
}
