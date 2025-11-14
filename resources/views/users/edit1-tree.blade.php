@extends('layouts.user-profile-wide')
@section('subtitle', trans('app.family_tree'))

@section('user-content')
<?php
$levels = [
    'child' => ['total' => 0, 'alive' => 0, 'deceased' => 0],
    'grandchild' => ['total' => 0, 'alive' => 0, 'deceased' => 0],
    'buyut' => ['total' => 0, 'alive' => 0, 'deceased' => 0],
    'canggah' => ['total' => 0, 'alive' => 0, 'deceased' => 0],
    'wareng' => ['total' => 0, 'alive' => 0, 'deceased' => 0],
    'udheg' => ['total' => 0, 'alive' => 0, 'deceased' => 0],
];

function isDeceased($person) {
    return !empty($person->dod) || !empty($person->yod);
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
<div id="wrapper">
    <span class="label">
        <span class="{{ isDeceased($user) ? 'deceased' : '' }}">
            {{ link_to_route('users.tree', $user->name, [$user->id], ['title' => $user->name.' ('.$user->gender.')']) }}
            @if(isDeceased($user))
                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
            @endif
        </span>
        <br>
        @if($user->gender_id == 1)
            @foreach($user->wifes as $wife)
                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                    {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                    @if(isDeceased($wife))
                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                    @endif
                </span>
                @if(!$loop->last), @endif
            @endforeach
        @else
            @foreach($user->husbands as $husband)
                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                    {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
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
                    $levels['child']['total']++;
                    $deceased ? $levels['child']['deceased']++ : $levels['child']['alive']++;
                ?>
                <div class="entry {{ $childsCount == 1 ? 'sole' : '' }}">
                    <span class="label">
                        <span class="{{ $deceased ? 'deceased' : '' }}">
                            {{ link_to_route('users.tree', $child->name, [$child->id], ['title' => $child->name.' ('.$child->gender.')']) }}
                            @if($deceased)
                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                            @endif
                        </span>
                        <br>
                        @if($child->gender_id == 1)
                            @foreach($child->wifes as $wife)
                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                    {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                    @if(isDeceased($wife))
                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                    @endif
                                </span>
                                @if(!$loop->last), @endif
                            @endforeach
                        @else
                            @foreach($child->husbands as $husband)
                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                    {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                    @if(isDeceased($husband))
                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                    @endif
                                </span>
                                @if(!$loop->last), @endif
                            @endforeach
                        @endif
                    </span>

                    @if ($grandsCount = $child->childs->count())
                        <div class="branch lv2">
                            @foreach($child->childs as $grand)
                                <?php
                                    $deceased = isDeceased($grand);
                                    $levels['grandchild']['total']++;
                                    $deceased ? $levels['grandchild']['deceased']++ : $levels['grandchild']['alive']++;
                                ?>
                                <div class="entry {{ $grandsCount == 1 ? 'sole' : '' }}">
                                    <span class="label">
                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                            {{ link_to_route('users.tree', $grand->name, [$grand->id], ['title' => $grand->name.' ('.$grand->gender.')']) }}
                                            @if($deceased)
                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                            @endif
                                        </span>
                                        <br>
                                        @if($grand->gender_id == 1)
                                            @foreach($grand->wifes as $wife)
                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                    {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                    @if(isDeceased($wife))
                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                    @endif
                                                </span>
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        @else
                                            @foreach($grand->husbands as $husband)
                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                    {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                    @if(isDeceased($husband))
                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                    @endif
                                                </span>
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        @endif
                                    </span>

                                    @if ($ggCount = $grand->childs->count())
                                        <div class="branch lv3">
                                            @foreach($grand->childs as $gg)
                                                <?php
                                                    $deceased = isDeceased($gg);
                                                    $levels['buyut']['total']++;
                                                    $deceased ? $levels['buyut']['deceased']++ : $levels['buyut']['alive']++;
                                                ?>
                                                <div class="entry {{ $ggCount == 1 ? 'sole' : '' }}">
                                                    <span class="label">
                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                            {{ link_to_route('users.tree', $gg->name, [$gg->id], ['title' => $gg->name.' ('.$gg->gender.')']) }}
                                                            @if($deceased)
                                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                            @endif
                                                        </span>
                                                        <br>
                                                        @if($gg->gender_id == 1)
                                                            @foreach($gg->wifes as $wife)
                                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                                    {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                    @if(isDeceased($wife))
                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                    @endif
                                                                </span>
                                                                @if(!$loop->last), @endif
                                                            @endforeach
                                                        @else
                                                            @foreach($gg->husbands as $husband)
                                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                                    {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                    @if(isDeceased($husband))
                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                    @endif
                                                                </span>
                                                                @if(!$loop->last), @endif
                                                            @endforeach
                                                        @endif
                                                    </span>

                                                    @if ($ggcCount = $gg->childs->count())
                                                        <div class="branch lv4">
                                                            @foreach($gg->childs as $ggc)
                                                                <?php
                                                                    $deceased = isDeceased($ggc);
                                                                    $levels['canggah']['total']++;
                                                                    $deceased ? $levels['canggah']['deceased']++ : $levels['canggah']['alive']++;
                                                                ?>
                                                                <div class="entry {{ $ggcCount == 1 ? 'sole' : '' }}">
                                                                    <span class="label">
                                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                                            {{ link_to_route('users.tree', $ggc->name, [$ggc->id], ['title' => $ggc->name.' ('.$ggc->gender.')']) }}
                                                                            @if($deceased)
                                                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                            @endif
                                                                        </span>
                                                                        <br>
                                                                        @if($ggc->gender_id == 1)
                                                                            @foreach($ggc->wifes as $wife)
                                                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                                                    {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                                    @if(isDeceased($wife))
                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                    @endif
                                                                                </span>
                                                                                @if(!$loop->last), @endif
                                                                            @endforeach
                                                                        @else
                                                                            @foreach($ggc->husbands as $husband)
                                                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                                                    {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                                    @if(isDeceased($husband))
                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                    @endif
                                                                                </span>
                                                                                @if(!$loop->last), @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </span>

                                                                    @if ($ggccCount = $ggc->childs->count())
                                                                        <div class="branch lv5">
                                                                            @foreach($ggc->childs as $ggcc)
                                                                                <?php
                                                                                    $deceased = isDeceased($ggcc);
                                                                                    $levels['wareng']['total']++;
                                                                                    $deceased ? $levels['wareng']['deceased']++ : $levels['wareng']['alive']++;
                                                                                ?>
                                                                                <div class="entry {{ $ggccCount == 1 ? 'sole' : '' }}">
                                                                                    <span class="label">
                                                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                                                            {{ link_to_route('users.tree', $ggcc->name, [$ggcc->id], ['title' => $ggcc->name.' ('.$ggcc->gender.')']) }}
                                                                                            @if($deceased)
                                                                                                <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                            @endif
                                                                                        </span>
                                                                                        <br>
                                                                                        @if($ggcc->gender_id == 1)
                                                                                            @foreach($ggcc->wifes as $wife)
                                                                                                <span class="{{ isDeceased($wife) ? 'deceased' : '' }}">
                                                                                                    {{ link_to_route('users.show', $wife->name, [$wife->id], ['title' => 'Istri']) }}
                                                                                                    @if(isDeceased($wife))
                                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                                    @endif
                                                                                                </span>
                                                                                                @if(!$loop->last), @endif
                                                                                            @endforeach
                                                                                        @else
                                                                                            @foreach($ggcc->husbands as $husband)
                                                                                                <span class="{{ isDeceased($husband) ? 'deceased' : '' }}">
                                                                                                    {{ link_to_route('users.show', $husband->name, [$husband->id], ['title' => 'Suami']) }}
                                                                                                    @if(isDeceased($husband))
                                                                                                        <i class="far fa-times-circle" style="color: #8B0000; font-size: 0.7em; margin-left: 3px;" title="Telah meninggal"></i>
                                                                                                    @endif
                                                                                                </span>
                                                                                                @if(!$loop->last), @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </span>

                                                                                    @if ($udhegCount = $ggcc->childs->count())
                                                                                        <div class="branch lv6">
                                                                                            @foreach($ggcc->childs as $udheg)
                                                                                                <?php
                                                                                                    $deceased = isDeceased($udheg);
                                                                                                    $levels['udheg']['total']++;
                                                                                                    $deceased ? $levels['udheg']['deceased']++ : $levels['udheg']['alive']++;
                                                                                                ?>
                                                                                                <div class="entry {{ $udhegCount == 1 ? 'sole' : '' }}">
                                                                                                    <span class="label">
                                                                                                        <span class="{{ $deceased ? 'deceased' : '' }}">
                                                                                                            {{ link_to_route('users.tree', $udheg->name, [$udheg->id], ['title' => $udheg->name.' ('.$udheg->gender.')']) }}
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
                    <div class="text-right">{{ ucfirst(str_replace('_', ' ', $label)) }}</div>
                    <div class="text-left">
                        <strong>{{ $data['alive'] }}</strong> hidup /
                        <strong>{{ $data['deceased'] }}</strong> meninggal
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection

@section('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
@endsection

@section('ext_js')
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
@endsection