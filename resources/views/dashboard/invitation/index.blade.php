<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pasangan') }}
        </h2>
        <a href="{{ route('invitation.create') }}"
               class="btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
               + Buat Undangan
            </a>
                </div>
    </x-slot>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach ($invitations as $inv)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <h2 class="text-xl font-semibold">
                        {{ $inv->bride_name }} & {{ $inv->groom_name }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $inv->wedding_date }}
                    </p>

                    <div class="flex gap-3 mt-4">
                        <a href="{{ url($inv->slug) }}" target="_blank"
                           class="text-blue-600 hover:underline">Preview</a>

                        <a href="{{ route('invitation.edit', $inv) }}"
                           class="text-green-600 hover:underline">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
</x-app-layout>
