<?php

namespace App\Http\Controllers\web\excel;

use App\Http\Controllers\Controller;
use App\Models\Tiang;
use App\Models\TiangRepairDate;
use App\Traits\Filter;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class TiangExcelController extends Controller
{
    //
    use Filter;

    public function generateTiangExcel(Request $req)
    {
        try{
// return date('Y-m-d');


        $ba = $req->filled('ba') ? $req->ba : Auth::user()->ba;

        $result = Tiang::query();

       $result = $this->filter($result , 'review_date',$req);

            $defectsImg = ['pole_image_1', 'pole_image_2', 'pole_image_3', 'pole_image_4', 'pole_image_5'];


            $res = $result->whereNotNull('review_date')
            // ->join('savr_all_images', 'tbl_savr.id', '=', 'savr_all_images.id') // Replace 'your_model' with your actual table name
            // ->select(  'tbl_savr.*',  'savr_all_images.images as images' )
            ->get()
            ->makeHidden(['geom' , 'tiang_defect_image' , 'talian_defect_image' ,
             'umbang_defect_image' , 'ipc_defect_image' ,'jumper_image','kilat_defect_image',
             'servis_defect_image' ,'pembumian_defect_image','blackbox_defect_image','bekalan_dua_defect_image',
             'kaki_lima_defect_image','tapak_road_img','tapak_sidewalk_img','tapak_sidewalk_img','tapak_no_vehicle_entry_img','kawasan_bend_img',
            'kawasan_road_img' , 'kawasan_forest_img' , 'kawasan_other_img']);
            // return $res;

            $query = Tiang::select('fp_road as road')
            ->selectRaw("string_agg(fp_name, ' , ') as fp_name")
            ->selectRaw("SUM(CASE WHEN size_tiang = '7.5' THEN 1 ELSE 0 END) as size_tiang_75")
            ->selectRaw("SUM(CASE WHEN size_tiang = '9' THEN 1 ELSE 0 END) as size_tiang_9")
            ->selectRaw("SUM(CASE WHEN size_tiang = '10' THEN 1 ELSE 0 END) as size_tiang_10")
            ->selectRaw("SUM(CASE WHEN jenis_tiang = 'iron' THEN 1 ELSE 0 END) as jenis_tiang_iron")
            ->selectRaw("SUM(CASE WHEN jenis_tiang = 'concrete' THEN 1 ELSE 0 END) as jenis_tiang_concrete")
            ->selectRaw("SUM(CASE WHEN jenis_tiang = 'spun' THEN 1 ELSE 0 END) as jenis_tiang_spun")
            ->selectRaw("SUM(CASE WHEN jenis_tiang = 'wood' THEN 1 ELSE 0 END) as jenis_tiang_wood")
            ->selectRaw("SUM(CASE WHEN (abc_span->'s3_185')::text <> '' AND (abc_span->'s3_185')::text <> 'null' THEN 0 ELSE 1 END) as abc_s3186")
            ->selectRaw("SUM(CASE WHEN (abc_span->'s3_95')::text <> '' AND (abc_span->'s3_95')::text <> 'null' THEN 0 ELSE 1 END) as abc_s3195")
            ->selectRaw("SUM(CASE WHEN (abc_span->'s3_16')::text <> '' AND (abc_span->'s3_16')::text <> 'null' THEN 0 ELSE 1 END) as abc_s316")
            ->selectRaw("SUM(CASE WHEN (abc_span->'s1_16')::text <> '' AND (abc_span->'s1_16')::text <> 'null' THEN 0 ELSE 1 END) as abc_s116")
            ->selectRaw("SUM(CASE WHEN (pvc_span->'s19_064')::text <> '' AND (pvc_span->'s19_064')::text <> 'null' THEN 0 ELSE 1 END) as pvc_s9064")
            ->selectRaw("SUM(CASE WHEN (pvc_span->'s7_083')::text <> '' AND (pvc_span->'s7_083')::text <> 'null' THEN 0 ELSE 1 END) as pvc_s7083")
            ->selectRaw("SUM(CASE WHEN (pvc_span->'s7_044')::text <> '' AND (pvc_span->'s7_044')::text <> 'null' THEN 0 ELSE 1 END) as pvc_s7044")
            ->selectRaw("SUM(CASE WHEN (bare_span->'s7_173')::text <> '' AND (bare_span->'s7_173')::text <> 'null'THEN 0 ELSE 1 END) as bare_s7173")
            ->selectRaw("SUM(CASE WHEN (bare_span->'s7_122')::text <> '' AND (bare_span->'s7_122')::text <> 'null'THEN 0 ELSE 1 END) as bare_s7122")
            ->selectRaw("SUM(CASE WHEN (bare_span->'s3_132')::text <> '' AND (bare_span->'s3_132')::text <> 'null'THEN 0 ELSE 1 END) as bare_s7132")
            ->selectRaw("SUM(CASE WHEN (umbang_defect->'breaking')::text <> '' AND (bare_span->'breaking')::text <> 'null'THEN 0 ELSE 1 END) as bare_s7132")
            ->selectRaw("SUM(CASE WHEN (blackbox_defect->'cracked')::text = 'true' THEN 1 ELSE 0 END + CASE WHEN (blackbox_defect->'other')::text = 'true' THEN 1 ELSE 0 END) as blackbox")
            ->selectRaw("SUM(CASE WHEN (ipc_defect->'burn')::text = 'true' THEN 1 ELSE 0 END + CASE WHEN (ipc_defect->'other')::text = 'true' THEN 1 ELSE 0 END) as ipc")
            ->selectRaw("SUM(CASE WHEN (umbang_defect->'breaking')::text = 'true' THEN 1 ELSE 0 END + CASE WHEN (umbang_defect->'creepers')::text = 'true' THEN 1 ELSE 0 END
            + CASE WHEN (umbang_defect->'cracked')::text = 'true' THEN 1 ELSE 0 END + CASE WHEN (umbang_defect->'stay_palte')::text = 'true' THEN 1 ELSE 0 END + CASE WHEN (umbang_defect->'other')::text = 'true' THEN 1 ELSE 0 END
            ) as umbagan")

            ->selectRaw("SUM(CASE WHEN (talian_utama_connection)::text ='one' THEN 1 ELSE 0 END ) as service")
            ->selectRaw("MIN(section_from) as section_from")
            ->selectRaw("MAX(section_to) as section_to")

            ->whereNotNull('review_date')
            ->whereNotNull('fp_road');
                if ($ba != '') {
                    $query->where('ba',$ba);
                }

                if ($req->filled('from_date')) {
                    $query->where('review_date', '>=', $req->from_date);
                }

                if ($req->filled('to_date')) {
                    $query->where('review_date', '<=', $req->to_date);
                }

                $roadStatistics = $query->groupBy('fp_road' )->get();

         //  return $roadStatistics;



            if ($roadStatistics) {
                $excelFile = public_path('assets/excel-template/QR TIANG.xlsx');

                $spreadsheet = IOFactory::load($excelFile);

                $worksheet = $spreadsheet->getSheet(0);
                $worksheet->getStyle('B:AK')->getAlignment()->setHorizontal('center');
                $worksheet->getStyle('B:AL')->getFont()->setSize(9);


                $worksheet->setCellValue('D4', $ba);
                $i = 5;
                foreach ($roadStatistics as $rec) {
                    $worksheet->setCellValue('B' . $i, $i - 4);
                    $worksheet->setCellValue('G' . $i, $rec->fp_name);

                    $worksheet->setCellValue('H' . $i, $rec->road);

                    // $worksheet->setCellValue('F' . $i, $rec->fp_name);
                    $worksheet->setCellValue('I' . $i, $rec->section_from );
                    $worksheet->setCellValue('J' . $i, $rec->section_to);

                    $worksheet->setCellValue('K' . $i, $rec->size_tiang_75 );
                    $worksheet->setCellValue('L' . $i, $rec->size_tiang_9  );
                    $worksheet->setCellValue('M' . $i, $rec->size_tiang_10 );

                    $worksheet->setCellValue('N' . $i, $rec->jenis_tiang_spun );
                    $worksheet->setCellValue('O' . $i, $rec->jenis_tiang_concrete );
                    $worksheet->setCellValue('P' . $i, $rec->jenis_tiang_iron );
                    $worksheet->setCellValue('Q' . $i, $rec->jenis_tiang_wood );

                    $worksheet->setCellValue('R' . $i, $rec->abc_s3186 );
                    $worksheet->setCellValue('S' . $i, $rec->abc_s3195 );
                    $worksheet->setCellValue('T' . $i, $rec->abc_s316 );
                    $worksheet->setCellValue('U' . $i, $rec->abc_s116 );

                    $worksheet->setCellValue('V' . $i, $rec->pvc_s9064);
                    $worksheet->setCellValue('W' . $i, $rec->pvc_s7083);
                    $worksheet->setCellValue('X' . $i, $rec->pvc_s7044);

                    $worksheet->setCellValue('Y' . $i, $rec->bare_s7173 );
                    $worksheet->setCellValue('Z' . $i, $rec->bare_s7122 );
                    $worksheet->setCellValue('AA' . $i, $rec->bare_s7132 );

                    $one_line = Tiang::where('fp_road', $rec->road)
                    ->whereNotNull('talian_utama_connection')
                    ->where('talian_utama_connection' ,'main_line')
                    ->count();



                    ($rec->road);
                    $array = json_decode($rec, true);

                    // Sum the values
                    $totalSum = array_sum($array);
                    $worksheet->setCellValue('AB' . $i, $totalSum );
                    $worksheet->setCellValue('AC' . $i, $one_line > 0 ? 'M' : "S" );
                    $worksheet->setCellValue('AD' . $i, $rec->umbagan  );
                    $worksheet->setCellValue('AE' . $i, $rec->blackbox  );
                    $worksheet->setCellValue('AF' . $i, $rec->ipc  );
                    $worksheet->setCellValue('AG' . $i, $rec->service  );
                    $worksheet->setCellValue('AI' . $i, 'AEROSYNERGY'  );

                    $i++;
                }
                $worksheet->calculateColumnWidths();
                // SHeet 2

                $worksheet->calculateColumnWidths();


                $i = 9;
                $secondWorksheet = $spreadsheet->getSheet(1);
                $secondWorksheet->getStyle('B:AL')->getAlignment()->setHorizontal('center');
                $secondWorksheet->getStyle('B:AL')->getFont()->setSize(9);


                $secondWorksheet->setCellValue('C1', $ba);
                $secondWorksheet->setCellValue('B3', 'Tarikh Pemeriksaan : ' .date('Y-m-d'));

                //return $res;
                foreach ($res as $secondRec) {
                    // echo "test <br>";
                    $other_defects = '';

                    $secondWorksheet->setCellValue('B' . $i, $i - 8);
                    $secondWorksheet->setCellValue('F' . $i, $secondRec->fp_name);
                    $secondWorksheet->setCellValue('G' . $i, $secondRec->fp_road);
                    $secondWorksheet->setCellValue('H' . $i, $secondRec->section_from);
                    $secondWorksheet->setCellValue('I' . $i, $secondRec->section_to);
                    $secondWorksheet->setCellValue('J' . $i, $secondRec->tiang_no);

                    if ($secondRec->tiang_defect != '') {
                        $tiang_defect = json_decode($secondRec->tiang_defect);

                        $secondWorksheet->setCellValue('K' . $i,  excelCheckBOc('cracked', $tiang_defect));
                        $secondWorksheet->setCellValue('M' . $i, excelCheckBOc('leaning', $tiang_defect));
                        $secondWorksheet->setCellValue('O' . $i, excelCheckBOc('dim', $tiang_defect));

                        $other_defects .= excelCheckBOc('other_value', $tiang_defect) == '1'? $tiang_defect->other_value : '';
                        // $secondWorksheet->setCellValue('Q' . $i, excelCheckBOc('current_leakage', $tiang_defect));

                    }

                    if ($secondRec->talian_defect != '') {
                        $talian_defect = json_decode($secondRec->talian_defect);
                        $secondWorksheet->setCellValue('Q' . $i, excelCheckBOc('joint', $talian_defect));
                        $secondWorksheet->setCellValue('S' . $i, excelCheckBOc('need_rentis', $talian_defect));
                        $secondWorksheet->setCellValue('U' . $i, excelCheckBOc('ground', $talian_defect));
                        $other_defects .= excelCheckBOc('other_value', $talian_defect) == '1'? ' , '. $talian_defect->other_value : '';

                    }

                    if ($secondRec->umbang_defect != '') {
                        $umbang_defect = json_decode($secondRec->umbang_defect);
                        $secondWorksheet->setCellValue('W' . $i, excelCheckBOc('breaking', $umbang_defect));
                        $secondWorksheet->setCellValue('Y' . $i, excelCheckBOc('creepers', $umbang_defect));
                        $secondWorksheet->setCellValue('AA' . $i, excelCheckBOc('cracked', $umbang_defect));
                        $secondWorksheet->setCellValue('AC' . $i, excelCheckBOc('stay_palte', $umbang_defect));
                        $other_defects .= excelCheckBOc('other_value', $umbang_defect) == '1'?' , '. $umbang_defect->other_value : '';

                        // $secondWorksheet->setCellValue('Y' . $i, excelCheckBOc('current_leakage', $umbang_defect));
                    }
                    

                    if ($secondRec->ipc_defect != '') {
                        $ipc_defect = json_decode($secondRec->ipc_defect);
                        $secondWorksheet->setCellValue('AE' . $i, excelCheckBOc('burn', $ipc_defect));
                        $other_defects .= excelCheckBOc('other_value', $ipc_defect) == '1'?' , '. $ipc_defect->other_value : '';

                    }

                    if ($secondRec->blackbox_defect != '') {
                        $blackbox_defect = json_decode($secondRec->blackbox_defect);
                        $secondWorksheet->setCellValue('AG' . $i, excelCheckBOc('cracked', $blackbox_defect));
                        $other_defects .= excelCheckBOc('other_value', $blackbox_defect) == '1'?' , '. $blackbox_defect->other_value : '';

                    }

                    if ($secondRec->jumper != '') {
                        $jumper = json_decode($secondRec->jumper);
                        $secondWorksheet->setCellValue('AI' . $i, excelCheckBOc('sleeve', $jumper));
                        $secondWorksheet->setCellValue('AK' . $i, excelCheckBOc('burn', $jumper));
                        $other_defects .= excelCheckBOc('other_value', $jumper) == '1'?' , '. $jumper->other_value : '';

                    }

                    if ($secondRec->kilat_defect != '') {
                        $kilat_defect = json_decode($secondRec->kilat_defect);
                        $secondWorksheet->setCellValue('AM' . $i, excelCheckBOc('broken', $kilat_defect));
                        $other_defects .= excelCheckBOc('other_value', $kilat_defect) == '1'?' , '. $kilat_defect->other_value : '';

                    }

                    if ($secondRec->servis_defect != '') {
                        $servis_defect = json_decode($secondRec->servis_defect);
                        $secondWorksheet->setCellValue('AO' . $i, excelCheckBOc('roof', $servis_defect));
                        $secondWorksheet->setCellValue('AQ' . $i, excelCheckBOc('won_piece', $servis_defect));
                        $other_defects .= excelCheckBOc('other_value', $servis_defect) == '1'?' , '. $servis_defect->other_value : '';

                    }

                    if ($secondRec->pembumian_defect != '') {
                        $pembumian_defect = json_decode($secondRec->pembumian_defect);
                        $secondWorksheet->setCellValue('AS' . $i, excelCheckBOc('netural', $pembumian_defect));
                        $other_defects .= excelCheckBOc('other_value', $pembumian_defect) == '1'?' , '. $pembumian_defect->other_value : '';

                    }

                    if ($secondRec->bekalan_dua_defect != '') {
                        $bekalan_dua_defect =  json_decode($secondRec->bekalan_dua_defect);
                        $secondWorksheet->setCellValue('AU' . $i, excelCheckBOc('damage', $bekalan_dua_defect));
                        $other_defects .= excelCheckBOc('other_value', $bekalan_dua_defect) == '1'?' , '. $bekalan_dua_defect->other_value : '';

                    }

                    if ($secondRec->kaki_lima_defect != '') {
                        $kaki_lima_defect = json_decode($secondRec->kaki_lima_defect);
                        $secondWorksheet->setCellValue('AW' . $i, excelCheckBOc('date_wire', $kaki_lima_defect));
                        $secondWorksheet->setCellValue('AY' . $i, excelCheckBOc('burn', $kaki_lima_defect));
                        $other_defects .= excelCheckBOc('other_value', $kaki_lima_defect) == '1'?' , '. $kaki_lima_defect->other_value : '';

                    }
                    // $secondWorksheet->setCellValue('AK' . $i, $secondRec->total_defects);
                    $secondWorksheet->setCellValue('BA' . $i, $other_defects);

                    $secondWorksheet->setCellValue('BC' . $i, $secondRec->coords);
                    $secondWorksheet->setCellValue('BD' . $i, $secondRec->total_defects);

                    $images = '';
                    foreach ($defectsImg as $defImg) {
                        if ($secondRec->{$defImg} != '') {
                            $images .=' http://121.121.232.53:8090/'.$secondRec->{$defImg}; 

                        }
                    }
                    $secondWorksheet->setCellValue('BN' . $i, $images);
                    $repair_date = $rec->repair_date != ''?date('Y-m-d', strtotime($rec->repair_date)) : '';
                    $secondWorksheet->setCellValue('BF' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AN' . $i, $secondRec->remarks);
                    $secondWorksheet->setCellValue('BH' . $i, '');

                    $secondWorksheet->setCellValue('BL' . $i, $secondRec->id);
                    $secondWorksheet->setCellValue('BM' . $i, $secondRec->review_date);


                    $dates =  TiangRepairDate::where('savr_id', $secondRec->id)->select('name','date')->get();

                    $sortedDates = [];
    
                    foreach ($dates as $value) {
                        $sortedDates[$value->name] = $value->date;
                        // return getRepairDate('tiang_defect_dim' ,$sortedDates );
                        // return $sortedDates;
                    }
    
    
                    $secondWorksheet->setCellValue('L' . $i, getRepairDate('tiang_defect_cracked' ,$sortedDates ));
                    $secondWorksheet->setCellValue('N' . $i, getRepairDate('tiang_defect_leaning' ,$sortedDates ));
                    $secondWorksheet->setCellValue('P' . $i, getRepairDate('tiang_defect_dim' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('R' . $i, getRepairDate('talian_defect_joint' ,$sortedDates ));
                    $secondWorksheet->setCellValue('T' . $i, getRepairDate('talian_defect_need_rentis' ,$sortedDates ));
                    $secondWorksheet->setCellValue('V' . $i, getRepairDate('talian_defect_ground' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('X' . $i, getRepairDate('umbang_defect_breaking' ,$sortedDates ));
                    $secondWorksheet->setCellValue('Z' . $i, getRepairDate('umbang_defect_creepers' ,$sortedDates ));
                    $secondWorksheet->setCellValue('AB' . $i, getRepairDate('umbang_defect_cracked' ,$sortedDates ));
                    $secondWorksheet->setCellValue('AD' . $i, getRepairDate('umbang_defect_stay_palte' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('AF' . $i, getRepairDate('ipc_defect_burn' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('AH' . $i, getRepairDate('blackbox_defect_cracked' ,$sortedDates ));
                    
                    $secondWorksheet->setCellValue('AJ' . $i, getRepairDate('jumper_sleeve' ,$sortedDates ));
                    $secondWorksheet->setCellValue('AL' . $i, getRepairDate('jumper_burn' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('AN' . $i, getRepairDate('kilat_defect_broken' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('AP' . $i, getRepairDate('servis_defect_roof' ,$sortedDates ));
                    $secondWorksheet->setCellValue('AR' . $i, getRepairDate('servis_defect_won_piece' ,$sortedDates ));
                    
                    $secondWorksheet->setCellValue('AT' . $i, getRepairDate('pembumian_defect_netural' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('AV' . $i, getRepairDate('bekalan_dua_defect_damage' ,$sortedDates ));
    
                    $secondWorksheet->setCellValue('AX' . $i, getRepairDate('kaki_lima_defect_date_wire' ,$sortedDates ));
                    $secondWorksheet->setCellValue('AZ' . $i, getRepairDate('kaki_lima_defect_burn' ,$sortedDates ));
                    // $secondWorksheet->setCellValue('BB' . $i, getRepairDate('talian_defect_ground' ,$sortedDates ));
    


                    // $secondWorksheet->setCellValue('L' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('N' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('P' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('R' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('T' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('V' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('X' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('Z' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AB' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AD' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AF' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AH' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AJ' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AL' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AN' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AP' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AR' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AT' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AV' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AX' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('AZ' . $i, $repair_date);
                    // $secondWorksheet->setCellValue('BB' . $i, $repair_date);


                    $i++;
                }
                $secondWorksheet->calculateColumnWidths();
                //sheet 3



                $i = 5;
                $thirdWorksheet = $spreadsheet->getSheet(2);



                $thirdWorksheet->getStyle('A:O')->getAlignment()->setHorizontal('center');
                $secondWorksheet->getStyle('B:AL')->getFont()->setSize(9);


           
                foreach ($res as $rec) {
                    $thirdWorksheet->setCellValue('A' . $i, $i - 4);
                    $thirdWorksheet->setCellValue('B' . $i, $rec->review_date);
                    $thirdWorksheet->setCellValue('C' . $i, $rec->fp_name);
                    $thirdWorksheet->setCellValue('D' . $i, $rec->section_from);
                    $thirdWorksheet->setCellValue('E' . $i, $rec->section_to);


                    // $thirdWorksheet->getStyle('B'.$i)



                    if ($rec->tapak_condition != '') {
                        $tapak_condition = json_decode($rec->tapak_condition);
                        $thirdWorksheet->setCellValue('F' . $i, excelCheckBOc('road', $tapak_condition) == '1' ?'/' : '' );
                        $thirdWorksheet->setCellValue('G' . $i, excelCheckBOc('side_walk', $tapak_condition) == '1' ? '/' : '' );
                        $thirdWorksheet->setCellValue('H' . $i, excelCheckBOc('vehicle_entry', $tapak_condition) == '1' ? '/' : '' );
                    }

                    if ($rec->kawasan != '') {
                        $kawasan = json_decode($rec->kawasan);
                        $thirdWorksheet->setCellValue('I' . $i, excelCheckBOc('bend', $kawasan) == '1' ? '/' : '' );
                        $thirdWorksheet->setCellValue('J' . $i, excelCheckBOc('raod', $kawasan) == '1' ? '/' : '' );
                        $thirdWorksheet->setCellValue('K' . $i, excelCheckBOc('forest', $kawasan) == '1' ? '/' : '' );
                        $thirdWorksheet->setCellValue('L' . $i, excelCheckBOc('other', $kawasan) == '1' ? '/' : '' );
                    }

                    $thirdWorksheet->setCellValue('M' . $i, $rec->jarak_kelegaan);

                    if ($rec->talian_spec != '') {
                        $thirdWorksheet->setCellValue('N' . $i, $rec->talian_spec == "comply" ? '/' : '');
                        $thirdWorksheet->setCellValue('O' . $i, $rec->talian_spec == "uncomply" ? '/' : '');
                    }

                    $thirdWorksheet->setCellValue('P' . $i, $rec->arus_pada_tiang == "Yes" ? '/' : '');
                    $thirdWorksheet->setCellValue('S' . $i, 'AEROSYNERGY SOLUTIONS');
                    $thirdWorksheet->setCellValue('T' . $i, $rec->fp_road);
                    $thirdWorksheet->setCellValue('U' . $i, $rec->coords);



                    $i++;
                }

                // foreach (range('A','AZ') as $col) {
                //     $thirdWorksheet->getColumnDimension($col)->setAutoSize(true);
                //     $secondWorksheet ->getColumnDimension($col)->setAutoSize(true);
                //     $worksheet ->getColumnDimension($col)->setAutoSize(true);

                //  }
                // dump($spreadsheet->getSheetNames());
                // return;
                $thirdWorksheet->calculateColumnWidths();
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

                $filename = 'qr-tiang-talian'.rand(2,10000).'.xlsx';
                $writer->save(public_path('assets/updated-excels/') . $filename);
                return response()->download(public_path('assets/updated-excels/') . $filename)->deleteFileAfterSend(true);

            } else {
                return redirect()
                    ->back()
                    ->with('failed', 'No records found ');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()
                ->back()
                ->with('failed', 'Request Failed');
        }
    }
}
