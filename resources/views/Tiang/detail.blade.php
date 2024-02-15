@extends('layouts.app')

@section('css')
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700" rel="stylesheet" />

    <link rel="stylesheet" href="{{ URL::asset('assets/test/css/style.css') }}" />
    <style>
        input[type='checkbox'],
        input[type='radio'] {
            min-width: 16px !important;
            margin-right: 12px;
        }
        a[href='#finish'] {
            display: none !important;
        }

        input[type='radio'] {
            border-radius: 50% !important;
        }

        .fw-400 {
            font-weight: 400 !important;
        }

        input[type='file'],
        table input {
            margin: 0px !important;
        }

        table label {
            font-size: 14px !important;
            font-weight: 400 !important;
            margin-left: 10px !important;
            margin-bottom: 0px !important
        }

        th {
            font-size: 14px !important;
        }

        th,
        td {
            padding: 6px 16px !important
        }

        table,
        input[type='file'] {
            width: 90% !important;
        }

        table input[type="file"] {
            font-size: 11px !important;
            height: 33px !important;
        }

        td.d-flex {
            border-bottom: 0px !important;
            border-left: 0px !important;
            border-right: 0px !important;
        }

        textarea {
            border: 1px solid #999999 !important;
        }

        span.number {
            display: none
        }
    </style>
@endsection


@section('content')
    <section class="content-header">
        <div class="container-  ">
            <div class="row " style="flex-wrap:nowrap">
                <div class="col-sm-6">
                    <h3>{{ __('messages.tiang') }} </h3>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a
                                href="{{ route('tiang-talian-vt-and-vr.index', app()->getLocale()) }}">{{ __('messages.index') }}
                            </a></li>
                        <li class="breadcrumb-item active">{{ __('messages.deatil') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class=" ">

        <div class="container">

            <div class=" ">

                <div class=" card col-md-12 p-3 ">
                    <div class=" ">
                        <h3 class="text-center p-2">{{ __('messages.qr_savr') }} </h3>
                        <form id="framework-wizard-form" action="#" style="display: none">

                            <h3>{{ __('messages.info') }} </h3>

                            {{-- START Info (1) --}}
                            <fieldset class=" form-input">


                                <div class="row">
                                    <div class="col-md-4"><label for="ba">{{ __('messages.ba') }}</label></div>
                                    <div class="col-md-4">
                                        <input class="form-control" value="{{ $data->ba }}" disabled>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="fp_name">{{ __('messages.name_of_substation') }} / {{ __('messages.Name_of_Feeder_Pillar') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled value="{{ $data->fp_name }}" id="fp_name" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="fp_road">{{ __('messages.Feeder_Name') }} / {{ __('messages.Street_Name') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input value="{{ $data->fp_road }}" disabled class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="">{{ __('messages.Section') }} </label></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="section_from">{{ __('messages.from') }} </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled value="{{ $data->section_from }}" class="form-control"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="section_to">{{ __('messages.to') }}</label></div>
                                    <div class="col-md-4">
                                        <input disabled value="{{ $data->section_to }}"class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="tiang_no">{{ __('messages.Tiang_No') }}</label></div>
                                    <div class="col-md-4">
                                        <input disabled value="{{ $data->tiang_no }}" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="review_date">{{__('messages.visit_date')}}</label></div>
                                    <div class="col-md-4">
                                        <input type="date"disabled value="{{ $data->review_date }}"   class="form-control" required>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="main_line">{{__('messages.main_line_service_line')}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="talian_utama_connection" id="main_line" class="form-control"   disabled>
                                            <option value="{{$data->talian_utama_connection ?? ''}}" hidden>{{$data->talian_utama_connection ?? 'select'}}</option>
                                            <option value="main_line">Main Line</option>
                                            <option value="service_line">Service Line</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row " >
                                    <div class="col-md-4">
                                        <label for="">  Number of Services Involves 1 user only </label>
                                    </div>
                                    <div class="col-md-2 d-flex mt-2">
                                        <input type="number" disabled  value="{{$data->talian_utama}}"  >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pole_image-1">{{ __('messages.pole') }} Image 1</label>
                                    </div>


                                    <div class="col-md-4 p-2">
                                        @if ($data->pole_image_1 != '' && file_exists(public_path($data->pole_image_1)))
                                            <a href="{{ URL::asset($data->pole_image_1) }}" data-lightbox="roadtrip">
                                                <img src="{{ URL::asset($data->pole_image_1) }}" alt=""
                                                    class="adjust-height " style="height:30px; width:30px !important">
                                            </a>
                                        @else
                                            <strong>{{ __('messages.no_image_found') }} </strong>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="pole_image-2">{{ __('messages.pole') }} Image
                                            2</label>
                                    </div>

                                    <div class="col-md-4 p-2">
                                        @if ($data->pole_image_2 != '' && file_exists(public_path($data->pole_image_2)))
                                            <a href="{{ URL::asset($data->pole_image_2) }}" data-lightbox="roadtrip">
                                                <img src="{{ URL::asset($data->pole_image_2) }}" alt=""
                                                    class="adjust-height " style="height:30px; width:30px !important">
                                            </a>
                                        @else
                                            <strong>{{ __('messages.no_image_found') }} </strong>
                                        @endif
                                    </div>
                                </div>




                            </fieldset>
                            {{-- END Info (1) --}}
                            <h3>{{ __('messages.Asset_Register') }} </h3>

                            {{-- START Asset Register (2) --}}


                            <fieldset class="form-input">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card p-4">
                                            <label for="st7"> {{ __('messages.Pole_Size_Bill') }} </label>
                                            <div class="row">

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="size_tiang" value="st7" id="st7" {{ $data->size_tiang == '7.5' ? 'checked' : '' }} disabled>
                                                    <label for="st7" class="fw-400"> 7.5</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="size_tiang" value="st9" id="st9" {{ $data->size_tiang == '9' ? 'checked' : '' }} disabled >
                                                    <label for="st9" class="fw-400"> 9</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="size_tiang" value="st10" id="st10" {{ $data->size_tiang == '10' ? 'checked' : '' }}disabled>
                                                    <label for="st10" class="fw-400"> 10</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card p-4">
                                            <label for="">{{ __('messages.Pole_type_No') }} </label>
                                            <div class="row">
                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="jenis_tiang" value="spun id="spun" {{ $data->jenis_tiang == 'spun' ? 'checked' : '' }} disabled>
                                                    <label for="spun" class="fw-400">{{ __('messages.Spun') }}</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="jenis_tiang" value="concrete" id="concrete" {{ $data->jenis_tiang == 'concrete' ? 'checked' : '' }} disabled>
                                                    <label for="concrete"class="fw-400">{{ __('messages.Concrete') }}</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="jenis_tiang" value="iron" id="iron" {{ $data->jenis_tiang == 'iron' ? 'checked' : '' }} disabled>
                                                    <label for="iron" class="fw-400">{{ __('messages.Iron') }}</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="jenis_tiang" value="wood" id="wood" {{ $data->jenis_tiang == 'wood' ? 'checked' : '' }} disabled>
                                                    <label for="wood" class="fw-400">{{ __('messages.Wood') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="card p-4">

                                            <label for="section_to">{{ __('messages.ABC_Span') }} 3 X 185</label>
                                                {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's3_185',  false) !!}

                                            <label for="s3_95">{{ __('messages.ABC_Span') }} 3 X 95</label>
                                                {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's3_95',  false) !!}

                                            <label for="s3_16">{{ __('messages.ABC_Span') }} 3 X 16</label>
                                                {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's3_16',  false) !!}


                                            <label for="s1_16">{{ __('messages.ABC_Span') }}1 X 16</label>
                                                {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's1_16',  false) !!}

                                        </div>
                                    </div>


                                    <div class="col-md-6 ">
                                        <div class="card p-4">

                                            <label for="s19_064">{{ __('messages.PVC_Span') }} 19/064</label>
                                                {!! tiangSpanRadio(    $data->pvc_span, 'pvc_span', 's19_064',  false) !!}

                                            <label for="s7_083"  >{{ __('messages.PVC_Span') }}7/083</label>
                                                {!! tiangSpanRadio($data->pvc_span, 'pvc_span', 's7_083',  false) !!}

                                            <label for="s7_044"  >{{ __('messages.PVC_Span') }}7/044</label>
                                                {!! tiangSpanRadio(  $data->pvc_span, 'pvc_span', 's7_044',  false) !!}

                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="card p-4">

                                            <label for="s7_173">{{ __('messages.BARE_Span') }} 7/173</label>
                                                {!! tiangSpanRadio(  $data->bare_span, 'bare_span', 's7_173',  false) !!}

                                            <label for="s7_122">{{ __('messages.BARE_Span') }} 7/122</label>
                                                {!! tiangSpanRadio(  $data->bare_span, 'bare_span', 's7_122',  false) !!}

                                            <label for="s3_132">{{ __('messages.BARE_Span') }} 3/132</label>
                                                {!! tiangSpanRadio(  $data->bare_span, 'bare_span', 's3_132',  false) !!}

                                        </div>
                                    </div>




                                </div>

                            </fieldset>

                            {{-- END Asset Register (2) --}}

                            <h3>{{ __('messages.kejanggalan') }} </h3>
                            <fieldset class="form-input">


                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead style="background-color: #E4E3E3 !important">
                                            <th class="col-4">{{ __('messages.title') }}</th>
                                            <th class="col-4">{{ __('messages.defects') }}</th>
                                            <th class="col-3">{{ __('messages.images') }}</th>

                                        </thead>
                                        {{-- POLE --}}
                                        <tr>
                                            <th rowspan="6">{{ __('messages.pole') }}</th>

                                            {!! getImageShow('cracked', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'cracked') !!}

                                        </tr>
                                        <tr>
                                            {!! getImageShow('leaning', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'leaning') !!}

                                        </tr>


                                        <tr>
                                            {!! getImageShow('dim', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'no_dim_post_none') !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow('creepers', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'creepers') !!}

                                        </tr>
                                        <tr>
                                            {!! getImageShow('current_leakage', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'current_leakage') !!}
                                        </tr>


                                        <tr>
                                            {!! getImageShow('other', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'others') !!}

                                        </tr>

                                        {{-- Line (Main / Service) --}}

                                        <tr>
                                            <th rowspan="4">{{ __('messages.line_main_service') }}</th>
                                            {!! getImageShow('joint', $data->talian_defect, 'talian_defect', $data->talian_defect_image, 'joint') !!}


                                        </tr>
                                        <tr>
                                            {!! getImageShow(
                                                'need_rentis',
                                                $data->talian_defect,
                                                'talian_defect',
                                                $data->talian_defect_image,
                                                'need_rentis',
                                            ) !!}


                                        </tr>

                                        <tr>
                                            {!! getImageShow(
                                                'ground',
                                                $data->talian_defect,
                                                'talian_defect',
                                                $data->talian_defect_image,
                                                'Does_Not_Comply_With_Ground_Clearance',
                                            ) !!}

                                        </tr>

                                        <tr>

                                            {!! getImageShow('other', $data->talian_defect, 'talian_defect', $data->talian_defect_image, 'others') !!}

                                        </tr>


                                        {{-- Umbang --}}

                                        <tr>
                                            <th rowspan="6">{{ __('messages.Umbang') }}</th>
                                            {!! getImageShow(
                                                'breaking',
                                                $data->umbang_defect,
                                                'umbang_defect',
                                                $data->umbang_defect_image,
                                                'Sagging_Breaking',
                                            ) !!}

                                        </tr>
                                        <tr>
                                            {!! getImageShow('creepers', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'Creepers') !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow(
                                                'cracked',
                                                $data->umbang_defect,
                                                'umbang_defect',
                                                $data->umbang_defect_image,
                                                'No_Stay_Insulator_Damaged',
                                            ) !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow(
                                                'stay_palte',
                                                $data->umbang_defect,
                                                'umbang_defect',
                                                $data->umbang_defect_image,
                                                'Stay_Plate_Base_Stay_Blocked',
                                            ) !!}

                                        </tr>
                                        <tr>
                                            {!! getImageShow('current_leakage', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'current_leakage') !!}
                                        </tr>

                                        <tr>
                                            {!! getImageShow('other', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'others') !!}

                                        </tr>


                                        {{-- IPC --}}
                                        <tr>
                                            <th rowspan="2">{{ __('messages.IPC') }}</th>

                                            {!! getImageShow('burn', $data->ipc_defect, 'ipc_defect', $data->ipc_defect_image, 'Burn Effect') !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow('other', $data->ipc_defect, 'ipc_defect', $data->ipc_defect_image, 'others') !!}

                                        </tr>

                                        {{-- Black Box --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.Black_Box') }}</th>

                                            {!! getImageShow(
                                                'cracked',
                                                $data->blackbox_defect,
                                                'blackbox_defect',
                                                $data->blackbox_defect_image,
                                                'Kesan_Bakar',
                                            ) !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow('other', $data->blackbox_defect, 'blackbox_defect', $data->blackbox_defect_image, 'others') !!}

                                        </tr>

                                        {{-- Jumper --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.jumper') }}</th>
                                            {!! getImageShow('sleeve', $data->jumper, 'jumper', $data->jumper_image, 'no_uv_sleeve') !!}

                                        </tr>
                                        <tr>
                                            {!! getImageShow('burn', $data->jumper, 'jumper', $data->jumper_image, 'Burn Effect') !!}

                                        </tr>


                                        <tr>
                                            {!! getImageShow('other', $data->jumper, 'jumper', $data->jumper_image, 'others') !!}

                                        </tr>

                                        {{-- Lightning catcher --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.lightning_catcher') }}</th>

                                            {!! getImageShow('broken', $data->kilat_defect, 'kilat_defect', $data->kilat_defect_image, 'broken') !!}

                                        </tr>

                                        <tr>

                                            {!! getImageShow('other', $data->kilat_defect, 'kilat_defect', $data->kilat_defect_image, 'others') !!}

                                        </tr>

                                        {{-- Service --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.Service') }}</th>

                                            {!! getImageShow(
                                                'roof',
                                                $data->servis_defect,
                                                'servis_defect',
                                                $data->servis_defect_image,
                                                'the_service_line_is_on_the_roof',
                                            ) !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow(
                                                'won_piece',
                                                $data->servis_defect,
                                                'servis_defect',
                                                $data->servis_defect_image,
                                                'won_piece_date',
                                            ) !!}


                                        </tr>

                                        <tr>
                                            {!! getImageShow('other', $data->servis_defect, 'servis_defect', $data->servis_defect_image, 'others') !!}

                                        </tr>


                                        {{-- Grounding --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.grounding') }}</th>

                                            {!! getImageShow(
                                                'netural',
                                                $data->pembumian_defect,
                                                'pembumian_defect',
                                                $data->pembumian_defect_image,
                                                'no_connection_to_neutral',
                                            ) !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow('other', $data->pembumian_defect, 'pembumian_defect', $data->pembumian_defect_image, 'others') !!}

                                        </tr>

                                        {{-- Signage - OFF Point / Two Way Supply --}}
                                        <tr>
                                            <th rowspan="2">{{ __('messages.signage_off_point_two_way_supply') }}</th>

                                            {!! getImageShow(
                                                'damage',
                                                $data->bekalan_dua_defect,
                                                'bekalan_dua_defect',
                                                $data->bekalan_dua_defect_image,
                                                'faded_damaged_missing_signage',
                                            ) !!}

                                        </tr>

                                        <tr>
                                            {!! getImageShow(
                                                'other',
                                                $data->bekalan_dua_defect,
                                                'bekalan_dua_defect',
                                                $data->bekalan_dua_defect_image,
                                                'others',
                                            ) !!}

                                        </tr>

                                        {{-- Main Street --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.main_street') }}</th>

                                            {!! getImageShow(
                                                'date_wire',
                                                $data->kaki_lima_defect,
                                                'kaki_lima_defect',
                                                $data->kaki_lima_defect_image,
                                                'date_wire',
                                            ) !!}

                                        </tr>
                                        <tr>
                                            {!! getImageShow(
                                                'burn',
                                                $data->kaki_lima_defect,
                                                'kaki_lima_defect',
                                                $data->kaki_lima_defect_image,
                                                'junction_box_date_burn_effect',
                                            ) !!}

                                        </tr>
                                        <tr>
                                            {!! getImageShow('other', $data->kaki_lima_defect, 'kaki_lima_defect', $data->kaki_lima_defect_image, 'others') !!}

                                        </tr>
                                    </table>
                                </div>

                            </fieldset>




                            <h3>{{ __('messages.Heigh_Clearance') }} </h3>
                            {{-- START Heigh Clearance (4) --}}

                            <fieldset class="form-input">
                                <h3>{{ __('messages.Heigh_Clearance') }}</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead style="background-color: #E4E3E3 !important">
                                            <th class="col-4">{{ __('messages.title') }}</th>
                                            <th class="col-4">{{ __('messages.defects') }}</th>
                                            <th class="col-3">{{ __('messages.images') }}</th>

                                        </thead>

                                        <tbody>

                                            {{-- Site Conditions --}}

                                            <tr>
                                                <th rowspan="3">{{ __('messages.Site_Conditions') }}</th>
                                                <td class="d-flex">
                                                    <input type="checkbox" name="tapak_condition[road]" id="site_road"
                                                        disabled class="form-check"
                                                        {{ checkCheckBox('road', $data->tapak_condition) }}>
                                                    <label for="site_road">{{ __('messages.Crossing_the_Road') }}</label>
                                                </td>

                                                <td>
                                                    @if ($data->tapak_road_img != '' && file_exists(public_path($data->tapak_road_img)))
                                                        <a href="{{ URL::asset($data->tapak_road_img) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ URL::asset($data->tapak_road_img) }}"
                                                                alt="" class="adjust-height "
                                                                style="height:30px; width:30px !important">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tapak_condition[side_walk]"disabled
                                                        id="side_walk" class="form-check"
                                                        {{ checkCheckBox('side_walk', $data->tapak_condition) }}>
                                                    <label for="side_walk">{{ __('messages.Sidewalk') }}</label>
                                                </td>

                                                <td>
                                                    @if ($data->tapak_sidewalk_img != '' && file_exists(public_path($data->tapak_sidewalk_img)))
                                                        <a href="{{ URL::asset($data->tapak_sidewalk_img) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ URL::asset($data->tapak_sidewalk_img) }}"
                                                                alt="" class="adjust-height "
                                                                style="height:30px; width:30px !important">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tapak_condition[vehicle_entry]" disabled
                                                        id="vehicle_entry" class="form-check"
                                                        {{ checkCheckBox('vehicle_entry', $data->tapak_condition) }}>
                                                    <label for="vehicle_entry">{{ __('messages.No_vehicle_entry_area') }}
                                                    </label>
                                                </td>

                                                <td>
                                                    @if ($data->tapak_no_vehicle_entry_img != '' && file_exists(public_path($data->tapak_no_vehicle_entry_img)))
                                                        <a href="{{ URL::asset($data->tapak_no_vehicle_entry_img) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ URL::asset($data->tapak_no_vehicle_entry_img) }}"
                                                                alt="" class="adjust-height "
                                                                style="height:30px; width:30px !important">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- Area --}}
                                            <tr>
                                                <th rowspan="4">{{ __('messages.Area') }}</th>
                                                <td class="d-flex">
                                                    <input type="checkbox" name="kawasan[bend]" id="area_bend" disabled
                                                        class="form-check" {{ checkCheckBox('bend', $data->kawasan) }}>
                                                    <label for="area_bend">{{ __('messages.Bend') }}</label>
                                                </td>

                                                <td>
                                                    @if ($data->kawasan_bend_img != '' && file_exists(public_path($data->kawasan_bend_img)))
                                                        <a href="{{ URL::asset($data->kawasan_bend_img) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ URL::asset($data->kawasan_bend_img) }}"
                                                                alt="" class="adjust-height "
                                                                style="height:30px; width:30px !important">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[road]" id="area_road" disabled
                                                        class="form-check" {{ checkCheckBox('road', $data->kawasan) }}>
                                                    <label for="area_road"> {{ __('messages.Road') }}</label>
                                                </td>

                                                <td>
                                                    @if ($data->kawasan_road_img != '' && file_exists(public_path($data->kawasan_road_img)))
                                                        <a href="{{ URL::asset($data->kawasan_road_img) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ URL::asset($data->kawasan_road_img) }}"
                                                                alt="" class="adjust-height "
                                                                style="height:30px; width:30px !important">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[forest]" id="area_forest"
                                                        disabled class="form-check"
                                                        {{ checkCheckBox('forest', $data->kawasan) }}>
                                                    <label for="area_forest">{{ __('messages.Forest') }} </label>
                                                </td>

                                                <td>
                                                    @if ($data->kawasan_forest_img != '' && file_exists(public_path($data->kawasan_forest_img)))
                                                        <a href="{{ URL::asset($data->kawasan_forest_img) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ URL::asset($data->kawasan_forest_img) }}"
                                                                alt="" class="adjust-height "
                                                                style="height:30px; width:30px !important">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[other]" id="area_other" disabled
                                                        class="form-check" {{ checkCheckBox('other', $data->kawasan) }}>
                                                    <label for="area_other">{{ __('messages.others') }} </label>
                                                </td>

                                                <td>
                                                    @if ($data->kawasan_other_img != '' && file_exists(public_path($data->kawasan_other_img)))
                                                        <a href="{{ URL::asset($data->kawasan_other_img) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ URL::asset($data->kawasan_other_img) }}"
                                                                alt="" class="adjust-height "
                                                                style="height:30px; width:30px !important">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>






                                <div class="row">
                                    <div class="col-md-4"><label
                                            for="jarak_kelegaan">{{ __('messages.Clearance_Distance') }}</label></div>
                                    <div class="col-md-4"><input type="number" name="jarak_kelegaan" disabled
                                            value="{{ $data->jarak_kelegaan }}" id="jarak_kelegaan"
                                            class="form-control"></div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4"><label for="">
                                            {{ __('messages.Line_clearance_specifications') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="talian_spec" id="line-comply"
                                                    {{ $data->talian_spec == 'comply' ? 'checked' : '' }} value="comply"
                                                    disabled class="form-check"><label for="line-comply">
                                                    {{ __('messages.Comply') }}</label>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="talian_spec"
                                                    {{ $data->talian_spec == 'uncomply' ? 'checked' : '' }}
                                                    value="uncomply" disabled id="line-disobedient" class="form-check">
                                                <label for="line-disobedient"> Uncomply </label>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                            {{-- END Heigh Clearance (4) --}}



                            <h3>{{ __('messages.Kebocoran_Arus') }} </h3>



                            {{-- START Kebocoran Arus (5) --}}

                            <fieldset class="form-input">

                                <div class="row">
                                    <div class="col-md-4"><label
                                            for="">{{ __('messages.Inspection_of_current_leakage_on_the_pole') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="arus_pada_tiang" id="arus_pada_tiang_no"
                                                    class="form-check" value="No" disabled
                                                    {{ $data->arus_pada_tiang === 'No' ? 'checked' : '' }}>
                                                <label for="arus_pada_tiang_no">{{ __('messages.no') }}</label>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="arus_pada_tiang" id="arus_pada_tiang_yes"
                                                    class="form-check" value="Yes" disabled
                                                    {{ $data->arus_pada_tiang === 'Yes' ? 'checked' : '' }}>
                                                <label for="arus_pada_tiang_yes">{{ __('messages.yes') }}</label>
                                            </div>

                                            <div class="col-md-4 @if ($data->arus_pada_tiang == 'No' || $data->arus_pada_tiang == '') d-none @endif">
                                                <input type="text" name="arus_pada_tiang_amp" id="arus_pada_tiang_amp"
                                                    disabled class="form-control"
                                                    value="{{ $data->arus_pada_tiang_amp }}">
                                                <label for="arus_pada_tiang_amp">{{ __('messages.Amp') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                
                        <div class="row">
                            <div class="col-md-4">
                                <label for="zone">QA Status</label>
                            </div>
                            <div class="col-md-4">

                            

                                @if ($data->review_date != '' && $data->pole_image_1 != '')

                                
                                <button type="button" class="btn  text-left form-control {{$data->qa_status == 'Accept' ? 'btn-success' :($data->qa_status == 'Reject' ? 'btn-danger' :'btn-primary') }} " 
                                    data-toggle="dropdown">
                                    {{ $data->qa_status }}

                                </button>
                                <div class="dropdown-menu" role="menu">
                                    @if ($data->qa_status != 'Accept')
                                        <a href="/{{ app()->getLocale() }}/tiang-talian-vt-and-vr-update-QA-Status?status=Accept&&id={{ $data->id }}"
                                            onclick="return confirm('are you sure?')">
                                            <button type="button"
                                                class="dropdown-item pl-3 w-100 text-left">Accept</button>
                                        </a>
                                    @endif

                                    @if ($data->qa_status != 'Reject')
                                        <button type="button" class="btn btn-primary dropdown-item" data-id="{{$data->id }}"
                                            data-toggle="modal" data-target="#rejectReasonModal">
                                            Reject
                                        </button>
                                    @endif



                                </div>
                                @else
                                <button type="button" class="btn  text-left form-control" style="background: orange ; color:white"
                                >
                                <strong >Unsurveyed</strong>


                             </button>
                                @endif
                                {{-- <select name="qa_status" id="qa_status" class="form-control" ></select> --}}
                            </div>
                        </div>

                        @if ($data->qa_status == 'Reject')
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="zone">Reason</label>
                                </div>
                                <div class="col-md-4">
                                    <textarea name="" id="" cols="10" rows="4" disabled class="form-control">{{$data->reject_remarks}}</textarea>
                                </div>
                            </div>
                        @endif
                            </fieldset>
                            {{-- END Kebocoran Arus (5) --}}


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <x-reject-modal />

@endsection

@section('script')
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="{{ URL::asset('assets/test/js/jquery.steps.js') }}"></script>


    <script>
        var form = $("#framework-wizard-form").show();
        form
            .steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",

            })


            
 
    $(function(){
        $('#rejectReasonModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            $('#reject-foam').attr('action', `/{{app()->getLocale()}}/tiang-talian-vt-and-vr-update-QA-Status`)
            $('#reject-id').val(id);
        });
    })
</script>
 



@endsection
