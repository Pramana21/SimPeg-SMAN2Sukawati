<div class="bg-white shadow p-4 flex justify-between items-center">

<div class="text-lg font-bold">

SIMPEG SMAN 2 SUKAWATI

</div>

<div>

<span class="mr-4">

{{ Auth::user()->name }}

</span>

<form method="POST" action="{{ route('logout') }}" style="display:inline">

@csrf

<button class="bg-red-500 text-white px-3 py-1 rounded">

Logout

</button>

</form>

</div>

</div>