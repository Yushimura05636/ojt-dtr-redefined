<x-main-layout>
    <button class="lg:!px-8 px-3 my-3 bg-white px-16 py-3 border rounded-full text-[#F57D11] hover:border-[#F57D11] animate-transition flex items-center justify-start gap-2 lg:text-sm text-xs cursor-pointer w-auto" 
    type="button" 
    onclick="window.location.href='{{ route('admin.histories') }}'">
<div class="w-auto h-auto">
    <span class="eva--arrow-back-fill"></span>
</div>
<p class="md:block hidden">Back</p>
</button>
    <div class="h-auto w-full flex flex-col gap-5">
        @if(session('success'))
            <x-modal.flash-msg msg="success" />
        @endif

        @if(session('error'))
            <x-modal.flash-msg msg="error" />
        @endif
    </div>
    <div class="h-auto w-full flex flex-col gap-5">


        {{-- Edit Form for a Single History Entry --}}
        <form id="historyForm" action="{{ route('admin.histories.edit.post', ['id' => $history->id]) }}" method="POST" class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            @csrf
            @method('PUT')

            <h2 class="text-xl font-semibold text-[#F57D11] flex items-center gap-2 py-3 justify-between">
                <x-form.section-title title="Edit History Record" />
                <button type="submit" class="px-16 py-3 rounded-full text-white bg-gradient-to-r from-[#F57D11] to-[#F53C11] hover:bg-[#F53C11] disabled:opacity-50 lg:text-sm text-xs cursor-pointer">
                    Save Changes
                </button>
            </h2>

            <div class="user-history-card p-4 border rounded-lg shadow-md bg-white relative">
                <div class="flex items-center gap-4">
                    <img src="{{ \App\Models\File::where('id', $history->user->profile_id)->first()->path ?? 'https://via.placeholder.com/50' }}" class="w-12 h-12 rounded-full" alt="{{ $history->user->firstname }}">
                    <div>
                        <h3 class="text-lg font-semibold text-[#F57D11]">{{ $history->user->firstname }} {{ $history->user->lastname }}</h3>
                        <p class="text-sm text-gray-600">{{ $history->user->email }}</p>
                    </div>
                </div>

                <div class="history-container mt-4">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <select name="history_description" class="w-full p-2 border rounded-lg focus:ring-[#F57D11] focus:border-[#F57D11]" required>
                        <option value="Time In" {{ $history->description == 'Time In' ? 'selected' : '' }}>Time In</option>
                        <option value="Time In | Late" {{ $history->description == 'Time In | Late' ? 'selected' : '' }}>Time In | Late</option>
                        <option value="Time Out" {{ $history->description == 'Time Out' ? 'selected' : '' }}>Time Out</option>
                    </select>

                    <label class="block text-sm font-medium text-gray-700 mt-3">DateTime</label>
                    <input type="datetime-local" name="history_datetime" value="{{ $history->datetime }}" class="w-full p-2 border rounded-lg focus:ring-[#F57D11] focus:border-[#F57D11]" required>
                </div>
            </div>
        </form>
    </div>
</x-main-layout>
