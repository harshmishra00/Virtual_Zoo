<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(ContactRequest $request)
    {
        Contact::create($request->validated());

        return back()->with('success', 'Your message has been sent! We will get back to you within 24 hours.');
    }
}
