<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Company;
use App\Models\User;

class ContactController extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $companies = Company::userCompanies();
        // \DB::enableQueryLog();
        $contacts  = auth()->user()->contacts()->with('company')->latestFirst()->paginate(10);
        // dd(\DB::getQueryLog());
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        $contact   = new Contact();
        $companies = Company::userCompanies();

        return view('contacts.create', compact('companies', 'contact'));
    }

    /**
     * Designated method to obtain contact form data 
     * to be trated as well to save.
     * @param Request $request
     */
    public function store(Request $request) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);

        $request->user()->contacts()->create($request->all());

//        Contact::create($request->all()+['user_id' => auth()->id]);

        return redirect()->route('contacts.index')->with('message', "Contact has been added successfully!");
    }

    public function edit(Contact $contact)
    {
        $companies = Company::userCompanies();

        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update($id, Request $request) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);

        $contact = Contact::findOrFail($id);

        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('message', "Contact has been updated successfully!");
    }

    public function destroy($id) {

        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('message', "Contact has been deleted sucessfully!");
    }

    public function show($id) {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact')); // ['contact' => $contact ]     
    }

}
