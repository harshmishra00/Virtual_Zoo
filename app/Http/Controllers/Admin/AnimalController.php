<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Species;
use App\Models\Enclosure;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::withTrashed()->with(['species', 'enclosure.habitat']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $animals = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.animals.index', compact('animals'));
    }

    public function create()
    {
        $species    = Species::all();
        $enclosures = Enclosure::with('habitat')->get();

        return view('admin.animals.create', compact('species', 'enclosures'));
    }

    public function store(StoreAnimalRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('animals', 'public');
        }

        $animal = Animal::create($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $img) {
                $path = $img->store('animals/gallery', 'public');
                $animal->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.animals.index')
            ->with('success', "Animal '{$animal->name}' created successfully!");
    }

    public function edit(Animal $animal)
    {
        $species    = Species::all();
        $enclosures = Enclosure::with('habitat')->get();

        return view('admin.animals.edit', compact('animal', 'species', 'enclosures'));
    }

    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('animals', 'public');
        }

        $animal->update($data);

        return redirect()->route('admin.animals.index')
            ->with('success', "Animal '{$animal->name}' updated successfully!");
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();
        return back()->with('success', "Animal '{$animal->name}' archived.");
    }

    public function restore($id)
    {
        $animal = Animal::withTrashed()->findOrFail($id);
        $animal->restore();
        return back()->with('success', "Animal restored.");
    }
}
