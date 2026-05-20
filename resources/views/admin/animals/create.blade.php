@extends('layouts.admin')

@section('header', 'Add New Animal')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.animals.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Animals
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-xl font-bold text-slate-900">Animal Details</h2>
    </div>

    <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Basic Info -->
            <div class="space-y-4">
                <h3 class="font-bold text-slate-900 border-b border-slate-100 pb-2">Basic Information</h3>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Species <span class="text-red-500">*</span></label>
                    <select name="species_id" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select Species</option>
                        @foreach($species as $s)
                            <option value="{{ $s->id }}" {{ old('species_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('species_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="unknown" {{ old('gender') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Age</label>
                        <input type="number" name="age" value="{{ old('age') }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight_kg" value="{{ old('weight_kg') }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Height/Length (cm)</label>
                        <input type="number" step="0.01" name="height_cm" value="{{ old('height_cm') }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            <!-- Zoo Details -->
            <div class="space-y-4">
                <h3 class="font-bold text-slate-900 border-b border-slate-100 pb-2">Zoo Details & Status</h3>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Enclosure <span class="text-red-500">*</span></label>
                    <select name="enclosure_id" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select Enclosure</option>
                        @foreach($enclosures as $e)
                            <option value="{{ $e->id }}" {{ old('enclosure_id') == $e->id ? 'selected' : '' }}>{{ $e->name }} ({{ $e->habitat->name }})</option>
                        @endforeach
                    </select>
                    @error('enclosure_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Conservation Status <span class="text-red-500">*</span></label>
                    <select name="conservation_status" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                        <option value="Least Concern" {{ old('conservation_status') == 'Least Concern' ? 'selected' : '' }}>Least Concern</option>
                        <option value="Near Threatened" {{ old('conservation_status') == 'Near Threatened' ? 'selected' : '' }}>Near Threatened</option>
                        <option value="Vulnerable" {{ old('conservation_status') == 'Vulnerable' ? 'selected' : '' }}>Vulnerable</option>
                        <option value="Endangered" {{ old('conservation_status') == 'Endangered' ? 'selected' : '' }}>Endangered</option>
                        <option value="Critically Endangered" {{ old('conservation_status') == 'Critically Endangered' ? 'selected' : '' }}>Critically Endangered</option>
                        <option value="Extinct in Wild" {{ old('conservation_status') == 'Extinct in Wild' ? 'selected' : '' }}>Extinct in Wild</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Diet</label>
                        <input type="text" name="diet" value="{{ old('diet') }}" placeholder="e.g. Carnivore, Omnivore" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Arrival Date</label>
                        <input type="date" name="arrival_date" value="{{ old('arrival_date') }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Thumbnail Image</label>
                    <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="space-y-4 mb-8">
            <h3 class="font-bold text-slate-900 border-b border-slate-100 pb-2">Description & Extra Media</h3>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Fun Fact</label>
                <input type="text" name="fun_fact" value="{{ old('fun_fact') }}" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gallery Images (Multiple)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="text-xs text-slate-500 mt-1">You can upload multiple images for the gallery. They will be processed and optimized automatically.</p>
                @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.animals.index') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 font-bold transition-colors">Save Animal</button>
        </div>
    </form>
</div>
@endsection
