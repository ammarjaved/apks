@extends('layouts.app')

@section('css')
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('assets/test/css/style.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        input[type='radio'] {
            border-radius: 50% !important;
        }

        .fw-400 {
            font-weight: 400 !important;
        }

        input[type='checkbox'],
        input[type='radio'] {
            min-width: 16px !important;
            margin-right: 12px;
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

        th {font-size: 14px !important;}
        th,td {  padding: 6px 16px !important}
        table,
        input[type='file'] {
            width: 90% !important;
        }

        #map {
            margin: 30px;
            height: 400px;
            padding: 20px;
        }

        table input[type="file"] {
            font-size: 11px !important;
            height: 33px !important;
        }

        td.d-flex {
            border-bottom: 0px !important;
            border-left: 0px !important;
        }

        .defects input[type="file"] { margin-bottom: 5px !important; }
        textarea { border: 1px solid #999999 !important; }
        .form-input .card { border-radius: 0px !important; }
        span.number { display: none;}
    </style>
@endsection


@section('content')
    <section class="content-header ">
        <div class="container-  ">
            <div class="row  " style="flex-wrap:nowrap">
                <div class="col-sm-6">
                    <h3>{{ __('messages.savt') }}</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('savt.index', app()->getLocale()) }}">{{ __('messages.index') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('messages.create') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="container ms-auto">

        <div class=" card col-md-12 p-3 ">
            <h3 class="text-center p-2">{{ __('messages.savt') }}</h3>
                        <form id="framework-wizard-form" action="{{ route('savt.store', app()->getLocale()) }}"
                            enctype="multipart/form-data" style="display: none" method="POST"
                            onsubmit="return submitFoam()">
                            @csrf

                            <h3>{{ __('messages.info') }}</h3>

                            {{-- START Info (1) --}}
                            <fieldset class=" form-input">

                                {{-- BA --}}
                                <div class="row">
                                    <div class="col-md-4"><label for="ba">{{ __('messages.ba') }}</label></div>
                                    <div class="col-md-4">
                                        <select name="ba_s" id="ba_s" class="form-control" onchange="getWp(this)" required>
                                            @if (Auth::user()->ba == '')
                                                <option value="" hidden>Select ba</option>

                                                <optgroup label="W1">
                                                    <option value="KL PUSAT,KUALA LUMPUR PUSAT, 3.14925905877391, 101.754098819705">KL PUSAT</option>
                                                </optgroup>

                                                <optgroup label="B1">
                                                    <option value="PJ,PETALING JAYA, 3.1128074178475, 101.605270457169">PETALING JAYA</option>
                                                    <option value="RAWANG,RAWANG, 3.47839445121726, 101.622905486475">RAWANG</option>
                                                    <option value="K.SELANGOR,KUALA SELANGOR, 3.40703209426401, 101.317426926947">KUALA SELANGOR</option>
                                                </optgroup>

                                                <optgroup label="B2">
                                                    <option value="KLANG,KLANG, 3.08428642705789, 101.436185279023">KLANG</option>
                                                    <option value="PORT KLANG,PELABUHAN KLANG, 2.98188527916042, 101.324234779569">PELABUHAN KLANG</option>
                                                </optgroup>

                                                <optgroup label="B4">
                                                    <option value="CHERAS,CHERAS, 3.14197346621987, 101.849883983416">CHERAS</option>
                                                    <option value="BANTING/SEPANG,BANTING, 2.82111390453244, 101.505890775541">BANTING</option>
                                                    <option value="BANGI,BANGI,2.965810949933260,101.81881303103104">BANGI</option>
                                                    <option value="PUTRAJAYA/CYBERJAYA/PUCHONG,PUTRAJAYA & CYBERJAYA, 2.92875032271019, 101.675338316575">PUTRAJAYA & CYBERJAYA</option>
                                                </optgroup>

                                            @else
                                            @endif
                                        </select>
                                        <input type="hidden" name="ba" id="ba">
                                    </div>
                                </div>

                                {{-- Pembekal --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Pembekal"> {{ __('messages.Pembekal') }}   </label>
                                    </div>

                                </div>

                                {{-- PMU/PPU --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="supplier_pmu_ppu"> {{ __('messages.PMU_PPU') }}  </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="supplier_pmu_ppu" id="supplier_pmu_ppu" class="form-control" required>
                                    </div>
                                </div>

                                {{-- FEEDER NO --}}
                                <div class="row">
                                    <div class="col-md-4"><label for="supplier_feeder_no"> {{ __('messages.Feeder_no') }}  </label></div>
                                    <div class="col-md-4">
                                        <input type="text" name="supplier_feeder_no"  id="supplier_feeder_no" class="form-control" required>
                                    </div>
                                </div>

                                {{-- SECTION --}}
                                <div class="row">
                                    <div class="col-md-4"><label for="">{{ __('messages.Section') }} </label></div>
                                </div>

                                {{-- SECTION FROM --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="sec_from">{{ __('messages.from') }} </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="sec_from" id="sec_from" class="form-control">
                                    </div>
                                </div>

                                {{-- SECTION TO --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="sec_to">{{ __('messages.to') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="sec_to" id="sec_to" class="form-control">
                                    </div>
                                </div>

                                {{-- TIANG NO --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="tiang_no">{{ __('messages.Tiang_No') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="tiang_no" id="tiang_no" class="form-control" required>
                                    </div>
                                </div>

                                {{-- VOLTAN (KV) --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="voltan_kv">{{ __('messages.Voltan') }} (KV)</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="voltan_kv" id="voltan_kv" class="form-control">
                                            <option value="" hidden>select</option>
                                            <option value="11kv">11kv</option>
                                            <option value="33kv">33kv</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- VISIT DATE --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="review_date">{{ __('messages.visit_date') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" name="review_date" value="{{ now('Asia/Kuala_Lumpur')->format('Y-m-d') }}" id="review_date" class="form-control" required>
                                    </div>
                                </div>

                                {{-- COORDINATES --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="cordinates">{{ __('messages.coordinate') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="cordinates" id="cordinates" class="form-control" required readonly>
                                    </div>
                                </div>

                                <input type="hidden" name="lat" id="lat" required class="form-control">
                                <input type="hidden" name="log" id="log" class="form-control">

                                {{-- MAP ERROR DIV --}}
                                <div class="text-center">
                                    <strong> <span class="text-danger map-error"></span></strong>
                                </div>

                                {{-- MAP DIV --}}
                                <div id="map">

                                </div>

                            </fieldset>
                            {{-- END Info (1) --}}


                             {{-- IMAGES --}}
                             <h3>{{__('messages.Asset_Register')}}</h3>
                             <fieldset class="form-input">
                                <div class="row">

                                            {{-- ABC SAIZ (MMP) --}}
                                    <div class="col-md-6">
                                        <div class="card p-4">
                                            <label for="st7"> {{ __('messages.abc_saiz_mmp') }} </label>

                                            <div class="row">
                                                <div class=" col-md-12 row">

                                                    {{-- ABC SAIZ 3X70 --}}
                                                    <div class="d-flex col-md-4">
                                                        <input type="radio" name="abc_size_mmp" value="3x70" id="abc_saiz_mmp_3x70" class="  ">
                                                        <label for="abc_saiz_mmp_3x70" class="fw-400">3x70</label>
                                                    </div>

                                                    {{-- ABC SAIZ 3X150 --}}

                                                    <div class="d-flex col-md-4">
                                                        <input type="radio" name="abc_size_mmp" value="3x150" id="abc_saiz_mmp_3x150" class=" ">
                                                        <label for="abc_saiz_mmp_3x150" class="fw-400">3x150</label>
                                                    </div>

                                                    {{-- ABC SAIZ 3X240 --}}

                                                    <div class="d-flex col-md-4">
                                                        <input type="radio" name="abc_size_mmp" value="3x240" id="abc_saiz_mmp_3x240" class=" ">
                                                        <label for="abc_saiz_mmp_3x240" class="fw-400">3x240</label>
                                                    </div>
                                                </div>
                                            </div>


                                                {{-- ABC PANJNG METER --}}
                                            <div class="row">
                                                <div class="col-md-6"><label for="st7"> {{ __('messages.abc_panjang_meter') }} </label></div>
                                                <div class=" col-md-6 ">
                                                    <input type="number" name="abc_panjang_meter" id="abc_panjang_meter" class="form-control">
                                                </div>
                                            </div>

                                                {{-- ABC TIANG NO --}}
                                            <div class="row">
                                                <div class="col-md-6"><label for="st7"> {{ __('messages.abc_tiang_no') }} </label></div>
                                                <div class=" col-md-6 ">
                                                    <input type="text" name="abc_tiang_no" id="abc_tiang_no" class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="card p-4">


                                             {{-- BARE SAIZ MMP --}}
                                             <div class="row">
                                                <div class="col-md-6"><label for="st7"> {{ __('messages.bare_size_mmp') }} </label></div>
                                                <div class=" col-md-6 ">
                                                    <input type="text" name="bare_size_mmp" id="bare_size_mmp" class="form-control">
                                                </div>
                                            </div>

                                                {{-- BARE PANJANG METER --}}

                                            <div class="row">
                                                <div class="col-md-6"><label for="st7"> {{ __('messages.barbare_panjang_metere_size_mmp') }} </label></div>
                                                <div class=" col-md-6 ">
                                                    <input type="text" name="bare_panjang_meter" id="bare_panjang_meter" class="form-control">
                                                </div>
                                            </div>

                                                {{-- BARE TIANG NO --}}

                                            <div class="row">
                                                <div class="col-md-6"><label for="st7"> {{ __('messages.bare_tiang_no') }} </label></div>
                                                <div class=" col-md-6 ">
                                                    <input type="text" name="bare_tiang_no" id="bare_tiang_no" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                        {{-- UNDERGROUND --}}


                                    <div class="col-md-6">
                                        <div class="card p-4">
                                             <label for="st7"> {{ __('messages.underground_cabel_size_mmp') }} </label>


                                            <div class=" col-md-12 row">

                                                {{-- UNDERGROUND CABLE 3X70 --}}
                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="underground_cabel_size_mmp" value="3x70" id="underground_cabel_size_mmp_3x70" class="  ">
                                                    <label for="underground_cabel_size_mmp_3x70" class="fw-400">3x70</label>
                                                </div>

                                                {{-- UNDERGROUND CABLE 3X150 --}}

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="underground_cabel_size_mmp" value="3x150" id="underground_cabel_size_mmp_3x150" class=" ">
                                                    <label for="underground_cabel_size_mmp_3x150" class="fw-400">3x150</label>
                                                </div>

                                                {{-- UNDERGROUND CABLE 3X240 --}}

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="underground_cabel_size_mmp" value="3x240" id="underground_cabel_size_mmp_3x240" class=" ">
                                                    <label for="underground_cabel_size_mmp_3x240" class="fw-400">3x240</label>
                                                </div>
                                            </div>


                                            <div class="col-md-6"><label for="st7"> {{ __('messages.underground_cabel_length_meter') }} </label></div>
                                            <div class=" col-md-6">
                                                <input type="number" name="underground_cabel_length_meter" id="underground_cabel_length_meter" class="form-control">
                                            </div>

                                        </div>
                                    </div>


                                        {{-- BIL. EQUIPMENT --}}

                                    <div class="col-md-6">
                                        <div class="card p-4">

                                                {{-- AUTO CIRCUIT RECLOSER  --}}
                                            <label for="st7"> {{ __('messages.eqp_no_auto_circuit_recloser') }} </label>
                                            <div class=" col-md-12 row">

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_auto_circuit_recloser" value="Yes" id="eqp_no_auto_circuit_recloser_yes" class="  ">
                                                    <label for="eqp_no_auto_circuit_recloser_yes" class="fw-400">Yes</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_auto_circuit_recloser" value="No" id="eqp_no_auto_circuit_recloser_no" class=" ">
                                                    <label for="eqp_no_auto_circuit_recloser_no" class="fw-400">No</label>
                                                </div>
                                            </div>

                                                {{-- LOAD BREAK SWITCH  --}}
                                            <label for="st7"> {{ __('messages.eqp_no_load_break_switch') }} </label>
                                            <div class=" col-md-12 row">

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_load_break_switch" value="Yes" id="eqp_no_load_break_switch_yes" class="  ">
                                                    <label for="eqp_no_load_break_switch_yes" class="fw-400">Yes</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_load_break_switch" value="No" id="eqp_no_load_break_switch_no" class=" ">
                                                    <label for="eqp_no_load_break_switch_no" class="fw-400">No</label>
                                                </div>
                                            </div>


                                                    {{-- ISOLATOR SWITCH  --}}
                                            <label for="st7"> {{ __('messages.eqp_no_isolator_switch') }} </label>
                                            <div class=" col-md-12 row">

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_isolator_switch" value="Yes" id="eqp_no_isolator_switch_yes" class="  ">
                                                    <label for="eqp_no_isolator_switch_yes" class="fw-400">Yes</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_isolator_switch" value="No" id="eqp_no_isolator_switch_no" class=" ">
                                                    <label for="eqp_no_isolator_switch_no" class="fw-400">No</label>
                                                </div>
                                            </div>


                                                {{-- SET LFI  --}}
                                            <label for="st7"> {{ __('messages.eqp_no_set_lfi') }} </label>
                                            <div class=" col-md-12 row">

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_set_lfi" value="Yes" id="eqp_no_set_lfi_yes" class="  ">
                                                    <label for="eqp_no_set_lfi_yes" class="fw-400">Yes</label>
                                                </div>

                                                <div class="d-flex col-md-4">
                                                    <input type="radio" name="eqp_no_set_lfi" value="No" id="eqp_no_set_lfi_no" class=" ">
                                                    <label for="eqp_no_set_lfi_no" class="fw-400">No</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>





                             </fieldset>

                            {{-- IMAGES --}}
                            <h3>{{__('messages.images')}}</h3>
                            <fieldset class="form-input">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pole_image-1">{{ __('messages.pole') }} Image 1 </label>
                                    </div>
                                    <div class="col-md-4 p-2 pr-5">
                                        <input type="file" name="pole_image_1" id="pole_image_1" required accept="image/*" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="pole_image_1_div"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pole_image-2">{{ __('messages.pole') }} Image 2</label>
                                    </div>
                                    <div class="col-md-4 p-2 pr-5">
                                        <input type="file" name="pole_image_2" id="pole_image_2" required accept="image/*" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="pole_image_2_div"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pole_image-1">{{ __('messages.pole') }} Image 3 </label>
                                    </div>
                                    <div class="col-md-4 p-2 pr-5">
                                        <input type="file" name="pole_image_3" id="pole_image_3"  accept="image/*" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="pole_image_3_div"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pole_image-2">{{ __('messages.pole') }} Image 4</label>
                                    </div>
                                    <div class="col-md-4 p-2 pr-5">
                                        <input type="file" name="pole_image_4" id="pole_image_4"  accept="image/*" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="pole_image_4_div"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pole_image-1">{{ __('messages.pole') }} Image 5 </label>
                                    </div>
                                    <div class="col-md-4 p-2 pr-5">
                                        <input type="file" name="pole_image_5" id="pole_image_5"  accept="image/*" class="form-control">
                                    </div>
                                    <div class="col-md-4" id="pole_image_5_div"></div>

                                </div>

                            </fieldset>

                            {{-- END IMAGES --}}




                            {{-- START Kejanggalan (3) --}}
                            <h3>{{ __('messages.kejanggalan') }}</h3>

                            <fieldset class="form-input defects">
                                <h3>{{ __('messages.kejanggalan') }}</h3>

                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead style="background-color: #E4E3E3 !important">
                                            <th class="col-4">{{ __('messages.title') }}</th>
                                            <th class="col-4">{{ __('messages.defects') }}</th>
                                        </thead>
                                        {{-- POLE --}}
                                        <tr>
                                            <th rowspan="5">{{ __('messages.pole') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[cracked]" id="cracked" class="form-check">
                                                <label for="cracked"> {{ __('messages.cracked') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[leaning]" id="leaning" class="form-check">
                                                <label for="leaning"> {{ __('messages.leaning') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[dim]" id="dim" class="form-check">
                                                <label for="dim"> {{ __('messages.no_dim_post_none') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[creepers]" id="creepers" class="form-check">
                                                <label for="creepers"> {{ __('messages.Creepers') }} </label>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="d-flex">
                                                <label for="creepers_after"> {{ __('messages.Creepers') }} After </label>
                                            </td>
                                        </tr> --}}

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="tiang_defect[other]" id="other_tiang_defect" class="form-check">
                                                <label for="other_tiang_defect"> {{ __('messages.others') }} </label>
                                                <input type="text" name="tiang_defect[other_value]" id="other_tiang_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- Line (Main / Service) --}}

                                        <tr>
                                            <th rowspan="4">{{ __('messages.line_main_service') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="talian_defect[joint]" id="joint" class="form-check">
                                                <label for="joint"> {{ __('messages.joint') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="talian_defect[need_rentis]" id="need_rentis" class="form-check">
                                                <label for="need_rentis"> {{ __('messages.need_rentis') }}</label>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="talian_defect[ground]" id="ground" class="form-check">
                                                <label for="ground">{{ __('messages.Does_Not_Comply_With_Ground_Clearance') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="talian_defect[other]" id="other_talian_defect" class="form-check">
                                                <label for="other_talian_defect"> {{ __('messages.others') }} </label>
                                                <input type="text" name="talian_defect[other_value]" id="other_talian_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>


                                        {{-- Umbang --}}

                                        <tr>
                                            <th rowspan="5">{{ __('messages.Umbang') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[breaking]" id="umbang_breaking" class="form-check ">
                                                <label for="umbang_breaking">{{ __('messages.Sagging_Breaking') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[creepers]" id="umbang_creepers" class="form-check ">
                                                <label for="umbang_creepers">{{ __('messages.Creepers') }}</label>
                                            </td>
                                        </tr>

                                        {{-- <tr>
                                            <td class="d-flex"> <label for="umbang_creepers">{{ __('messages.Creepers') }} After</label>
                                            </td>
                                            <td>
                                                <input type="file" name="umbang_defect_image[creepers_after1]" id="after1_umbang_creepers-image" class="d-none form-control" accept="image/*">
                                                <input type="file" name="umbang_defect_image[creepers_after2]" id="after2_umbang_creepers-image-2" class="d-none form-control" accept="image/*">
                                            </td>
                                        </tr> --}}

                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[cracked]" id="umbang_cracked" class="form-check ">
                                                <label for="umbang_cracked">{{__('messages.No_Stay_Insulator_Damaged') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[stay_palte]" id="stay_palte" class="form-check">
                                                <label for="stay_palte">{{ __('messages.Stay_Plate_Base_Stay_Blocked') }}</label>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[current_leakage]" id="umb_current_leakage" class="form-check">
                                                <label for="umb_current_leakage"> {{ __('messages.current_leakage') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="umbang_defect_image[current_leakage]" id="umb_current_leakage-image" accept="image/*" class="d-none form-control">
                                                <input type="file" name="umbang_defect_image[current_leakage2]" id="umb_current_leakage-image-2" accept="image/*" class="d-none form-control">
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="umbang_defect[other]" id="other_umbang_defect" class="form-check">
                                                <label for="other_umbang_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="umbang_defect[other_value]" id="other_umbang_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- IPC --}}
                                        <tr>
                                            <th rowspan="2">{{ __('messages.IPC') }}</th>
                                            <td>
                                                <input type="checkbox" name="ipc_defect[burn]" id="ipc_burn"class="form-check">
                                                <label for="ipc_burn">{{ __('messages.Burn Effect') }} Burn Effect</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="ipc_defect[other]" id="other_ipc_defect" class="form-check">
                                                <label for="other_ipc_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="ipc_defect[other_value]" id="other_ipc_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- Black Box --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.Black_Box') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="blackbox_defect[cracked]" id="black_box_cracked" class="form-check">
                                                <label for="black_box_cracked">{{ __('messages.Kesan_Bakar') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="blackbox_defect[other]" id="other_blackbox_defect" class="form-check">
                                                <label for="other_blackbox_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="blackbox_defect[other_value]"  id="other_blackbox_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- Jumper --}}
                                        <tr>
                                            <th rowspan="3">{{ __('messages.jumper') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="jumper[sleeve]" id="jumper_sleeve" class="form-check">
                                                <label for="jumper_sleeve">{{ __('messages.no_uv_sleeve') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="jumper[burn]" id="jumper_burn" class="form-check">
                                                <label for="jumper_burn">{{ __('messages.Burn Effect') }} </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="jumper[other]" id="other_jumper" class="form-check">
                                                <label for="other_jumper">{{ __('messages.others') }}</label>
                                                <input type="text" name="jumper[other_value]" id="other_jumper-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- Lightning catcher --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.lightning_catcher') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="kilat_defect[broken]" id="lightning_broken" class="form-check">
                                                <label for="lightning_broken">{{ __('messages.broken') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="kilat_defect[other]" id="other_kilat_defect" class="form-check">
                                                <label for="other_kilat_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="kilat_defect[other_value]" id="other_kilat_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- Service --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.Service') }}</th>
                                            <td class="d-felx">
                                                <input type="checkbox" name="servis_defect[roof]" id="service_roof" class="form-check">
                                                <label for="service_roof">{{ __('messages.the_service_line_is_on_the_roof') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-felx">
                                                <input type="checkbox" name="servis_defect[won_piece]" id="service_won_piece" class="form-check">
                                                <label for="service_won_piece">{{ __('messages.won_piece_date') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="servis_defect[other]" id="other_servis_defect" class="form-check">
                                                <label for="other_servis_defect">{{ __('messages.others') }} </label>
                                                <input type="text" name="servis_defect[other_value]" id="other_servis_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>
                                        {{-- Grounding --}}
                                        <tr>
                                            <th rowspan="2">{{ __('messages.grounding') }}</th>
                                            <td>
                                                <input type="checkbox" name="pembumian_defect[netural]" id="grounding_netural" class="form-check">
                                                <label for="grounding_netural">{{ __('messages.no_connection_to_neutral') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="pembumian_defect[other]" id="other_pembumian_defect" class="form-check">
                                                <label for="other_pembumian_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="pembumian_defect[other_value]" id="other_pembumian_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- Signage - OFF Point / Two Way Supply --}}
                                        <tr>
                                            <th rowspan="2">{{ __('messages.signage_off_point_two_way_supply') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="bekalan_dua_defect[damage]" id="signage_damage" class="form-check">
                                                <label for="signage_damage">{{ __('messages.faded_damaged_missing_signage') }}</label>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="bekalan_dua_defect[other]" id="other_bekalan_dua_defect" class="form-check">
                                                <label for="other_bekalan_dua_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="bekalan_dua_defect[other_value]" id="other_bekalan_dua_defect-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>

                                        {{-- Main Street --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.main_street') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="kaki_lima_defect[date_wire]" id="street_date_wire" class="form-check">
                                                <label for="street_date_wire">{{ __('messages.date_wire') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="kaki_lima_defect[burn]" id="street_burn" class="form-check">
                                                <label for="street_burn">{{ __('messages.junction_box_date_burn_effect') }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="kaki_lima_defect[other]" id="other_kaki_lima_defect_image" class="form-check">
                                                <label for="other_kaki_lima_defect_image">{{ __('messages.others') }}</label>
                                                <input type="text" name="kaki_lima_defect[other_value]" id="other_kaki_lima_defect_image-input" placeholder="mention other defect" required class="form-control d-none">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <input type="hidden" name="total_defects" id="total_defects">
                            </fieldset>
                            <h3>{{ __('messages.Heigh_Clearance') }}</h3>

                            {{-- START Heigh Clearance (4) --}}

                            <fieldset class="form-input high-clearance">
                                <h3>{{ __('messages.Heigh_Clearance') }}</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead style="background-color: #E4E3E3 !important">
                                            <th class="col-4">{{ __('messages.title') }}</th>
                                            <th class="col-4">{{ __('messages.defects') }}</th>
                                        </thead>
                                        <tbody>

                                            {{-- Site Conditions --}}

                                            <tr>
                                                <th rowspan="3">{{ __('messages.Site_Conditions') }}</th>
                                                <td class="d-flex">
                                                    <input type="checkbox" name="tapak_condition[road]" id="site_road" class="form-check">
                                                    <label for="site_road">{{ __('messages.Crossing_the_Road') }}</label>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tapak_condition[side_walk]"  id="side_walk" class="form-check">
                                                    <label for="side_walk">{{ __('messages.Sidewalk') }}</label>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tapak_condition[vehicle_entry]" id="vehicle_entry" class="form-check">
                                                    <label for="vehicle_entry">{{ __('messages.No_vehicle_entry_area') }}</label>
                                                </td>

                                            </tr>

                                            {{-- Area --}}
                                            <tr>
                                                <th rowspan="4">{{ __('messages.Area') }}</th>
                                                <td class="d-flex">
                                                    <input type="checkbox" name="kawasan[bend]" id="area_bend" class="form-check">
                                                    <label for="area_bend">{{ __('messages.Bend') }}</label>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[road]" id="area_road" class="form-check">
                                                    <label for="area_road"> {{ __('messages.Road') }}</label>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[forest]" id="area_forest" class="form-check">
                                                    <label for="area_forest">{{ __('messages.Forest') }} </label>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[other]" id="area_other" class="form-check">
                                                    <label for="area_other">{{ __('messages.others') }}  {{-- (please state) --}} </label>
                                                    <input type="text" name="kawasan[other_value]" id="area_other-input" class="form-control d-none" required placeholder="(please state)">
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="jarak_kelegaan">{{ __('messages.Clearance_Distance') }}</label></div>
                                    <div class="col-md-4">
                                        <input type="number" name="jarak_kelegaan" id="jarak_kelegaan" class="form-control">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">{{ __('messages.Line_clearance_specifications') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="talian_spec" value="comply" id="line-comply" class="form-check">
                                                <label for="line-comply"> {{ __('messages.Comply') }}</label>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="talian_spec" value="uncomply" id="line-disobedient" class="form-check">
                                                <label for="line-disobedient">Uncomply</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            {{-- END Heigh Clearance (4) --}}


                            <h3>{{ __('messages.Kebocoran_Arus') }}</h3>


                            {{-- START Kebocoran Arus (5) --}}

                            <fieldset class="form-input">
                                <h3>{{ __('messages.Kebocoran_Arus') }}</h3>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">{{ __('messages.Inspection_of_current_leakage_on_the_pole') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="tiang_defect_current_leakage" id="arus_pada_tiang_no" class="form-check" value="No">
                                                <label for="arus_pada_tiang_no">{{ __('messages.no') }}</label>
                                            </div>
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="tiang_defect_current_leakage" id="arus_pada_tiang_yes" class="form-check" value="Yes">
                                                <label for="arus_pada_tiang_yes">{{ __('messages.yes') }}</label>
                                            </div>

                                            <div class="col-md-4 d-none  " id="arus_pada_tiang_amp_div">
                                                <label for="arus_pada_tiang_amp">{{ __('messages.Amp') }}</label>
                                                <input type="text" name="tiang_defect[current_leakage_val]" id="arus_pada_tiang_amp" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">{{ __('messages.Inspection_of_current_leakage_on_the_umbang') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="umbang_defect_current_leakage" value="No" id="arus_pada_umbgan_no" class="form-check"  >
                                                <label for="arus_pada_umbgan_no">{{ __('messages.no') }}</label>
                                            </div>
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="umbang_defect_current_leakage" value="Yes" id="arus_pada_umbgan_yes" class="form-check"  >
                                                <label for="arus_pada_umbgan_yes">{{ __('messages.yes') }}</label>
                                            </div>

                                            <div class="col-md-4 d-none  " id="arus_pada_umbgan_amp_div">
                                                <label for="arus_pada_umbgan_amp">{{ __('messages.Amp') }}</label>
                                                <input type="text" name="umbang_defect[current_leakage_val]" id="arus_pada_umbgan_amp" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            {{-- END Kebocoran Arus (5) --}}
                        </form>

        </div>
    </section>
@endsection

@section('script')
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="{{ URL::asset('assets/test/js/jquery.steps.js') }}"></script>

    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="{{ URL::asset('map/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js') }}"></script>

    <script>
        var form = $("#framework-wizard-form").show();
        form
            .steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",

                onStepChanging: function(event, currentIndex, newIndex) {
                    if (currentIndex > newIndex) {
                        return true;
                    }

                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },




                onFinished: function(event, currentIndex) {
                    form.submit();
                },
                // autoHeight: true,
            })

        function getWp(param) {
            var splitVal = param.value.split(',');
            addRemoveBundary(splitVal[1], splitVal[2], splitVal[3])

            $('#ba').val(splitVal[1])


        }

        function submitFoam() {
            if ($('#lat').val() == '' || $('#log').val() == '') {
                $('.map-error').html('Please select location')
                return false;
            } else {
                $('.map-error').html(' ')
            }
        }
    </script>
    <script type="text/javascript">
        var baseLayers
        var identifyme = '';
        var boundary3 = '';
        var marker = '';
        var boundary2 = '';
        map = L.map('map').setView([3.016603, 101.858382], 5);



        var st1 = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map); // satlite map

        var street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'); // street map

        // ADD MAPS
        baseLayers = {
            "Satellite": st1,
            "Street": street
        };


        boundary3 = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
            layers: 'cite:aero_apks',
            format: 'image/png',
            maxZoom: 21,
            transparent: true
        }, {
            buffer: 10
        })



        // ADD LAYERS GROUPED OVER LAYS
        groupedOverlays = {
            "POI": {
                'BA': boundary3,
            }
        };

        var layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
            collapsed: true,
            position: 'topright'
            // groupCheckboxes: true
        }).addTo(map);



        // add boundary layer on page load
        map.addLayer(boundary3)
        map.setView([2.59340882301331, 101.07054901123], 8);


        // change layer and view when ba change
        function addRemoveBundary(param, paramY, paramX) {

            if (boundary3 != '') {
                map.removeLayer(boundary3) // Remove on page load boundary
            }


            if (boundary2 !== '') { // boundary if eesixts then first reomve from map
                map.removeLayer(boundary2)
            }

            boundary2 = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:ba',
                format: 'image/png',
                cql_filter: "station='" + param + "'", // add ba name for filter boundary
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(boundary2) // add filtered boundary
            boundary2.bringToFront()

            map.setView([parseFloat(paramY), parseFloat(paramX)], 10); // set view






        }

        // on click map add marker and bind popup
        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng);
            map.addLayer(marker);
            marker.bindPopup("<b>You clicked the map at " + e.latlng.toString()).openPopup();

            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            $('#lat').val(lat);
            $('#log').val(lng);
            $('#cordinates').val(e.latlng);
        }

        map.on('click', onMapClick);
    </script>

    <script>
        const b1Options = [
            ['W1', 'KUALA LUMPUR PUSAT', 3.14925905877391, 101.754098819705],
            ['B1', 'PETALING JAYA', 3.1128074178475, 101.605270457169],
            ['B1', 'RAWANG', 3.47839445121726, 101.622905486475],
            ['B1', 'KUALA SELANGOR', 3.40703209426401, 101.317426926947],
            ['B2', 'KLANG', 3.08428642705789, 101.436185279023],
            ['B2', 'PELABUHAN KLANG', 2.98188527916042, 101.324234779569],
            ['B4', 'CHERAS', 3.14197346621987, 101.849883983416],
            ['B4', 'BANTING', 2.82111390453244, 101.505890775541],
            ['B4', 'BANGI', 2.965810949933260, 101.81881303103104],
            ['B4', 'PUTRAJAYA & CYBERJAYA', 2.92875032271019, 101.675338316575]
        ];

        const userBa = "{{ Auth::user()->ba }}";
        $(document).ready(function() {



            if (userBa !== '') {
                getBaPoints(userBa)
            }

            $('.defects input[type="checkbox"]').on('click', function() {
                addReomveImageField(this)

            })
            $('.high-clearance input[type="checkbox"]').on('click', function() {
                addReomveImageHighClearanceField(this)

            })
            $('input[name="tiang_defect_current_leakage"]').on('change', function() {
                if (this.value == 'Yes') {
                    if ($('#arus_pada_tiang_amp_div').hasClass('d-none')) {
                        $('#arus_pada_tiang_amp_div').removeClass('d-none');
                    }
                } else {
                    if (!$('#arus_pada_tiang_amp_div').hasClass('d-none')) {
                        $('#arus_pada_tiang_amp_div').addClass('d-none');
                    }
                }
            })

            $('input[name="umbang_defect_current_leakage"]').on('change', function() {
                if (this.value == 'Yes') {
                    if ($('#arus_pada_umbgan_amp_div').hasClass('d-none')) {
                        $('#arus_pada_umbgan_amp_div').removeClass('d-none');
                    }
                } else {
                    if (!$('#arus_pada_umbgan_amp_div').hasClass('d-none')) {
                        $('#arus_pada_umbgan_amp_div').addClass('d-none');
                    }
                }
            })


            $('.select-radio-value').on('change', function() {
                var val = this.value;
                var id = `${this.name}_input`;
                var input = $(`#${id}`)
                if (val === 'other') {
                    input.val('');
                    input.removeClass('d-none');
                } else {
                    input.val(val);
                    if (!input.hasClass('d-none')) {
                        input.addClass('d-none')
                    }
                }
            });

            $('input[type="file"]').on('change', function() {
                showUploadedImage(this)
            })

        });

        // DISPALY UPLOADED IMAGE
        function showUploadedImage(param) {
            const file = param.files[0];
            const id = $(`#${param.id}_div`);

            if (file) {
                id.empty()
                const reader = new FileReader();
                reader.onload = function(e) {
                    var img =
                        `<a class="text-right"  href="${e.target.result}" data-lightbox="roadtrip"><span class="close-button" onclick="removeImage('${param.id}')">X</span><img src="${e.target.result}" style="height:50px;"/></a>`;
                    id.append(img)
                };

                reader.readAsDataURL(file);
            }
        }

        // REMOVE UPLOADED IMAGES
        function removeImage(id) {
            console.log(id);
            $(`#${id}`).val('');
            $(`#${id}_div`).empty();
        }

        var total_defects = 0;

        function addReomveImageField(checkbox) {
            var element = $(checkbox);
            var id = element.attr('id');
            var input_val = $(`#${id}-input`)

            if (checkbox.checked) {
                if (input_val.hasClass('d-none')) {
                    input_val.removeClass('d-none');

                    total_defects += 1;
                }
            } else {

                if (!input_val.hasClass('d-none')) {
                    input_val.addClass('d-none');
                    input_val.val('');
                    total_defects -= 1;

                }
            }

            $('#total_defects').val(total_defects)

        }


        function addReomveImageHighClearanceField(checkbox) {
            var element = $(checkbox);
            var id = element.attr('id');
            var input_val = $(`#${id}-input`)

            if (checkbox.checked) {
                if (input_val.hasClass('d-none')) {
                    input_val.removeClass('d-none');
                }
            } else {

                if (!input_val.hasClass('d-none')) {

                    input_val.addClass('d-none');
                    input_val.val('');

                    var span = input.parent().find('label');
                    if (span.length > 0) {
                        span.html('')
                    }

                    var span_val = $(`#${id}-input-error`);
                    if (span_val.length > 0) {
                        span_val.html('')
                    }
                }

            }
        }


        function getBaPoints(param) {
            var baSelect = $('#ba_s')
            baSelect.empty();

            b1Options.map((data) => {
                if (data[1] == param) {
                    baSelect.append(`<option value="${data}">${data[1]}</option>`)
                }
            });
            let baVal = document.getElementById('ba_s');
            getWp(baVal)
        }


        function getMainLine(val) {
            // if (val == 'service_line') {
            //     $('#main_line_connection').removeClass('d-none')
            // }else{
            //     if (!$('#main_line_connection').hasClass('d-none')) {
            //     $('#main_line_connection').addClass('d-none')
            //     $('#main_line_connection_one , #main_line_connection_many').prop('checked', false);
            //     }
            // }
        }
    </script>
@endsection
