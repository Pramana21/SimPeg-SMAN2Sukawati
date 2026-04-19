<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>{{ config('app.name') }} SMAN 2 Sukawati</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container-fluid">

<div class="row">

<div class="col-md-2 bg-light min-vh-100">

<h4 class="mt-3">{{ config('app.name') }}</h4>

<ul class="nav flex-column mt-4">

<li class="nav-item">
<a class="nav-link" href="/dashboard">Dashboard</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Role Akses</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Manajemen User</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Audit Log</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Penyuratan</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Keuangan</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Inventaris</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Data Center</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Administrasi Umum</a>
</li>

</ul>

</div>

<div class="col-md-10 p-4">

@yield('content')

</div>

</div>

</div>

</body>
</html>
