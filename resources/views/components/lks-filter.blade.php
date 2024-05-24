<style>
    .row{
        border: 0px;
    }
</style>

<div class="col-12">
    <div id="collapseQr">
        <div class="card card-body">
            <form action="#" target="_blank"  id="generate-lks-form"
                  method="post">
                @csrf
                <div class="row form-input ">
                    <div class=" col-md-2">
                        <label for="excelZone">Zone :</label>
                        <select name="excelZone" id="excelZone" class="form-control" onchange="getBa(this.value)">
                            <option value="{{ Auth::user()->zone }}" hidden>
                                {{ Auth::user()->zone != '' ? Auth::user()->zone : 'Select Zone' }}
                            </option>
                            @if (Auth::user()->zone == '')
                                <option value="W1">W1</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="B4">B4</option>
                            @endif
                        </select>
                    </div>
                    <div class=" col-md-2">
                        <label for="excelBa">BA :</label>
                        <select name="ba" id="excelBa" class="form-control">
                            <option value="{{ Auth::user()->ba }}" hidden>
                                {{ Auth::user()->ba != '' ? Auth::user()->ba : 'Select BA' }} </option>

                        </select>
                    </div>


                    <div class=" col-md-2">
                        <label for="excel_from_date">From Date : </label>
                        <input type="date" name="from_date" id="excel_from_date"
                            class="form-control" onchange="setMinDate(this.value)">
                    </div>
                    <div class=" col-md-2">
                        <label for="excel_to_date">To Date : </label>
                        <input type="date" name="to_date" id="excel_to_date" onchange="setMaxDate(this.value)" class="form-control">
                    </div>
                    <input type="hidden" readonly name="defect" id="form_defect_name">
                    @isset($buttons)
                        <div class="col-md-1 pt-2 ">

                            <button type="button" class="btn text-white btn-sm mt-4 " class="form-control"
                                style="background-color: #708090" onclick="$('#excel_to_date ,#excel_from_date').val('')">Reset</button>
                        </div>

                        @foreach ($buttons as $button)
                            <div class="col-md-2 pt-2 ">

                                <button type="button" class="btn text-white btn-sm mt-4 " class="form-control submit-button"  
                                    style="background-color: #708090"  value="{{$button['url']}}" onclick="submitForm('{{$button['url']}}')" >{{$button['name']}}</button>
                            </div>
                        @endforeach

                    @endisset

                    @isset($modalButton)
                        <div class="col-md-2 pt-2 ">
                            <button type="button" class="btn btn-sm btn-secondary mt-4"  data-toggle="modal" data-target="#pembersihanModal"> Pembersihan By Defect</button>
                          
                        </div>
                    @endisset

            </form>
        </div>
    </div>
</div>


@isset($defects)
<div class="modal fade" id="pembersihanModal">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Generate Pembersihan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
    

                <div class="modal-body">
                   <label for="">Select Defect</label>
                    <select   id="defect_name" class="form-control" required>
                        <option value="" hidden>select</option>
                        
                            @forelse ($defects as $defect)
                                <option value="{{$defect}}">{{str_replace('_',' ',$defect)}}</option>
                            @endforeach
                        
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="$('#form_defect_name').val($('#defect_name').val()); submitForm('{{$modalButton}}')" >Generate</button>
                </div>
        

        </div>
    </div>
</div>
@endisset