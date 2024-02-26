
                          
                          
                          
    <h3>{{ __('messages.info') }} </h3>


    {{-- START Info (1) --}}
    <fieldset class=" form-input">

        {{-- BA --}}
        <div class="row">
            <div class="col-md-4"><label for="ba">{{ __('messages.ba') }}</label></div>
            <div class="col-md-4">
                <select name="ba" id="ba" class="form-control" required>
                    <option value="{{ $data->ba }}">{{ $data->ba }}</option>
                    @if (Auth::user()->ba == '')
                        <optgroup label="W1">
                            <option value="KUALA LUMPUR PUSAT">KL PUSAT</option>
                        </optgroup>
                        <optgroup label="B1">
                            <option value="PETALING JAYA">PETALING JAYA</option>
                            <option value="RAWANG">RAWANG</option>
                            <option value="KUALA SELANGOR">KUALA SELANGOR</option>
                        </optgroup>
                        <optgroup label="B2">
                            <option value="KLANG">KLANG</option>
                            <option value="PELABUHAN KLANG">PELABUHAN KLANG</option>
                        </optgroup>
                        <optgroup label="B4">
                            <option value="CHERAS">CHERAS</option>
                            <option value="BANTING">BANTING</option>
                            <option value="BANGI">BANGI</option>
                            <option value="PUTRAJAYA & CYBERJAYA">PUTRAJAYA & CYBERJAYA</option>
                        </optgroup>
                    @endif
                </select>
            </div>
        </div>

        {{-- FP NAME --}}
        <div class="row">
            <div class="col-md-4"><label for="fp_name"> {{ __('messages.name_of_substation') }} / {{ __('messages.Name_of_Feeder_Pillar') }} </label></div>
            <div class="col-md-4">
                <input type="text" name="fp_name" value="{{ $data->fp_name }}" id="fp_name" class="form-control" required>
            </div>
        </div>

        {{-- FEEDER NAME --}}
        <div class="row">
            <div class="col-md-4"><label for="fp_road"> {{ __('messages.Feeder_Name') }} / {{ __('messages.Street_Name') }}</label></div>
            <div class="col-md-4">
                <input type="text" name="fp_road" value="{{ $data->fp_road }}" id="fp_road" class="form-control" required>
            </div>
        </div>

        {{-- SECTION --}}
        <div class="row">
            <div class="col-md-4"><label for="">{{ __('messages.Section') }} </label></div>
        </div>

        {{-- SECTON FROM --}}
        <div class="row">
            <div class="col-md-4"><label for="section_from">{{ __('messages.from') }} </label></div>
            <div class="col-md-4">
                <input type="text" name="section_from" value="{{ $data->section_from }}" id="section_from" class="form-control">
            </div>
        </div>

        {{-- SECTION TO --}}
        <div class="row">
            <div class="col-md-4"><label for="section_to">{{ __('messages.to') }}</label></div>
            <div class="col-md-4">
                <input type="text" name="section_to" value="{{ $data->section_to }}" id="section_to" class="form-control">
            </div>
        </div>

        {{-- TIANG NO --}}
        <div class="row">
            <div class="col-md-4"><label for="tiang_no">{{ __('messages.Tiang_No') }}</label></div>
            <div class="col-md-4">
                <input type="text" name="tiang_no" value="{{ $data->tiang_no }}" id="tiang_no" class="form-control" required>
            </div>
        </div>

        {{-- VISIT DATE --}}
        <div class="row">
            <div class="col-md-4"><label for="review_date">{{__('messages.visit_date')}}</label></div>
            <div class="col-md-4">
                <input type="date" name="review_date" id="review_date" class="form-control" required  value="{{ $data->review_date }}">
            </div>
        </div>

        {{-- MAIN LINE SERVICE LINE --}}
        <div class="row">
            <div class="col-md-4">
                <label for="main_line">{{__('messages.main_line_service_line')}}</label>
            </div>
            <div class="col-md-4">
                <select name="talian_utama_connection" id="main_line" class="form-control"  >
                    <option value="{{$data->talian_utama_connection ?? ''}}" hidden>{{$data->talian_utama_connection ?? 'select'}}</option>
                    <option value="main_line">Main Line</option>
                    <option value="service_line">Service Line</option>
                </select>
            </div>
        </div>

        {{-- Number of Services Involves 1 user only --}}
        <div class="row " id="main_line_connection">
            <div class="col-md-4"><label for="">Number of Services Involves 1 user only</label></div>
            <div class="col-md-4">
                <input type="number" name="talian_utama" value="{{$data->talian_utama}}" class="form-control" id="main_line_connection_one"  >     
            </div>
        </div>

        {{-- POLE IMAGE 1 --}}
        <div class="row">
            <div class="col-md-4"><label for="pole_image-1">{{ __('messages.pole') }} Image 1</label></div>
            <div class="col-md-5 p-2 pr-5">
                <input type="file" name="pole_image_1" id="pole_image_1" class="form-control">
            </div>

            <div class="col-md-3">
                @if ($data->pole_image_1 != '' && file_exists(public_path($data->pole_image_1)))
                    <a href="{{ URL::asset($data->pole_image_1) }}" data-lightbox="roadtrip">
                        <img src="{{ URL::asset($data->pole_image_1) }}" alt="" class="adjust-height " style="height:30px; width:30px !important">
                    </a>
                @else
                    <strong>{{ __('messages.no_image_found') }} </strong>
                @endif
            </div>
        </div>

        {{-- POLE IMAGE 2 --}}
        <div class="row">
            <div class="col-md-4"><label for="pole_image-2">{{ __('messages.pole') }} Image
                    2</label>
            </div>
            <div class="col-md-5 p-2 pr-5">
                <input type="file" name="pole_image_2" id="pole_image_2" class="form-control">
            </div>
            <div class="col-md-3">
                @if ($data->pole_image_2 != '' && file_exists(public_path($data->pole_image_2)))
                    <a href="{{ URL::asset($data->pole_image_2) }}" data-lightbox="roadtrip">
                        <img src="{{ URL::asset($data->pole_image_2) }}" alt="" class="adjust-height " style="height:30px; width:30px !important">
                    </a>
                @else
                    <strong>{{ __('messages.no_image_found') }} </strong>
                @endif
            </div>
        </div>
    </fieldset>
    {{-- END Info (1) --}}

    <h3> {{ __('messages.Asset_Register') }} </h3>

    {{-- START Asset Register (2) --}}

    <fieldset class="form-input">
        <div class="row">
            <div class="col-md-6">

                {{-- POLE SIZE BILL --}}
                <div class="card p-4">
                    <label for="st7">{{ __('messages.Pole_Size_Bill') }} </label>
                    <div class="row">
                        <div class="col-md-12 row">

                            {{-- POLE SIZE BILL 7.5 --}}
                            <div class="d-flex col-md-4">
                                <input type="radio" name="size_tiang" value="7.5" id="st7" {{ $data->size_tiang == '7.5' ? 'checked' : '' }}class="  ">
                                <label for="st7" class="fw-400"> 7.5</label>
                            </div>

                            {{-- POLE SIZE BILL 9 --}}
                            <div class="d-flex col-md-4">
                                <input type="radio" name="size_tiang" value="9" id="st9" {{ $data->size_tiang == '9' ? 'checked' : '' }} class=" ">
                                <label for="st9" class="fw-400"> 9</label>
                            </div>

                            {{-- POLE SIZE BILL SIZE TIANG --}}
                            <div class="d-flex col-md-4">
                                <input type="radio" name="size_tiang" value="10" id="st10" {{ $data->size_tiang == '10' ? 'checked' : '' }} class=" ">
                                <label for="st10" class="fw-400"> 10</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                {{-- POLE  TYPE NO --}}
                <div class="card p-4">
                    <label for="">{{ __('messages.Pole_type_No') }} </label>
                    <div class="row">
                        <div class="col-md-12 row">

                            {{-- POLE TYPE NO SPUN --}}
                            <div class="d-flex col-md-4">
                                <input type="radio" name="jenis_tiang" value="spun" id="spun" class=" " {{ $data->jenis_tiang == 'spun' ? 'checked' : '' }}>
                                <label for="spun" class="fw-400">{{ __('messages.Spun') }}</label>
                            </div>

                            {{-- POLE TYPE NO CONCRETE --}}
                            <div class="d-flex col-md-4">
                                <input type="radio" name="jenis_tiang" value="concrete" id="concrete" class=" " {{ $data->jenis_tiang == 'concrete' ? 'checked' : '' }}>
                                <label for="concrete" class="fw-400">{{ __('messages.Concrete') }}</label>
                            </div>

                            {{-- POLE TYPE NO IRON --}}
                            <div class="d-flex col-md-4">
                                <input type="radio" name="jenis_tiang" value="iron" id="iron" class=" " {{ $data->jenis_tiang == 'iron' ? 'checked' : '' }}>
                                <label for="iron" class="fw-400">{{ __('messages.Iron') }}</label>
                            </div>

                            {{-- POLE TYPE NO WOOD --}}
                            <div class="d-flex col-md-4">
                                <input type="radio" name="jenis_tiang" value="wood" id="wood" class=" " {{ $data->jenis_tiang == 'wood' ? 'checked' : '' }}>
                                <label for="wood" class="fw-400">{{ __('messages.Wood') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ABC SPAN --}}
            <div class="col-md-6">
                <div class="card p-4">

                    {{-- ABC SPAN 3 X 185--}}
                    <label for="section_to">{{ __('messages.ABC_Span') }} 3 X 185</label>
                        {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's3_185',  true) !!}

                    {{-- ABC SPAN 3 X 95 --}}    
                    <label for="s3_95">{{ __('messages.ABC_Span') }}3 X 95</label>
                        {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's3_95',  true) !!}

                    {{-- ABC SPAN 3 X 16--}}
                    <label for="s3_16">{{ __('messages.ABC_Span') }}>3 X 16</label>
                        {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's3_16',  true) !!}
            
                    {{-- ABC SPAN  1 X 16--}}
                    <label for="s1_16">{{ __('messages.ABC_Span') }}1 X 16</label>
                        {!! tiangSpanRadio(  $data->abc_span, 'abc_span', 's1_16',  true) !!}
                </div>
            </div>

            {{-- PVC SPAN --}}
            <div class="col-md-6 ">
                <div class="card p-4">

                    {{-- PVC SPAN 19/064 --}}
                    <label for="s19_064">{{ __('messages.PVC_Span') }}19/064</label>
                        {!! tiangSpanRadio(    $data->pvc_span, 'pvc_span', 's19_064',  true) !!}
            
                    {{-- PVC SPAN 7/083--}}
                    <label for="s7_083"  >{{ __('messages.PVC_Span') }}7/083</label>
                        {!! tiangSpanRadio($data->pvc_span, 'pvc_span', 's7_083',  true) !!}
            
                    {{-- PVC SPAN 7/044--}}
                    <label for="s7_044"  >{{ __('messages.PVC_Span') }}7/044</label>
                        {!! tiangSpanRadio(  $data->pvc_span, 'pvc_span', 's7_044',  true) !!}
                </div>
            </div>

            {{-- BARE SPAN --}}
            <div class="col-md-6">
                <div class="card p-4">

                    {{-- BARE SPAN 7/173 --}}
                    <label for="s7_173">{{ __('messages.BARE_Span') }} 7/173</label>
                        {!! tiangSpanRadio(  $data->bare_span, 'bare_span', 's7_173',  true) !!}

                    {{-- BARE SPAN 7/122 --}}
                    <label for="s7_122">{{ __('messages.BARE_Span') }} 7/122</label>
                        {!! tiangSpanRadio(  $data->bare_span, 'bare_span', 's7_122',  true) !!}

                    {{-- BARE SPAN 3/132 --}}
                    <label for="s3_132">{{ __('messages.BARE_Span') }} 3/132</label>
                        {!! tiangSpanRadio(  $data->bare_span, 'bare_span', 's3_132',  true) !!}
                </div>
            </div>
        </div>
    </fieldset>

    {{-- END Asset Register (2) --}}


    <h3>{{ __('messages.kejanggalan') }}</h3>

    {{-- START KEJANGGALAN --}}
    <fieldset class="form-input defects">

        <h3>{{ __('messages.kejanggalan') }}</h3>
        <div class="table-responsive">
            <table class="table table-bordered w-100">
                <thead style="background-color: #E4E3E3 !important">
                    <th class="col-4">{{ __('messages.title') }}</th>
                    <th class="col-4">{{ __('messages.defects') }}</th>
                    <th class="col-3">{{ __('messages.images') }}</th>
                    <th class="col-1">{{ __('messages.images') }}</th>
                </thead>
                {{-- POLE --}}
                <tr>
                    <th rowspan="6">{{ __('messages.pole') }}</th>
                    {!! getImage2('cracked', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'cracked') !!}
                </tr>
                <tr>{!! getImage2('leaning', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'leaning') !!}</tr>
                <tr>{!! getImage2('dim', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'no_dim_post_none') !!}</tr>
                <tr>{!! getImage2('creepers', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'creepers') !!}</tr>
                <tr>{!! getImage2('creepers_after', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'Creepers') !!}</tr>              
                <tr>{!! getImage2('current_leakage', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'current_leakage') !!}</tr>
                <tr>{!! getImage2('other', $data->tiang_defect, 'tiang_defect', $data->tiang_defect_image, 'others') !!}</tr>

                {{-- Line (Main / Service) --}}
                <tr>
                    <th rowspan="4">{{ __('messages.line_main_service') }}</th>
                    {!! getImage2('joint', $data->talian_defect, 'talian_defect', $data->talian_defect_image, 'joint') !!}
                </tr>
                <tr>{!! getImage2('need_rentis', $data->talian_defect, 'talian_defect', $data->talian_defect_image, 'need_rentis') !!}</tr>
                <tr>{!! getImage2( 'ground', $data->talian_defect, 'talian_defect', $data->talian_defect_image, 'Does_Not_Comply_With_Ground_Clearance',) !!}</tr>
                <tr>{!! getImage2('other', $data->talian_defect, 'talian_defect', $data->talian_defect_image, 'others') !!}</tr>

                {{-- Umbang --}}
                <tr>
                    <th rowspan="6">{{ __('messages.Umbang') }}</th>
                    {!! getImage2('breaking', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'Sagging_Breaking') !!}
                </tr>
                <tr>{!! getImage2('creepers', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'Creepers') !!}</tr>
                <tr>{!! getImage2('creepers_after', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'Creepers') !!}</tr>              
                <tr>{!! getImage2( 'cracked', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'No_Stay_Insulator_Damaged') !!}</tr>
                <tr>{!! getImage2( 'stay_palte', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'Stay_Plate_Base_Stay_Blocked') !!}</tr>
                {{-- <tr>{!! getImage2('current_leakage', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'current_leakage') !!}</tr> --}}
                <tr>{!! getImage2('other', $data->umbang_defect, 'umbang_defect', $data->umbang_defect_image, 'others') !!}</tr>

                {{-- IPC --}}
                <tr>
                    <th rowspan="2">{{ __('messages.IPC') }}</th>
                    {!! getImage2('burn', $data->ipc_defect, 'ipc_defect', $data->ipc_defect_image, 'Burn Effect') !!}
                </tr>
                <tr>{!! getImage2('other', $data->ipc_defect, 'ipc_defect', $data->ipc_defect_image, 'others') !!}</tr>

                {{-- Black Box --}}

                <tr>
                    <th rowspan="2">{{ __('messages.Black_Box') }}</th>
                    {!! getImage2('cracked', $data->blackbox_defect, 'blackbox_defect', $data->blackbox_defect_image, 'Kesan_Bakar') !!}
                </tr>
                <tr>{!! getImage2('other', $data->blackbox_defect, 'blackbox_defect', $data->blackbox_defect_image, 'others') !!}</tr>

                {{-- Jumper --}}
                <tr>
                    <th rowspan="3">{{ __('messages.jumper') }}</th>
                    {!! getImage2('sleeve', $data->jumper, 'jumper', $data->jumper_image, 'no_uv_sleeve') !!}
                </tr>
                <tr>{!! getImage2('burn', $data->jumper, 'jumper', $data->jumper_image, 'Burn Effect') !!}</tr>
                <tr>{!! getImage2('other', $data->jumper, 'jumper', $data->jumper_image, 'others') !!}</tr>

                {{-- Lightning catcher --}}
                <tr>
                    <th rowspan="2">{{ __('messages.lightning_catcher') }}</th>
                    {!! getImage2('broken', $data->kilat_defect, 'kilat_defect', $data->kilat_defect_image, 'broken') !!}
                </tr>
                <tr>{!! getImage2('other', $data->kilat_defect, 'kilat_defect', $data->kilat_defect_image, 'others') !!}</tr>

                {{-- Service --}}
                <tr>
                    <th rowspan="3">{{ __('messages.Service') }}</th>
                    {!! getImage2('roof', $data->servis_defect, 'servis_defect', $data->servis_defect_image, 'the_service_line_is_on_the_roof',) !!}
                </tr>
                <tr>{!! getImage2('won_piece', $data->servis_defect, 'servis_defect', $data->servis_defect_image, 'won_piece_date') !!}</tr>
                <tr>{!! getImage2('other', $data->servis_defect, 'servis_defect', $data->servis_defect_image, 'others') !!}</tr>

                {{-- Grounding --}}
                <tr>
                    <th rowspan="2">{{ __('messages.grounding') }}</th>
                    {!! getImage2('netural', $data->pembumian_defect, 'pembumian_defect', $data->pembumian_defect_image,'no_connection_to_neutral',) !!}
                </tr>
                <tr>{!! getImage2('other', $data->pembumian_defect, 'pembumian_defect', $data->pembumian_defect_image, 'others') !!}</tr>

                {{-- Signage - OFF Point / Two Way Supply --}}
                <tr>
                    <th rowspan="2">{{ __('messages.signage_off_point_two_way_supply') }}</th>
                    {!! getImage2('damage', $data->bekalan_dua_defect, 'bekalan_dua_defect', $data->bekalan_dua_defect_image, 'faded_damaged_missing_signage',) !!}
                </tr>
                <tr>{!! getImage2('other', $data->bekalan_dua_defect, 'bekalan_dua_defect', $data->bekalan_dua_defect_image,'others',) !!}</tr>

                {{-- Main Street --}}
                <tr>
                    <th rowspan="3">{{ __('messages.main_street') }}</th>
                    {!! getImage2('date_wire', $data->kaki_lima_defect, 'kaki_lima_defect', $data->kaki_lima_defect_image, 'date_wire',) !!}
                </tr>
                <tr>{!! getImage2('burn', $data->kaki_lima_defect, 'kaki_lima_defect', $data->kaki_lima_defect_image, 'junction_box_date_burn_effect',) !!}</tr>
                <tr>{!! getImage2('other', $data->kaki_lima_defect, 'kaki_lima_defect', $data->kaki_lima_defect_image, 'others') !!}</tr>
            </table>
        </div>
        <input type="hidden" name="total_defects" id="total_defects">
    </fieldset>
    {{-- END KEJANGGALAN --}}





    <h3>{{ __('messages.Heigh_Clearance') }}</h3>

    {{-- START Heigh Clearance (4) --}}

    <fieldset class="form-input high-clearance">
        <div class="table-responsive">
            <table class="table table-bordered w-100">
                <thead style="background-color: #E4E3E3 !important">
                    <th class="col-4">{{ __('messages.title') }}</th>
                    <th class="col-4">{{ __('messages.defects') }}</th>
                    <th class="col-3" colspan="2">{{ __('messages.images') }}</th>
                </thead>
                <tbody>
                    {{-- Site Conditions --}}
                    <tr>
                        <th rowspan="3">{{ __('messages.Site_Conditions') }} </th>
                        {{-- CROSSING THE ROAD --}}
                        <td class="d-flex">
                            <input type="checkbox" name="tapak_condition[road]" id="site_road" class="form-check" {{ checkCheckBox('road', $data->tapak_condition) }}>
                            <label for="site_road">{{ __('messages.Crossing_the_Road') }}</label>
                        </td>

                        {{-- CROSSING THE ROAD IMAGE --}}
                        <td>
                            <input type="file" name="tapak_road_img" id="site_road-img" class="form-control @if (checkCheckBox('road', $data->tapak_condition) != 'checked') d-none @endif">
                        </td>
                        <td>
                            @if ($data->tapak_road_img != '' && file_exists(public_path($data->tapak_road_img)))
                                <a href="{{ URL::asset($data->tapak_road_img) }}" data-lightbox="roadtrip">
                                    <img src="{{ URL::asset($data->tapak_road_img) }}" alt="" class="adjust-height " style="height:30px; width:30px !important">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="tapak_condition[side_walk]"
                                id="side_walk" class="form-check"
                                {{ checkCheckBox('side_walk', $data->tapak_condition) }}>
                            <label for="side_walk">{{ __('messages.Sidewalk') }}</label>
                        </td>
                        <td>
                            <input type="file" name="tapak_sidewalk_img" id="side_walk-img"
                                class="form-control @if (checkCheckBox('side_walk', $data->tapak_condition) != 'checked') d-none @endif">
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
                            <input type="checkbox" name="tapak_condition[vehicle_entry]"
                                id="vehicle_entry" class="form-check"
                                {{ checkCheckBox('vehicle_entry', $data->tapak_condition) }}>
                            <label for="vehicle_entry">{{ __('messages.No_vehicle_entry_area') }}
                            </label>
                        </td>
                        <td>
                            <input type="file" name="tapak_no_vehicle_entry_img"
                                id="vehicle_entry-img"
                                class="form-control @if (checkCheckBox('vehicle_entry', $data->tapak_condition) != 'checked') d-none @endif">
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
                            <input type="checkbox" name="kawasan[bend]" id="area_bend"
                                class="form-check" {{ checkCheckBox('bend', $data->kawasan) }}>
                            <label for="area_bend">{{ __('messages.Bend') }}</label>
                        </td>
                        <td>
                            <input type="file" name="kawasan_bend_img" id="area_bend-img"
                                class="form-control @if (checkCheckBox('bend', $data->kawasan) != 'checked') d-none @endif">
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
                            
                            <input type="checkbox" name="kawasan[road]" id="area_road"
                                class="form-check" {{ checkCheckBox('road', $data->kawasan) }}>
                            <label for="area_road"> {{ __('messages.Road') }}</label>
                        </td>
                        <td>
                            <input type="file" name="kawasan_road_img" id="area_road-img"
                                class="form-control @if (checkCheckBox('road', $data->kawasan) != 'checked') d-none @endif">
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
                                class="form-check" {{ checkCheckBox('forest', $data->kawasan) }}>
                            <label for="area_forest">{{ __('messages.Forest') }} </label>
                        </td>
                        <td>
                            <input type="file" name="kawasan_forest_img" id="area_forest-img"
                                class="form-control @if (checkCheckBox('forest', $data->kawasan) != 'checked') d-none @endif">
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
                            <input type="checkbox" name="kawasan[other]" id="area_other"
                                class="form-check" {{ checkCheckBox('other', $data->kawasan) }}>
                            <label for="area_other">{{ __('messages.others') }} </label>
                            @if (checkCheckBox('other', $data->kawasan) != 'checked')
                            @endif
                            <input type="text" name="kawasan[other_value]"
                                value="{{ checkCheckBox('other', $data->kawasan) != 'checked' ? '' : $data->kawasan['other'] }}"
                                id="area_other-input"
                                class="form-control {{ checkCheckBox('other', $data->kawasan) != 'checked' ? 'd-none' : '' }}"
                                required placeholder="(please state)">
                        </td>
                        <td>
                            <input type="file" name="kawasan_other_img" id="area_other-img"
                                class="form-control @if (checkCheckBox('other', $data->kawasan) != 'checked') d-none @endif">
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
                                    <div class="col-md-6"><label
                                            for="jarak_kelegaan">{{ __('messages.Clearance_Distance') }}</label></div>
                                    <div class="col-md-6"><input type="number" name="jarak_kelegaan"
                                            value="{{ $data->jarak_kelegaan }}" id="jarak_kelegaan"
                                            class="form-control"></div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6"><label for="">
                                            {{ __('messages.Line_clearance_specifications') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 d-flex">
                                                <input type="radio" name="talian_spec" id="line-comply"
                                                    {{ $data->talian_spec == 'comply' ? 'checked' : '' }} value="comply"
                                                    class="form-check"><label for="line-comply">
                                                    {{ __('messages.Comply') }}</label>
                                            </div>

                                            <div class="col-md-6 d-flex">
                                                <input type="radio" name="talian_spec"
                                                    {{ $data->talian_spec == 'uncomply' ? 'checked' : '' }}
                                                    value="uncomply" id="line-disobedient" class="form-check">
                                                <label for="line-disobedient"> Uncomply </label>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            {{-- END Heigh Clearance (4) --}}



                            <h3>{{ __('messages.Kebocoran_Arus') }}</h3>




                            {{-- START Kebocoran Arus (5) --}}

                            <fieldset class="form-input">


                                <div class="row">
                                    <div class="col-md-4"><label
                                            for="">{{ __('messages.Inspection_of_current_leakage_on_the_pole') }}
                                        </label></div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="tiang_defect_current_leakage" id="arus_pada_tiang_no"
                                                    class="form-check" value="No"
                                                    {{ $data->arus_pada_tiang === 'No' ? 'checked' : '' }}>
                                                <label for="arus_pada_tiang_no">{{ __('messages.no') }}</label>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="tiang_defect_current_leakage" id="arus_pada_tiang_yes"
                                                    class="form-check" value="Yes"
                                                    {{ $data->arus_pada_tiang === 'Yes' ? 'checked' : '' }}>
                                                <label for="arus_pada_tiang_yes">{{ __('messages.yes') }}</label>
                                            </div>

                                            <div class="col-md-4 @if ($data->arus_pada_tiang == 'No' || $data->arus_pada_tiang == '') d-none @endif"
                                                id="arus_pada_tiang_amp_div">
                                                <label for="arus_pada_tiang_amp">{{ __('messages.Amp') }}</label>
                                                <input type="text" name="tiang_defect[current_leakage_val]" id="arus_pada_tiang_amp"
                                                    class="form-control" value="{{ $data->arus_pada_tiang_amp }}"
                                                    required>

                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-4"><label
                                            for="">{{ __('messages.Inspection_of_current_leakage_on_the_umbang') }}
                                        </label></div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="umbang_defect_current_leakage" id="arus_pada_umbgan_no"
                                                    class="form-check" value="No"
                                                    {{ array_key_exists('current_leakage' , $data->umbang_defect) && $data->umbang_defect['current_leakage'] === false ? 'checked' : '' }}>
                                                <label for="arus_pada_umbgan_no">{{ __('messages.no') }}</label>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="umbang_defect_current_leakage" id="arus_pada_umbgan_yes"
                                                    class="form-check" value="Yes"
                                                    {{ array_key_exists('current_leakage' , $data->umbang_defect) && $data->umbang_defect['current_leakage'] === true ? 'checked' : '' }}>

                                                <label for="arus_pada_umbgan_yes">{{ __('messages.yes') }}</label>
                                            </div>

                                            <div class="col-md-4 @if(!array_key_exists('current_leakage' , $data->umbang_defect) || $data->umbang_defect['current_leakage'] !== true) d-none @endif"
                                                id="arus_pada_umbgan_amp_div">
                                                <label for="arus_pada_tiang_amp">{{ __('messages.Amp') }}</label>
                                                <input type="text" name="umbang_defect[current_leakage_val]" id="arus_pada_tiang_amp"
                                                    class="form-control" value="{{array_key_exists('current_leakage_val' , $data->umbang_defect) ? $data->umbang_defect['current_leakage_val'] : ''}}"
                                                    required>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                            {{-- END Kebocoran Arus (5) --}}


                    



