@extends('layouts.app')

@section('title','Surat Masuk')

@section('content')
<div class="flex flex-col gap-4">
    <div class="flex flex-col gap-3 md:flex-row md:items-center">
        <form method="get" class="flex flex-1 flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari perihal/pengirim/agenda..."
                   class="w-full md:w-64 rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <input type="date" name="from" value="{{ request('from') }}"
                   class="rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <input type="date" name="to" value="{{ request('to') }}"
                   class="rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Filter</button>
        </form>
        <a href="{{ route('surat-masuk.create') }}"
           class="inline-flex items-center justify-center rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
            + Tambah
        </a>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Agenda</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Pengirim</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Perihal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($items as $i)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-800">{{ $i->agenda_number }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ \Illuminate\Support\Carbon::parse($i->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $i->pengirim }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $i->perihal }}</td>
                        <td class="px-4 py-3">
                            <a class="text-blue-600 hover:text-blue-700" href="{{ route('surat-masuk.show',$i->id) }}">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data surat masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        {{ $items->withQueryString()->links() }}
    </div>
</div>
@endsection
