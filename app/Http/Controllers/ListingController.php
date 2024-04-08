<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all job listings
    public function index()
    {

        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }
    //show single job listings
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    public function create()
    {
        return view('listings.create');
    }
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'email' => ['required', 'email'],
            'website' => 'required',
            'location' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        

        $formFields['user_id']= auth()->id();

        Listing::create($formFields);

        //Session::flash('message','Listing created successfully');


        return redirect('/')->with('message', 'Listing created successfully!');
    }

    //show edit form
    public function edit( Listing $listing)
    {
        return view('listings.edit', ['listing'=>$listing]);
    }

    //update listings 
    public function update(Request $request, Listing $listing){

        //Make sure logged in user is the owner of listing
        if($listing->user_id!=auth()->id()){
            return abort(403,'Unauthorized action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'location' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }
    //delete
    public function destroy( Listing $listing){

        //Make sure logged in user is the owner of listing
        if ($listing->user_id != auth()->id()) {
            return abort(403, 'Unauthorized action');
        }
        
     $listing->delete();
     return redirect('/')->with('message','Listing deleted successfully');
    }

    //show manage form

    public function manage(){
        return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);
    }
}
