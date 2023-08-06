<?php

namespace App\Http\Controllers;

use App\Http\Requests\PDFGenRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFGenController extends Controller
{
    /**
     * Prepare the data for the PDF
     */
    public function export(PDFGenRequest $request)
    {
        $validated = $request->validated();

        session()->put([
            'companyName' => $validated['companyName'],
            'logoURL' => $validated['logoURL'],
            'invoiceNum' => $validated['invoiceNum'],
            'issueDate' => $validated['issueDate'],
            'dueDate' => $validated['dueDate'],
            'address' => $validated['address'],
            'billedToEst' => $validated['billedToEst'],
            'billedToAddress' => $validated['billedToAddress'],
            'billedToEmail' => $validated['billedToEmail'],
            'currency' => $validated['currency'],
            'paymentMethod' => $validated['paymentMethod'],
            'itemsNum' => $validated['itemsNum'],
            'items' => $validated['items'],
            'invoiceTotal' => $validated['invoiceTotal'],
            'issuerPhone' => $validated['issuerPhone'],
            'issuerEmail' => $validated['issuerEmail'],
            'paperSize' => $validated['paperSize'],
            'Status' => $validated['Status'],

        ]);

        return to_route('preview');
    }

    /**
     * Preview the PDF
     */
    public function preview()
    {
        return inertia('Pdf', [
            'companyName' => session('companyName'),
            'logoURL' => session('logoURL'),
            'invoiceNum' => session('invoiceNum'),
            'issueDate' => session('issueDate'),
            'dueDate' => session('dueDate'),
            'address' => session('address'),
            'billedToEst' => session('billedToEst'),
            'billedToAddress' => session('billedToAddress'),
            'billedToEmail' => session('billedToEmail'),
            'currency' => session('currency'),
            'paymentMethod' => session('paymentMethod'),
            'itemsNum' => session('itemsNum'),
            'items' => session('items'),
            'invoiceTotal' => session('invoiceTotal'),
            'issuerPhone' => session('issuerPhone'),
            'issuerEmail' => session('issuerEmail'),
            'Status' => session('Status'),

        ]);
    }

    /**
     *  Render the PDF and download it
     */
    public function download()
    {
        $postfix = 'inc-'.session('invoiceNum').'-'.now()->format('YmdHis');

        $html = view('pdf', [
            'companyName' => session('companyName'),
            'logoURL' => session('logoURL'),
            'invoiceNum' => session('invoiceNum'),
            'issueDate' => session('issueDate'),
            'dueDate' => session('dueDate'),
            'address' => session('address'),
            'billedToEst' => session('billedToEst'),
            'billedToAddress' => session('billedToAddress'),
            'billedToEmail' => session('billedToEmail'),
            'currency' => session('currency'),
            'paymentMethod' => session('paymentMethod'),
            'itemsNum' => session('itemsNum'),
            'items' => session('items'),
            'invoiceTotal' => session('invoiceTotal'),
            'issuerPhone' => session('issuerPhone'),
            'issuerEmail' => session('issuerEmail'),
            'paperSize' => session('paperSize'),
            'Status' => session('Status'),

        ])->render();
        $pdf = PDF::loadHTML($html)->setPaper(session('paperSize'));
        return $pdf->stream('invoice-'.$postfix.'.pdf');
    }
}
