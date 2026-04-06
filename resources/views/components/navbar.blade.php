<div class="flex items-center justify-between bg-white px-6 py-4 shadow-sm">

    <!-- TITLE -->
    <h1 class="text-xl font-semibold text-gray-800">
        Welcome Back
    </h1>

    <!-- RIGHT SECTION -->
    <div class="flex items-center gap-4">

        <!-- SEARCH -->
        <div class="relative">
            <input type="text"
                placeholder="Search..."
                class="w-64 pl-10 pr-4 py-2 rounded-md bg-blue-500 text-white placeholder-white focus:outline-none">

            <i data-feather="search"
               class="absolute left-3 top-2.5 w-4 h-4 text-white"></i>
        </div>

        <!-- NOTIFICATION -->
        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-500 text-white cursor-pointer">
            <i data-feather="bell"></i>
        </div>

        <!-- PROFILE -->
        <img src="{{ asset('profile.jpg') }}"
             class="w-10 h-10 rounded-full object-cover border-2 border-white shadow">

    </div>

</div>
