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
        $contacts = Contact::orderBy('id', 'desc')->where(function($query) {
           if($companyId = request('company_id')){
             $query->where('company_id', $companyId);
           }
        })->paginate(10);
        
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create() {
        
        $contact = new Contact();
        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');
        
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
            'last_name'  => 'required',
            'email'      => 'required|email',
            'address'    => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);
        
        Contact::create($request->all());
        
        return redirect()->route('contacts.index')->with('message',"Contact has been added successfully!");
    }
    
    public function edit($id) {        
        $contact = Contact::findOrFail($id);
        
        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');           
        
        return view('contacts.edit', compact('companies', 'contact')); 
    }
    
    public function update($id, Request $request){
       $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email',
            'address'    => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);
        
        $contact = Contact::findOrFail($id);
        
        $contact->update($request->all());
        
        return redirect()->route('contacts.index')->with('message',"Contact has been updated successfully!");
    }


    
    public function show($id) {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact')); // ['contact' => $contact ]     
    }

}
