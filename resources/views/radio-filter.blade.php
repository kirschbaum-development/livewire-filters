<div>
    <div class="space-y-2">
        @foreach ($options as $option)
            <div class="flex items-center">
                <input
                    type="radio"
                    name="{{ $key }}"
                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                    id="{{ $key }}-{{ $option }}"
                    wire:model="value"
                    value="{{ $option }}"
                >
                <label for="{{ $key }}-{{ $option }}" class="ml-2 block text-sm text-gray-700"> {{ ucfirst($option) }} </label>
            </div>
        @endforeach
    </div>

    @if ($value !== $initialValue)
        <button
            type="button"
            class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            wire:click="resetValue"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            Reset
        </button>
    @endif
</div>