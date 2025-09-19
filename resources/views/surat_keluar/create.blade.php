@extends('layouts.app')

@section('title','Buat Surat Keluar')

@section('content')
<form method="post" action="{{ route('surat-keluar.store') }}" class="space-y-4 max-w-2xl" enctype="multipart/form-data">
    @csrf

    <div>
        <label class="block mb-1 text-sm text-gray-700">Tanggal</label>
        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" class="w-full rounded border px-3 py-2" required>
        @error('tanggal_surat') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">Nama (Penerima)</label>
        <input name="nama_penerima" value="{{ old('nama_penerima') }}" class="w-full rounded border px-3 py-2" required>
        @error('nama_penerima') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">Keterangan Surat</label>
        <input name="keterangan_surat" value="{{ old('keterangan_surat') }}" class="w-full rounded border px-3 py-2" required>
        @error('keterangan_surat') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">No Surat</label>
        <input name="nomor_surat" value="{{ old('nomor_surat') }}" class="w-full rounded border px-3 py-2" required>
        @error('nomor_surat') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">File (PDF/JPG/PNG, maks 2MB)</label>
        <input type="file" name="file" class="w-full rounded border px-3 py-2" required>
        @error('file') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="flex gap-2">
        <button class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">Simpan</button>
        <a href="{{ route('surat-keluar.index') }}" class="rounded border px-4 py-2">Batal</a>
    </div>

</form>
@endsection
