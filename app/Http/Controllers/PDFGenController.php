<?php

namespace App\Http\Controllers;

use App\Http\Requests\PDFGenRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;

class PDFGenController extends Controller
{
    /**
     * Display a listing of the resource.
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
            'paperSize'=> $validated['paperSize'],
            'Status'=> $validated['Status'],


        ]);

        return redirect(route('preview'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function preview()
    {
           return Inertia::render('Pdf',[
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
     * Store a newly created resource in storage.
     */
    public function download()
    {
        $postfix = Str::random(7);
        $html =view('pdf',[
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

        return $pdf->download('invoice_'.$postfix.'.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
