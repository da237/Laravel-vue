<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();
        return Inertia::render('Contact/Index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contact/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // Mostrar todo el contenido del request
        // dd($request->all());

        // La función except nos sirve para decirle que no tenga en cuenta cierto dato, en este caso la imagen
        $data = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            try {
                $file = $request->file('avatar');
                $routeName = $file->store('avatars', ['disk' => 'public']);
                $data['avatar'] = $routeName;
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al subir la imagen: ' . $e->getMessage()], 500);
            }
        }

        // Mostrar los datos después de almacenar la imagen
        // dd($data);
        $data['user_id'] = Auth::user()->id;
        Contact::create($data); // Corregir el error tipográfico aquí

        return to_route('contact.index');
    }




    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return Inertia::render('Contact/Edit',compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Contact $contact)
    {

        $data = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            try {
                $file = $request->file('avatar');
                $routeName = $file->store('avatars', ['disk' => 'public']);
                $data['avatar'] = $routeName;

                if ($contact->avatar){
                    Storage::disk('public')->delete($contact->avatar);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al subir la imagen: ' . $e->getMessage()], 500);
            }
        }

        $contact->update($data);
        return to_route('contact.index');
        // return to_route('contact.edit',$contact);
        // return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if ($contact->avatar){
            Storage::disk('public')->delete($contact->avatar);
        }

        $contact->delete();
        return to_route('contact.index');
    }
}
