<?php

namespace App\Http\Controllers\web\excel;

use App\Http\Controllers\Controller;
use App\Models\Tiang;
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

      //  $result = $this->filter($result , 'review_date',$req);

        if ($req->filled('ba')) {
         $result->where('ba', $ba);
        }

        if ($req->filled('from_date')) {
            $result->where('review_date', '>=', $req->from_date);
        }

        if ($req->filled('to_date')) {
            $result->where('review_date', '<=', $req->to_date);
        }


            $res = $result->whereNotNull('review_date')
            ->join('savr_all_images', 'tbl_savr.id', '=', 'savr_all_images.id') // Replace 'your_model' with your actual table name
            ->select(  'tbl_savr.*',  'savr_all_images.images as images' )
            ->get()
            ->makeHidden(['geom' , 'tiang_defect_image' , 'talian_defect_image' ,
             'umbang_defect_image' , 'ipc_defect_image' ,'jumper_image','kilat_defect_image',
             'servis_defect_image' ,'pembumian_defect_image','blackbox_defect_image','bekalan_dua_defect_image',
             'kaki_lima_defect_image','tapak_road_img','tapak_sidewalk_img','tapak_sidewalk_img','tapak_no_vehicle_entry_img','kawasan_bend_img',
            'kawasan_road_img' , 'kawasan_forest_img' , 'kawasan_other_img']);
            // return $res;

            $query = Tiang::select('fp_road as road')
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
                $i = 8;
                foreach ($roadStatistics as $rec) {
                    $worksheet->setCellValue('B' . $i, $i - 7);
                    $worksheet->setCellValue('H' . $i, $rec->road);
                    // $worksheet->setCellValue('F' . $i, $rec->fp_name);
                    // $worksheet->setCellValue('I' . $i, $rec->section_from );
                    // $worksheet->setCellValue('J' . $i, $rec->section_to);

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

                    $worksheet->setCellValue('X' . $i, $rec->bare_s7173 );
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


                $i = 8;
                $secondWorksheet = $spreadsheet->getSheet(1);
                $secondWorksheet->getStyle('B:AL')->getAlignment()->setHorizontal('center');
                $secondWorksheet->getStyle('B:AL')->getFont()->setSize(9);


                $secondWorksheet->setCellValue('C1', $ba);
                $secondWorksheet->setCellValue('B3', 'Tarikh Pemeriksaan : ' .date('Y-m-d'));

                //return $res;
                foreach ($res as $secondRec) {
                    // echo "test <br>";

                    $secondWorksheet->setCellValue('B' . $i, $i - 7);
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
                        // $secondWorksheet->setCellValue('Q' . $i, excelCheckBOc('current_leakage', $tiang_defect));

                    }

                    if ($secondRec->talian_defect != '') {
                        $talian_defect = json_decode($secondRec->talian_defect);
                        $secondWorksheet->setCellValue('Q' . $i, excelCheckBOc('joint', $talian_defect));
                        $secondWorksheet->setCellValue('S' . $i, excelCheckBOc('need_rentis', $talian_defect));
                        $secondWorksheet->setCellValue('U' . $i, excelCheckBOc('ground', $talian_defect));
                    }

                    if ($secondRec->umbang_defect != '') {
                        $umbang_defect = json_decode($secondRec->umbang_defect);
                        $secondWorksheet->setCellValue('W' . $i, excelCheckBOc('breaking', $umbang_defect));
                        $secondWorksheet->setCellValue('Y' . $i, excelCheckBOc('creepers', $umbang_defect));
                        $secondWorksheet->setCellValue('AA' . $i, excelCheckBOc('cracked', $umbang_defect));
                        $secondWorksheet->setCellValue('AC' . $i, excelCheckBOc('stay_palte', $umbang_defect));
                        // $secondWorksheet->setCellValue('Y' . $i, excelCheckBOc('current_leakage', $umbang_defect));
                    }

                    if ($secondRec->ipc_defect != '') {
                        $secondWorksheet->setCellValue('AE' . $i, excelCheckBOc('burn', json_decode($secondRec->ipc_defect)));
                    }

                    if ($secondRec->blackbox_defect != '') {
                        $secondWorksheet->setCellValue('AG' . $i, excelCheckBOc('cracked', json_decode($secondRec->blackbox_defect)));
                    }

                    if ($secondRec->jumper != '') {
                        $jumper = json_decode($secondRec->jumper);
                        $secondWorksheet->setCellValue('AI' . $i, excelCheckBOc('sleeve', $jumper));
                        $secondWorksheet->setCellValue('AK' . $i, excelCheckBOc('burn', $jumper));
                    }

                    if ($secondRec->kilat_defect != '') {
                        $secondWorksheet->setCellValue('AM' . $i, excelCheckBOc('broken', json_decode($secondRec->kilat_defect)));
                    }

                    if ($secondRec->servis_defect != '') {
                        $servis_defect = json_decode($secondRec->servis_defect);
                        $secondWorksheet->setCellValue('AO' . $i, excelCheckBOc('roof', $servis_defect));
                        $secondWorksheet->setCellValue('AQ' . $i, excelCheckBOc('won_piece', $servis_defect));
                    }

                    if ($secondRec->pembumian_defect != '') {
                        $secondWorksheet->setCellValue('AS' . $i, excelCheckBOc('netural', json_decode($secondRec->pembumian_defect)));
                    }

                    if ($secondRec->bekalan_dua_defect != '') {
                        $secondWorksheet->setCellValue('AU' . $i, excelCheckBOc('damage', json_decode($secondRec->bekalan_dua_defect)));
                    }

                    if ($secondRec->kaki_lima_defect != '') {
                        $kaki_lima_defect = json_decode($secondRec->kaki_lima_defect);
                        $secondWorksheet->setCellValue('AW' . $i, excelCheckBOc('date_wire', $kaki_lima_defect));
                        $secondWorksheet->setCellValue('AY' . $i, excelCheckBOc('burn', $kaki_lima_defect));
                    }
                    // $secondWorksheet->setCellValue('AK' . $i, $secondRec->total_defects);
                    $secondWorksheet->setCellValue('BL' . $i, $secondRec->images);
                    $secondWorksheet->setCellValue('BC' . $i, $secondRec->coords);
                    $repair_date = $rec->repair_date != ''?date('Y-m-d', strtotime($rec->repair_date)) : '';
                    $secondWorksheet->setCellValue('BF' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AN' . $i, $secondRec->remarks);


                    $secondWorksheet->setCellValue('L' . $i, $repair_date);
                    $secondWorksheet->setCellValue('N' . $i, $repair_date);
                    $secondWorksheet->setCellValue('P' . $i, $repair_date);
                    $secondWorksheet->setCellValue('R' . $i, $repair_date);
                    $secondWorksheet->setCellValue('T' . $i, $repair_date);
                    $secondWorksheet->setCellValue('V' . $i, $repair_date);
                    $secondWorksheet->setCellValue('X' . $i, $repair_date);
                    $secondWorksheet->setCellValue('Z' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AB' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AD' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AF' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AH' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AJ' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AL' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AN' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AP' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AR' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AT' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AV' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AX' . $i, $repair_date);
                    $secondWorksheet->setCellValue('AZ' . $i, $repair_date);
                    $secondWorksheet->setCellValue('BB' . $i, $repair_date);


                    $i++;
                }
                $secondWorksheet->calculateColumnWidths();
                //sheet 3
                // return;
                //$i = 11



                $i = 11;
                $thirdWorksheet = $spreadsheet->getSheet(2);

                //                 $commonStyle = $thirdWorksheet->getDefaultStyle()->getAlignment();
                // $commonStyle->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // $commonStyle->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // // Set font size for all cells
                // $commonStyle->setFont(['size' => 12]);


                $thirdWorksheet->getStyle('A:O')->getAlignment()->setHorizontal('center');
                $secondWorksheet->getStyle('B:AL')->getFont()->setSize(9);


                // $borderStyle = [
                //     'borders' => [
                //         'outline' => [
                //             'borderStyle' => Border::BORDER_THICK,
                //             'color' => ['argb' => 'FFFF0000'], // You can adjust the color code as needed
                //         ],
                //     ],
                // ];

                // $thirdWorksheet->getStyle('A:O')->applyFromArray($borderStyle);
                // $thirdWorksheet->getStyle('A:O')->getBorders()
                // ->getOutline()
                // ->setBorderStyle(Border::BORDER_THICK)
                // ->setColor(new Color('FFFF0000'));

                // $thirdWorksheet->getStyle('A:O')->applyFromArray([
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //     ],
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //         ],
                //     ],
                // ]);
                // $thirdWorksheet->setCellValue('K4' , date('Y-m-d'));

                foreach ($res as $rec) {
                    $thirdWorksheet->setCellValue('A' . $i, $i - 10);
                    $thirdWorksheet->setCellValue('B' . $i, $rec->review_date);
                    $thirdWorksheet->setCellValue('C' . $i, $rec->fp_name);
                    $thirdWorksheet->setCellValue('D' . $i, $rec->section_from);
                    $thirdWorksheet->setCellValue('E' . $i, $rec->section_to);


                    // $thirdWorksheet->getStyle('B'.$i)



                    if ($rec->tapak_condition != '') {
                        $tapak_condition = json_decode($rec->tapak_condition);
                        $thirdWorksheet->setCellValue('F' . $i, excelCheckBOc('road', $tapak_condition) == '1' ?? '/' );
                        $thirdWorksheet->setCellValue('G' . $i, excelCheckBOc('side_walk', $tapak_condition) == '1' ?? '/' );
                        $thirdWorksheet->setCellValue('H' . $i, excelCheckBOc('vehicle_entry', $tapak_condition) == '1' ?? '/' );
                    }

                    if ($rec->kawasan != '') {
                        $kawasan = json_decode($rec->kawasan);
                        $thirdWorksheet->setCellValue('I' . $i, excelCheckBOc('bend', $kawasan) == '1' ?? '/' );
                        $thirdWorksheet->setCellValue('J' . $i, excelCheckBOc('raod', $kawasan) == '1' ?? '/' );
                        $thirdWorksheet->setCellValue('K' . $i, excelCheckBOc('forest', $kawasan) == '1' ?? '/' );
                        $thirdWorksheet->setCellValue('L' . $i, excelCheckBOc('other', $kawasan) == '1' ?? '/' );
                    }

                    $thirdWorksheet->setCellValue('M' . $i, $rec->jarak_kelegaan);

                    if ($rec->talian_spec != '') {
                        $thirdWorksheet->setCellValue('N' . $i, $rec->talian_spec == "comply" ? '/' : '');
                        $thirdWorksheet->setCellValue('O' . $i, $rec->talian_spec == "uncomply" ? '/' : '');
                    }

                    $thirdWorksheet->setCellValue('O' . $i, $rec->arus_pada_tiang == "Yes" ? '1' : '');
                    $thirdWorksheet->setCellValue('S' . $i, 'AEROSYNERGY SOLUTIONS');
                    $thirdWorksheet->setCellValue('S' . $i, $rec->fp_road);
                    $thirdWorksheet->setCellValue('S' . $i, $rec->coords);



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

                $writer->save(public_path('assets/updated-excels/') . 'qr-tiang-talian.xlsx');
              //  ob_end_clean();
                return response()->download(public_path('assets/updated-excels/') . 'qr-tiang-talian.xlsx');
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
