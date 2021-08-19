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
    	if($request->file('csv_upload_file')){
    		$path = $request->file('csv_upload_file')->storeAs(
    			'reports','report.csv'
    		);
            return view('reports',[
                'status' => 'Файл загружен.',
                'reports' => $reports
            ]);	
        }else{
                
            if($fetched_reports = Reports::all()){
                foreach ($fetched_reports as $key => $report) {
                    $reports[$key] = [
                        'date' => $report['date'],
                        'csv_rows_array' => json_decode($report['json_csv_rows'],true)
                    ];
                }
            }

            return view('reports',[
                'reports' => $reports
            ]);
        }
    }
    public function cron_update_report_by_fyle(){
        $size = Storage::size('reports/report.csv');
        $path = Storage::path('reports/report.csv');

        $array = Excel::toArray(new ReportsImport, 'reports/report.csv','local',\Maatwebsite\Excel\Excel::CSV);
        print_r($array);

    }
}
