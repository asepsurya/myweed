<x-app-layout>
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-semibold mb-6">Edit Undangan</h1>

    <a href="{{ url($invitation->slug) }}" target="_blank"
       class="text-blue-600 underline">Preview Undangan</a>

    <form method="POST"
          action="{{ route('invitation.update', $invitation) }}"
          class="space-y-4 mt-6">
        @csrf
        @method('PUT')

        <input name="bride_name" value="{{ $invitation->bride_name }}"
               class="w-full border p-3 rounded">

        <input name="groom_name" value="{{ $invitation->groom_name }}"
               class="w-full border p-3 rounded">

        <input type="date" name="wedding_date"
               value="{{ $invitation->wedding_date }}"
               class="w-full border p-3 rounded">

        <input name="location" value="{{ $invitation->location }}"
               class="w-full border p-3 rounded">

        <button class="w-full bg-black text-white py-3 rounded">
            Update Undangan
        </button>
    </form>
</div>
</x-app-layout>
