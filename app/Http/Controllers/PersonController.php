<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $rutRule = ['required', 'regex:/^\d{1,2}\.\d{3}\.\d{3}-[kK\d]$/'];

    public function index()
    {
        $people = Person::orderBy('created_at','desc')->get();
        return view('people.index', compact('people'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'rut'        => $this->rutRule,
            'birth_date' => 'required|date',
        ]);

        Person::create($data);

        return redirect()->route('people.index')
                         ->with('success','Registro creado correctamente.');
    }

    public function edit(Person $person)
    {
        return view('people.edit', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'rut'        => $this->rutRule,
            'birth_date' => 'required|date',
        ]);

        $person->update($data);

        return redirect()->route('people.index')
                         ->with('success','Registro actualizado correctamente.');
    }

    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()->route('people.index')
                         ->with('success','Registro eliminado correctamente.');
    }
}
