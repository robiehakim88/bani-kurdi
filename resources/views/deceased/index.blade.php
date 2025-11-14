@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default text-center">
            <div class="panel-heading text-left">
                <h3 class="panel-title">Daftar Anggota Keluarga yang Telah Meninggal</h3>
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Nama</td>
                        <td>Tanggal Meninggal</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse($deceasedUsers as $key => $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="text-left">
                            <!-- Gunakan profileLink() untuk mengarahkan ke halaman profil -->
                            {!! $user->profileLink() !!}
                        </td>
                        <td>
                            @if($user->dod)
            {{ \Carbon\Carbon::parse($user->dod)->format('d M Y') }}
        @else
            Tahun {{ $user->yod }}
        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted">Tidak ada data anggota keluarga yang telah meninggal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection