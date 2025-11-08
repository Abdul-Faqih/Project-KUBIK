@extends('admin.dashboard.layout.layoutdashboard')

@section('content')
<div class="p-6 bg-[#ECEFF3] min-h-screen">
    <div class="text-sm text-[#F26E21] mb-3">
        <a href="{{ route('admin.dashboard.assets') }}" class="hover:underline">Assets</a> 
        <span class="text-[#2A2A2A]"> > Add Type</span>
    </div>

    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-[#F26E21] font-semibold text-lg mb-6">Add Type</h2>

        <form action="{{ route('admin.types.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-[#2A2A2A] text-sm mb-1">Name</label>
                <input name="name" type="text" placeholder="Type" 
                    class="w-full border border-[#ECEFF3] rounded-md px-3 py-2 text-sm bg-[#FBFBFB]" required />
                <p class="text-xs text-[#AEAEAE] mt-1">Please enter type name</p>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('admin.dashboard.assets') }}" 
                    class="px-4 py-2 rounded-md bg-[#F26E21]/10 text-[#F26E21] hover:bg-[#F26E21]/20 transition">Cancel</a>
                <button type="submit" 
                    class="px-4 py-2 rounded-md bg-[#F26E21] text-white hover:bg-[#e65d1f] transition">Confirm</button>
            </div>
        </form>
    </div>
</div>
@endsection
