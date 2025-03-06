<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <label for="firstName" class="block mb-1 text-sm font-medium text-gray-700">Ime <small class="relative -top-1 text-red-500">*</small></label>
        <input type="text" name="firstName" id="firstName" wire:model.change="firstName"
            class="px-3 py-2 w-full text-gray-700 rounded-md border focus:outline-none focus:ring-2 focus:ring-primary {{ $errors->has('firstName') ? 'border-red-500' : '' }}"
            required>
        @error('firstName')
            <span class="block mt-1 text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="lastName" class="block mb-1 text-sm font-medium text-gray-700">Prezime <small class="relative -top-1 text-red-500">*</small></label>
        <input type="text" name="lastName" id="lastName" wire:model.change="lastName"
            class="px-3 py-2 w-full text-gray-700 rounded-md border focus:outline-none focus:ring-2 focus:ring-primary {{ $errors->has('lastName') ? 'border-red-500' : '' }}"
            required>
        @error('lastName')
            <span class="block mt-1 text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 gap-4 my-4 sm:grid-cols-2">
    <div>
        <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email <small class="relative -top-1 text-red-500">*</small></label>
        <input type="email" name="email" id="email" wire:model.change="email"
            class="px-3 py-2 w-full text-gray-700 rounded-md border focus:outline-none focus:ring-2 focus:ring-primary {{ $errors->has('email') ? 'border-red-500' : '' }}"
            required>
        @error('email')
            <span class="block mt-1 text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="phone" class="block mb-1 text-sm font-medium text-gray-700">Telefon</label>
        <input type="tel" name="phone" id="phone" wire:model.change="phone"
            class="px-3 py-2 w-full text-gray-700 rounded-md border focus:outline-none focus:ring-2 focus:ring-primary">
    </div>
</div>

<div class="my-4">
    <label for="team" class="block mb-1 text-sm font-medium text-gray-700">Koju ekipu podržavate? <small class="relative -top-1 text-red-500">*</small></label>
    <select name="team" id="team"
        class="px-3 py-2 w-full text-gray-700 rounded-md border focus:outline-none focus:ring-2 focus:ring-primary {{ $errors->has('teamId') ? 'border-red-500' : '' }}"
        wire:model.change="teamId" required>
        <option value="-" disabled selected>-- Odaberite ekipu --</option>
        @foreach (\App\Services\Helpers::currentTeams() as $team)
            <option value="{{ $team->id }}">{{ $team->title }}</option>
        @endforeach
    </select>
    @error('teamId')
        <span class="block mt-1 text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
