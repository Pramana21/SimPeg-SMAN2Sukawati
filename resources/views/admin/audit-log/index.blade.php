@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold mb-1">Audit Log</h1>
    <p class="text-gray-500 mb-6">Catatan aktivitas pengguna di sistem.</p>

    <!-- FILTER -->
    <div class="flex items-center gap-3 mb-4">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Januari
        </button>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            2025
        </button>

    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-end gap-2 mb-4">

        <button class="bg-blue-500 text-white px-4 py-2 rounded flex items-center gap-2">
            <i data-feather="download"></i>
            Unduh
        </button>

        <button onclick="deleteSelected()" class="bg-red-500 text-white px-4 py-2 rounded flex items-center gap-2">
            <i data-feather="trash"></i>
            Hapus
        </button>

    </div>

    <div id="successAlert" class="hidden mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">
        Data berhasil dihapus
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow p-4">

        <h2 class="text-lg font-semibold mb-4">
            Aktivitas Terakhir (Audit Log)
        </h2>

        <table class="w-full text-sm">

            <thead>
                <tr class="border-b">
                    <th class="p-2">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th class="p-2 text-left">Waktu</th>
                    <th class="p-2 text-left">Pengguna</th>
                    <th class="p-2 text-left">Modul</th>
                    <th class="p-2 text-left">Aktivitas</th>
                    <th class="p-2 text-left">Keterangan</th>
                </tr>
            </thead>

            <tbody>

                @foreach($logs as $index => $log)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-2">
                        <input type="checkbox" class="rowCheckbox" value="{{ $index }}">
                    </td>

                    <td class="p-2">{{ $log['tanggal'] }}</td>
                    <td class="p-2">{{ $log['user'] }}</td>
                    <td class="p-2">{{ $log['modul'] }}</td>
                    <td class="p-2">{{ $log['aksi'] }}</td>
                    <td class="p-2">{{ $log['keterangan'] }}</td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

<script>

    // SELECT ALL
    document.getElementById('checkAll').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('.rowCheckbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // DELETE SIMULASI
    function deleteSelected() {

        let selected = document.querySelectorAll('.rowCheckbox:checked');

        if (selected.length === 0) {
            alert("Pilih data terlebih dahulu!");
            return;
        }

        // hapus dari UI (sementara)
        selected.forEach(cb => {
            cb.closest('tr').remove();
        });

        // tampilkan alert
        document.getElementById('successAlert').classList.remove('hidden');

    }

</script>
@endsection