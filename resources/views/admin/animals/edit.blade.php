@extends('layouts.admin')

@section('header', 'Edit Animal: ' . $animal->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.animals.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Animals
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-xl font-bold text-slate-900">Edit Details</h2>
    </div>

    <form action="{{ route('admin.animals.update', $animal->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Basic Info -->
            <div class="space-y-4">
                <h3 class="font-bold text-slate-900 border-b border-slate-100 pb-2">Basic Information</h3>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $animal->name) }}" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Species <span class="text-red-500">*</span></label>
                    <select name="species_id" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                        @foreach($species as $s)
                            <option value="{{ $s->id }}" {{ old('species_id', $animal->species_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('species_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="male" {{ old('gender', $animal->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $animal->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="unknown" {{ old('gender', $animal->gender) == 'unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Age</label>
                        <input type="number" name="age" value="{{ old('age', $animal->age) }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight_kg" value="{{ old('weight_kg', $animal->weight_kg) }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Height/Length (cm)</label>
                        <input type="number" step="0.01" name="height_cm" value="{{ old('height_cm', $animal->height_cm) }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            <!-- Zoo Details -->
            <div class="space-y-4">
                <h3 class="font-bold text-slate-900 border-b border-slate-100 pb-2">Zoo Details & Status</h3>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Enclosure <span class="text-red-500">*</span></label>
                    <select name="enclosure_id" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                        @foreach($enclosures as $e)
                            <option value="{{ $e->id }}" {{ old('enclosure_id', $animal->enclosure_id) == $e->id ? 'selected' : '' }}>{{ $e->name }} ({{ $e->habitat->name }})</option>
                        @endforeach
                    </select>
                    @error('enclosure_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Conservation Status <span class="text-red-500">*</span></label>
                    <select name="conservation_status" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                        @foreach(['Least Concern', 'Near Threatened', 'Vulnerable', 'Endangered', 'Critically Endangered', 'Extinct in Wild'] as $status)
                            <option value="{{ $status }}" {{ old('conservation_status', $animal->conservation_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Diet</label>
                        <input type="text" name="diet" value="{{ old('diet', $animal->diet) }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Arrival Date</label>
                        <input type="date" name="arrival_date" value="{{ old('arrival_date', $animal->arrival_date ? $animal->arrival_date->format('Y-m-d') : '') }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Thumbnail Image</label>
                    @if($animal->thumbnail)
                        <div class="mb-2 w-24 h-24 rounded-lg overflow-hidden border border-slate-200">
                            <img src="{{ asset('storage/' . $animal->thumbnail) }}" class="w-full h-full object-cover">
                        </div>
                        <p class="text-xs text-slate-500 mb-2">Upload a new image to replace the current thumbnail.</p>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="space-y-4 mb-8">
            <h3 class="font-bold text-slate-900 border-b border-slate-100 pb-2">Description & Extra Media</h3>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">{{ old('description', $animal->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Fun Fact</label>
                <input type="text" name="fun_fact" value="{{ old('fun_fact', $animal->fun_fact) }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Add Gallery Images</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="text-xs text-slate-500 mt-1">Upload additional images to append to the existing gallery.</p>
                @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            @if($animal->images->count() > 0)
                <div class="pt-4">
                    <p class="text-sm font-medium text-slate-700 mb-2">Current Gallery Images</p>
                    <div class="flex flex-wrap gap-4">
                        @foreach($animal->images as $img)
                            <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-slate-200 group">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                <!-- Deletion could be handled via a separate endpoint/button, omitted here for brevity -->
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.animals.index') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 font-bold transition-colors">Update Animal</button>
        </div>
    </form>
</div>
@endsection
