@extends('layouts.app')

@section('title','Kotak Masuk Disposisi')

@section('content')
<div class="flex flex-col gap-4">
    <div class="rounded border border-gray-200 bg-white p-4">
        <div class="mb-2 text-lg font-semibold text-gray-800">Kotak Masuk Disposisi</div>
        <p class="text-sm text-gray-600">Daftar disposisi yang ditujukan ke akun ini.</p>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Agenda</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Perihal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Instruksi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($items as $d)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-800">
                            {{ $d->suratMasuk->agenda_number ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-gray-700">
                            {{ $d->suratMasuk->perihal ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-gray-700">
                            {{ $d->instruksi ?: '—' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded bg-gray-100 px-2 py-1 text-xs text-gray-700">{{ $d->status }}</span>
                            @if($d->read_at)
                                <span class="ml-2 text-xs text-gray-500">Dibaca: {{ $d->read_at }}</span>
                            @endif
                            @if($d->acted_at)
                                <span class="ml-2 text-xs text-gray-500">Ditindaklanjuti: {{ $d->acted_at }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <form method="post" action="{{ route('disposisi.update-status',$d->id) }}">
                                    @csrf
                                    <input type="hidden" name="action" value="read">
                                    <button class="rounded border border-blue-200 px-3 py-1 text-blue-700 hover:bg-blue-50"
                                        @if($d->read_at) disabled @endif>
                                        Tandai Dibaca
                                    </button>
                                </form>
                                <form method="post" action="{{ route('disposisi.update-status',$d->id) }}">
                                    @csrf
                                    <input type="hidden" name="action" value="acted">
                                    <button class="rounded border border-green-200 px-3 py-1 text-green-700 hover:bg-green-50"
                                        @if($d->acted_at) disabled @endif>
                                        Tindaklanjuti
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada disposisi untuk ditampilkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        {{ $items->links() }}
    </div>
</div>
@endsection
