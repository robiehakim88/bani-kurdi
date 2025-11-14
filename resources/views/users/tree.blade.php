@extends('layouts.user-profile-wide')
@section('subtitle', trans('app.family_tree'))

@section('user-content')
<?php
$levels = [
    'anak' => ['total' => 0, 'alive' => 0, 'deceased' => 0, 'spouses_alive' => 0, 'spouses_deceased' => 0],
    'cucu' => ['total' => 0, 'alive' => 0, 'deceased' => 0, 'spouses_alive' => 0, 'spouses_deceased' => 0],
    'buyut' => ['total' => 0, 'alive' => 0, 'deceased' => 0, 'spouses_alive' => 0, 'spouses_deceased' => 0],
    'canggah' => ['total' => 0, 'alive' => 0, 'deceased' => 0, 'spouses_alive' => 0, 'spouses_deceased' => 0],
    'wareng' => ['total' => 0, 'alive' => 0, 'deceased' => 0, 'spouses_alive' => 0, 'spouses_deceased' => 0],
    'udheg' => ['total' => 0, 'alive' => 0, 'deceased' => 0, 'spouses_alive' => 0, 'spouses_deceased' => 0],
];

function isDeceased($person) {
    return !empty($person->dod) || !empty($person->yod);
}

function countSpouses($person, &$aliveCount, &$deceasedCount) {
    foreach ($person->couples as $spouse) {
        if (isDeceased($spouse)) {
            $deceasedCount++;
        } else {
            $aliveCount++;
        }
    }
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

<div id="wrapper">
    <span class="label">
        <span class="{{ isDeceased($user) ? 'deceased' : '' }}">
            @if($user->photo_path)
                <span class="photo-hover" data-photo="{{ Storage::url($user->photo_path) }}" data-name="{{ $user->name }}">
                    {{ link_to_route('users.tree', $user->name, [$user->id], ['title' => $user->name.' ('.$user->gender.')']) }}
                </span>
            @else
                {{ link_to_route('users.tree', $user->name, [$user->id], ['title' => $user->name.' ('.$user->gender.')']) }}
            @endif
            @if(isDeceased($user))
                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
            @endif
        </span>
        <br>
        @if($user->gender_id == 1)
            @foreach($user->wifes as $wife)
                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                    @if($wife->photo_path)
                        <span class="photo-hover" data-photo="{{ Storage::url($wife->photo_path) }}" data-name="{{ $wife->name }}">
                            {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                        </span>
                    @else
                        {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                    @endif
                    @if(isDeceased($wife))
                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                    @endif
                </span>
                @if(!$loop->last), @endif
            @endforeach
        @else
            @foreach($user->husbands as $husband)
                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                    @if($husband->photo_path)
                        <span class="photo-hover" data-photo="{{ Storage::url($husband->photo_path) }}" data-name="{{ $husband->name }}">
                            {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                        </span>
                    @else
                        {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                    @endif
                    @if(isDeceased($husband))
                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                    @endif
                </span>
                @if(!$loop->last), @endif
            @endforeach
        @endif
    </span>

    @if ($childsCount = $user->childs->count())
        <div class="branch lv1">
            @foreach($user->childs as $child)
                <?php
                    $deceased = isDeceased($child);
                    $levels['anak']['total']++;
                    $deceased ? $levels['anak']['deceased']++ : $levels['anak']['alive']++;
                    countSpouses($child, $levels['anak']['spouses_alive'], $levels['anak']['spouses_deceased']);
                ?>
                <div class="entry {{ $childsCount == 1 ? 'sole' : '' }}">
                    <span class="label">
                        <span class="{{ $deceased ? 'deceased' : '' }}">
                            @if($child->photo_path)
                                <span class="photo-hover" data-photo="{{ Storage::url($child->photo_path) }}" data-name="{{ $child->name }}">
                                    {{ link_to_route('users.tree', $child->name, [$child->id], ['title' => $child->name.' ('.$child->gender.')']) }}
                                </span>
                            @else
                                {{ link_to_route('users.tree', $child->name, [$child->id], ['title' => $child->name.' ('.$child->gender.')']) }}
                            @endif
                            @if($deceased)
                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                            @endif
                        </span>
                        <br>
                        @if($child->gender_id == 1)
                            @foreach($child->wifes as $wife)
                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                    @if($wife->photo_path)
                                        <span class="photo-hover" data-photo="{{ Storage::url($wife->photo_path) }}" data-name="{{ $wife->name }}">
                                            {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                        </span>
                                    @else
                                        {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                    @endif
                                    @if(isDeceased($wife))
                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                    @endif
                                </span>
                                @if(!$loop->last), @endif
                            @endforeach
                        @else
                            @foreach($child->husbands as $husband)
                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                    @if($husband->photo_path)
                                        <span class="photo-hover" data-photo="{{ Storage::url($husband->photo_path) }}" data-name="{{ $husband->name }}">
                                            {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                        </span>
                                    @else
                                        {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                    @endif
                                    @if(isDeceased($husband))
                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                    @endif
                                </span>
                                @if(!$loop->last), @endif
                            @endforeach
                        @endif
                    </span>

                    {{-- Level: Cucu --}}
                    @if ($grandsCount = $child->childs->count())
                        <div class="branch lv2">
                            @foreach($child->childs as $grand)
                                <?php
                                    $deceased = isDeceased($grand);
                                    $levels['cucu']['total']++;
                                    $deceased ? $levels['cucu']['deceased']++ : $levels['cucu']['alive']++;
                                    countSpouses($grand, $levels['cucu']['spouses_alive'], $levels['cucu']['spouses_deceased']);
                                ?>
                                <div class="entry {{ $grandsCount == 1 ? 'sole' : '' }}">
                                    <span class="label">
                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                            @if($grand->photo_path)
                                                <span class="photo-hover" data-photo="{{ Storage::url($grand->photo_path) }}" data-name="{{ $grand->name }}">
                                                    {{ link_to_route('users.tree', $grand->name, [$grand->id], ['title' => $grand->name.' ('.$grand->gender.')']) }}
                                                </span>
                                            @else
                                                {{ link_to_route('users.tree', $grand->name, [$grand->id], ['title' => $grand->name.' ('.$grand->gender.')']) }}
                                            @endif
                                            @if($deceased)
                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                            @endif
                                        </span>
                                        <br>
                                        {{-- Pasangan --}}
                                        @if($grand->gender_id == 1)
                                            @foreach($grand->wifes as $wife)
                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                    @if($wife->photo_path)
                                                        <span class="photo-hover" data-photo="{{ Storage::url($wife->photo_path) }}" data-name="{{ $wife->name }}">
                                                            {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                        </span>
                                                    @else
                                                        {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                    @endif
                                                    @if(isDeceased($wife))
                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                    @endif
                                                </span>
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        @else
                                            @foreach($grand->husbands as $husband)
                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                    @if($husband->photo_path)
                                                        <span class="photo-hover" data-photo="{{ Storage::url($husband->photo_path) }}" data-name="{{ $husband->name }}">
                                                            {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                        </span>
                                                    @else
                                                        {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                    @endif
                                                    @if(isDeceased($husband))
                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                    @endif
                                                </span>
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        @endif
                                    </span>

                                    {{-- Level: Buyut --}}
                                    @if ($ggCount = $grand->childs->count())
                                        <div class="branch lv3">
                                            @foreach($grand->childs as $gg)
                                                <?php
                                                    $deceased = isDeceased($gg);
                                                    $levels['buyut']['total']++;
                                                    $deceased ? $levels['buyut']['deceased']++ : $levels['buyut']['alive']++;
                                                    countSpouses($gg, $levels['buyut']['spouses_alive'], $levels['buyut']['spouses_deceased']);
                                                ?>
                                                <div class="entry {{ $ggCount == 1 ? 'sole' : '' }}">
                                                    <span class="label">
                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                            @if($gg->photo_path)
                                                                <span class="photo-hover" data-photo="{{ Storage::url($gg->photo_path) }}" data-name="{{ $gg->name }}">
                                                                    {{ link_to_route('users.tree', $gg->name, [$gg->id], ['title' => $gg->name.' ('.$gg->gender.')']) }}
                                                                </span>
                                                            @else
                                                                {{ link_to_route('users.tree', $gg->name, [$gg->id], ['title' => $gg->name.' ('.$gg->gender.')']) }}
                                                            @endif
                                                            @if($deceased)
                                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                            @endif
                                                        </span>
                                                        <br>
                                                        @if($gg->gender_id == 1)
                                                            @foreach($gg->wifes as $wife)
                                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                                    @if($wife->photo_path)
                                                                        <span class="photo-hover" data-photo="{{ Storage::url($wife->photo_path) }}" data-name="{{ $wife->name }}">
                                                                            {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                        </span>
                                                                    @else
                                                                        {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                    @endif
                                                                    @if(isDeceased($wife))
                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                    @endif
                                                                </span>
                                                                @if(!$loop->last), @endif
                                                            @endforeach
                                                        @else
                                                            @foreach($gg->husbands as $husband)
                                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                                    @if($husband->photo_path)
                                                                        <span class="photo-hover" data-photo="{{ Storage::url($husband->photo_path) }}" data-name="{{ $husband->name }}">
                                                                            {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                        </span>
                                                                    @else
                                                                        {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                    @endif
                                                                    @if(isDeceased($husband))
                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                    @endif
                                                                </span>
                                                                @if(!$loop->last), @endif
                                                            @endforeach
                                                        @endif
                                                    </span>

                                                    {{-- Level: Canggah --}}
                                                    @if ($ggcCount = $gg->childs->count())
                                                        <div class="branch lv4">
                                                            @foreach($gg->childs as $ggc)
                                                                <?php
                                                                    $deceased = isDeceased($ggc);
                                                                    $levels['canggah']['total']++;
                                                                    $deceased ? $levels['canggah']['deceased']++ : $levels['canggah']['alive']++;
                                                                    countSpouses($ggc, $levels['canggah']['spouses_alive'], $levels['canggah']['spouses_deceased']);
                                                                ?>
                                                                <div class="entry {{ $ggcCount == 1 ? 'sole' : '' }}">
                                                                    <span class="label">
                                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                                            @if($ggc->photo_path)
                                                                                <span class="photo-hover" data-photo="{{ Storage::url($ggc->photo_path) }}" data-name="{{ $ggc->name }}">
                                                                                    {{ link_to_route('users.tree', $ggc->name, [$ggc->id], ['title' => $ggc->name.' ('.$ggc->gender.')']) }}
                                                                                </span>
                                                                            @else
                                                                                {{ link_to_route('users.tree', $ggc->name, [$ggc->id], ['title' => $ggc->name.' ('.$ggc->gender.')']) }}
                                                                            @endif
                                                                            @if($deceased)
                                                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                            @endif
                                                                        </span>
                                                                        <br>
                                                                        @if($ggc->gender_id == 1)
                                                                            @foreach($ggc->wifes as $wife)
                                                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                                                    @if($wife->photo_path)
                                                                                        <span class="photo-hover" data-photo="{{ Storage::url($wife->photo_path) }}" data-name="{{ $wife->name }}">
                                                                                            {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                                        </span>
                                                                                    @else
                                                                                        {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                                    @endif
                                                                                    @if(isDeceased($wife))
                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                    @endif
                                                                                </span>
                                                                                @if(!$loop->last), @endif
                                                                            @endforeach
                                                                        @else
                                                                            @foreach($ggc->husbands as $husband)
                                                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                                                    @if($husband->photo_path)
                                                                                        <span class="photo-hover" data-photo="{{ Storage::url($husband->photo_path) }}" data-name="{{ $husband->name }}">
                                                                                            {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                                        </span>
                                                                                    @else
                                                                                        {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                                    @endif
                                                                                    @if(isDeceased($husband))
                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                    @endif
                                                                                </span>
                                                                                @if(!$loop->last), @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </span>

                                                                    {{-- Level: Wareng --}}
                                                                    @if ($ggccCount = $ggc->childs->count())
                                                                        <div class="branch lv5">
                                                                            @foreach($ggc->childs as $ggcc)
                                                                                <?php
                                                                                    $deceased = isDeceased($ggcc);
                                                                                    $levels['wareng']['total']++;
                                                                                    $deceased ? $levels['wareng']['deceased']++ : $levels['wareng']['alive']++;
                                                                                    countSpouses($ggcc, $levels['wareng']['spouses_alive'], $levels['wareng']['spouses_deceased']);
                                                                                ?>
                                                                                <div class="entry {{ $ggccCount == 1 ? 'sole' : '' }}">
                                                                                    <span class="label">
                                                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                                                            @if($ggcc->photo_path)
                                                                                                <span class="photo-hover" data-photo="{{ Storage::url($ggcc->photo_path) }}" data-name="{{ $ggcc->name }}">
                                                                                                    {{ link_to_route('users.tree', $ggcc->name, [$ggcc->id], ['title' => $ggcc->name.' ('.$ggcc->gender.')']) }}
                                                                                                </span>
                                                                                            @else
                                                                                                {{ link_to_route('users.tree', $ggcc->name, [$ggcc->id], ['title' => $ggcc->name.' ('.$ggcc->gender.')']) }}
                                                                                            @endif
                                                                                            @if($deceased)
                                                                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                            @endif
                                                                                        </span>
                                                                                        <br>
                                                                                        @if($ggcc->gender_id == 1)
                                                                                            @foreach($ggcc->wifes as $wife)
                                                                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                                                                    @if($wife->photo_path)
                                                                                                        <span class="photo-hover" data-photo="{{ Storage::url($wife->photo_path) }}" data-name="{{ $wife->name }}">
                                                                                                            {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                                                        </span>
                                                                                                    @else
                                                                                                        {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                                                    @endif
                                                                                                    @if(isDeceased($wife))
                                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                                    @endif
                                                                                                </span>
                                                                                                @if(!$loop->last), @endif
                                                                                            @endforeach
                                                                                        @else
                                                                                            @foreach($ggcc->husbands as $husband)
                                                                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                                                                    @if($husband->photo_path)
                                                                                                        <span class="photo-hover" data-photo="{{ Storage::url($husband->photo_path) }}" data-name="{{ $husband->name }}">
                                                                                                            {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                                                        </span>
                                                                                                    @else
                                                                                                        {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                                                    @endif
                                                                                                    @if(isDeceased($husband))
                                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                                    @endif
                                                                                                </span>
                                                                                                @if(!$loop->last), @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </span>

                                                                                    {{-- Level: Udheg --}}
                                                                                    @if ($udhegCount = $ggcc->childs->count())
                                                                                        <div class="branch lv6">
                                                                                            @foreach($ggcc->childs as $udheg)
                                                                                                <?php
                                                                                                    $deceased = isDeceased($udheg);
                                                                                                    $levels['udheg']['total']++;
                                                                                                    $deceased ? $levels['udheg']['deceased']++ : $levels['udheg']['alive']++;
                                                                                                    countSpouses($udheg, $levels['udheg']['spouses_alive'], $levels['udheg']['spouses_deceased']);
                                                                                                ?>
                                                                                                <div class="entry {{ $udhegCount == 1 ? 'sole' : '' }}">
                                                                                                    <span class="label">
                                                                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                                                                            @if($udheg->photo_path)
                                                                                                                <span class="photo-hover" data-photo="{{ Storage::url($udheg->photo_path) }}" data-name="{{ $udheg->name }}">
                                                                                                                    {{ link_to_route('users.tree', $udheg->name, [$udheg->id], ['title' => $udheg->name.' ('.$udheg->gender.')']) }}
                                                                                                                </span>
                                                                                                            @else
                                                                                                                {{ link_to_route('users.tree', $udheg->name, [$udheg->id], ['title' => $udheg->name.' ('.$udheg->gender.')']) }}
                                                                                                            @endif
                                                                                                            @if($deceased)
                                                                                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                                            @endif
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="container">
    <hr>
    <div class="row">
        @foreach($levels as $label => $data)
            @if($data['total'] > 0)
                <div class="col-md-2">
                    <div class="text-left"><strong>{{ ucfirst(str_replace('_', ' ', $label)) }}:</strong></div>
                    <div class="text-left">
                        <strong>{{ $data['alive'] }}</strong> hidup /
                        <strong>{{ $data['deceased'] }}</strong> meninggal
                        @if($data['spouses_alive'] + $data['spouses_deceased'] > 0)
                            <br>
                            <strong>{{ ucfirst(str_replace('_', ' ', $label)) }} Menantu:</strong><br />
                            <strong>{{ $data['spouses_alive'] }}</strong> hidup /
                            <strong>{{ $data['spouses_deceased'] }}</strong> meninggal
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- Tooltip Global --}}
<div id="global-photo-tooltip" style="display: none; position: fixed; z-index: 9999; background: white; border: 1px solid #ccc; border-radius: 6px; padding: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.25); text-align: center;">
    <div id="global-tooltip-name" style="font-size: 12px; font-weight: bold; margin-bottom: 4px;"></div>
    <img id="global-tooltip-img" src="" style="max-width: 120px; height: auto; display: block; border-radius: 4px;">
</div>
@endsection

@section('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
@endsection

@section('ext_js')
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltip = document.getElementById('global-photo-tooltip');
    const tooltipImg = document.getElementById('global-tooltip-img');
    const tooltipName = document.getElementById('global-tooltip-name');

    document.querySelectorAll('.photo-hover').forEach(el => {
        el.addEventListener('mouseenter', function (e) {
            const photoUrl = this.getAttribute('data-photo');
            const name = this.getAttribute('data-name');
            const rect = this.getBoundingClientRect();

            tooltipImg.src = photoUrl;
            tooltipName.textContent = name;
            tooltip.style.left = (rect.left + window.scrollX + rect.width / 2 - 60) + 'px';
            tooltip.style.top = (rect.top + window.scrollY - 140) + 'px';
            tooltip.style.display = 'block';
        });

        el.addEventListener('mouseleave', function () {
            tooltip.style.display = 'none';
        });
    });
});
</script>
@endsection