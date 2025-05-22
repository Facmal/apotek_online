<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fe.contact.index', [
            'title' => 'Contact',
            'menu' => 'Contact'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string'
        ]);

        try {
            // Kirim email ke admin
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactMail($validated));

            // Kirim email konfirmasi ke pengirim
            Mail::to($validated['email'])->send(new ContactMail([
                'name' => 'Admin Apotek',
                'email' => env('MAIL_FROM_ADDRESS'),
                'phone' => '-',
                'message' => "Terima kasih telah menghubungi kami. Kami akan segera merespons pesan Anda."
            ]));

            return redirect()->back()->with('pesan', 'Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            \Log::error('Email Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi: ' . $e->getMessage())
                ->withInput();
        }
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
