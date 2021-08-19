<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reports;

use Illuminate\Support\Facades\Storage;

use App\Imports\ReportsImport;
use Maatwebsite\Excel\Facades\Excel;


class ReportsController extends Controller
{
    public function savePageReport(Request $request){

    	
    	$reports = [];
        if($fetched_reports = Reports::all()){
            foreach ($fetched_reports as $key => $report) {
                $reports[$key] = [
                    'date' => $report['date'],
                    'csv_rows_array' => json_decode($report['json_csv_rows'],true)
                ];
            }
        }
    	if($request->file('csv_upload_file')){
    		$path = $request->file('csv_upload_file')->storeAs(
    			'reports','report.csv'
    		);
            return view('reports',[
                'status' => 'Файл загружен.',
                'reports' => $reports
            ]);	
        }else{
                

            return view('reports',[
                'reports' => $reports
            ]);
        }
    }
    public function update_report_by_file(){
        
        $size = Storage::size('reports/report.csv');
        $path = Storage::path('reports/report.csv');

        $report_excel_array = Excel::toArray(new ReportsImport, 'reports/report.csv','local');
        $normalized_excel_array = [];
        foreach ($report_excel_array[0] as $num => $row) {
            if($num > 2 && $num < count($report_excel_array[0]) - 6){
                
                $str_col_parsed = '';
                $str_col_glue = '';
                $merged_rows = [];

                foreach ($row as $key => $col) {
                    if($col && isset($col[$key+1]) && $col[$key+1]>0 && $key < count($row)){
                        $str_col_parsed.=$col.';';
                    }else $str_col_parsed.=$col;
                    
                }
                foreach (explode(';', $str_col_parsed) as $i => $col) {
                    if($i > 16){
                        $str_col_glue.=$col.';';
                    }else $merged_rows[] = $col;
                }
                $merged_rows[] = $str_col_glue;

                $normalized_excel_array[] = [
                    'status' => $merged_rows[0],
                    'account_name' => $merged_rows[1],
                    'outter_id_client' => $merged_rows[2],
                    'manager_name' => $merged_rows[3],
                    'manager_id' => $merged_rows[4],
                    'account_type' => $merged_rows[5],
                    'clicks' => $merged_rows[6],
                    'shows' => $merged_rows[7],
                    'ctr' => $merged_rows[8],
                    'curency_code' => $merged_rows[9],
                    'average_price_per_click' => $merged_rows[10],
                    'currency_code_after_converter' => $merged_rows[11],
                    'average_price_per_click_after_converter' => $merged_rows[12],
                    'expences' => $merged_rows[13],
                    'cost_currency_after_converter' => $merged_rows[14],
                    'conversions' => $merged_rows[15],
                    'coefficent_conversions' => $merged_rows[16],
                    'account_label' => $merged_rows[17],
                ];
            }
        }
        
        $report = new Reports;
        $report->date = new \DateTime("NOW");
        $report->json_csv_rows = json_encode($normalized_excel_array,true);
        $report->save();
        

    }
}
