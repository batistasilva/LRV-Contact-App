<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Company;

class ContactController extends Controller {

    public function index() {
        
        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');
        /**
         * Here get all data for populate the view table, as well
         * do a compare to set up filter for company selected.
         */
        $contacts = Contact::orderBy('first_name', 'asc')->where(function($query) {
           if($companyId = request('company_id')){
             $query->where('company_id', $companyId);
           }
        })->paginate(10);
        
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create() {
        return view('contacts.create');
    }

    public function show($id) {
        $contact = Contact::find($id);
        return view('contacts.show', compact('contact')); // ['contact' => $contact ]     
    }

}
