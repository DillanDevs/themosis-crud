<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $rutRule = ['required', 'regex:/^\d{1,2}\.\d{3}\.\d{3}-[kK\d]$/'];

    public function index()
    {
        $people = Person::orderBy('created_at', 'desc')->get();
        return view('people.index', compact('people'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $table = (new Person())->getTable();

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'rut' => array_merge(
                $this->rutRule,
                ["unique:{$table},rut"]
            ),
            'birth_date' => 'required|date',
        ], [
            'rut.unique' => 'Este RUT ya está registrado.',
        ]);

        Person::create($data);

        return redirect()->route('people.index')
            ->with('success', 'Registro creado correctamente.');
    }


    public function edit(Person $person)
    {
        return view('people.edit', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $table = (new Person())->getTable();

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'rut' => array_merge(
                $this->rutRule,
                ["unique:{$table},rut,{$person->id}"]
            ),
            'birth_date' => 'required|date',
        ], [
            'rut.unique' => 'Este RUT ya está registrado.',
        ]);

        $person->update($data);

        return redirect()->route('people.index')
            ->with('success', 'Registro actualizado correctamente.');
    }


    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()->route('people.index')
            ->with('success', 'Registro eliminado correctamente.');
    }
}
