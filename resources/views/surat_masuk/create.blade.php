@extends('layouts.app')

@section('title','Tambah Surat Masuk')

@section('content')
<form method="post" action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data" class="space-y-4 max-w-2xl">
    @csrf

    <div>
        <label class="block mb-1 text-sm text-gray-700">Pengirim</label>
        <input name="pengirim" value="{{ old('pengirim') }}" class="w-full rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
        @error('pengirim') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="block mb-1 text-sm text-gray-700">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" class="w-full rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            @error('tanggal_surat') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block mb-1 text-sm text-gray-700">Nomor Surat</label>
            <input name="nomor_surat" value="{{ old('nomor_surat') }}" class="w-full rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            @error('nomor_surat') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
        </div>
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">Keterangan Isi</label>
        <input name="keterangan_isi" value="{{ old('keterangan_isi') }}" class="w-full rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
        @error('keterangan_isi') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">Tanggal Surat Masuk (Agenda)</label>
        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" class="w-full rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        @error('tanggal_masuk') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">File (PDF/JPG/PNG, maks 2MB)</label>
        <input type="file" name="file" class="w-full rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
        @error('file') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="flex gap-2">
        <button class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">Simpan</button>
        <a href="{{ route('surat-masuk.index') }}" class="rounded border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">Batal</a>
    </div>
</form>
@endsection
