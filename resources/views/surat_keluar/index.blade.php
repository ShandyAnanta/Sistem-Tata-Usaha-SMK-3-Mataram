@extends('layouts.app')
@section('title','Surat Keluar')
@section('content')
<div class="flex flex-col gap-4">
  <div class="flex flex-col gap-3 md:flex-row md:items-center">
    <form method="get" class="flex flex-1 items-center gap-2">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor/nama/keterangan..." class="w-full md:w-64 rounded border px-3 py-2">
      <input type="date" name="from" value="{{ request('from') }}" class="rounded border px-3 py-2">
      <input type="date" name="to" value="{{ request('to') }}" class="rounded border px-3 py-2">
      <button class="rounded bg-blue-600 px-4 py-2 text-white">Filter</button>
    </form>
    <a href="{{ route('surat-keluar.create') }}" class="rounded bg-green-600 px-4 py-2 text-white">+ Buat Surat</a>
  </div>

  <div class="overflow-hidden rounded-lg border bg-white">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Tanggal</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Nama</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Keterangan surat</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">No surat</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 bg-white">
        @forelse($items as $i)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($i->tanggal_surat)->format('d M Y') }}</td>
            <td class="px-4 py-3">{{ $i->nama_penerima }}</td>
            <td class="px-4 py-3">{{ $i->keterangan_surat }}</td>
            <td class="px-4 py-3 whitespace-nowrap">{{ $i->nomor_surat }}</td>
            <td class="px-4 py-3">
              <div class="flex items-center gap-3">
                <a class="text-blue-600" href="{{ route('surat-keluar.show',$i->id) }}">Detail</a>
                <form method="post" action="{{ route('surat-keluar.destroy',$i->id) }}" onsubmit="return confirm('Hapus surat ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="text-red-600">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada surat keluar.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="flex justify-end">
    {{ $items->withQueryString()->links() }}
  </div>
</div>
@endsection
