<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class safety_controller extends Controller
{
    public function category() {
        $category = DB::select('select * from st_category order by category');
        return $category;        
    }

    public function code() {
        $code = DB::select('select * from st_codes order by category, code');
        return $code;        
    }

    public function addCode(Request $request){
        $check = DB::table('st_codes')
                    ->where('category', $request->category)
                    ->where('code', $request->code);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {
            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('st_codes')
            ->insert([
                'category' => $request->category,
                'code' => $request->code,
                'descr_eng' => $request->descr_eng,
                'descr_lao' => $request->descr_lao,
                'active' => $request->active,
                'created_at' => $datetime,
                'created_by' => $username
            ]);

            $success = true;
            $message = "Insert completed!";
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }
    public function updCode(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('st_codes')
            ->where('code_id', $request->code_id)
            ->update([
                'code' => $request->code,
                'descr_eng' => $request->descr_eng,
                'descr_lao' => $request->descr_lao,
                'active' => $request->active,
                'updated_at' => $datetime,
                'updated_by' => $username
            ]);
        
        // Update other related tables
        if ($request->code != $request->code_ori) {
            $table = $request->tbl_name;
            $column = $request->col_name;

            DB::table($table)
            ->where($column, $request->code_ori)
            ->update([
                $column => $request->code
            ]);

            // if ($request->category === 'Company') {
            //     $tables = ['lkp_departments'];
            //     $column = 'company';
            // } elseif ($request->category === 'Country') {
            //     $tables = ['lkp_province', 'lkp_district', 'lkp_village'];
            //     $column = 'country';
            // };

            // if ($tables) {
            //     foreach($tables as $table) {
            //         DB::table($table)
            //         ->where($column, $request->code_ori)
            //         ->update([
            //             $column => $request->code
            //         ]);
            //     };
            // };
        };
    }
    public function delCode(Request $request){
        $table = $request->tbl_name;
        $column = $request->col_name;
        $check = DB::table($table)->where($column, $request->code);

        if ($check->count()) {
            $success = false;
            $message = 'This code has already been used; it cannot be deleted.';
        } else {

            DB::table('st_codes')->where('code_id', $request->code_id)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function year() {
        $year = DB::select('select distinct year(date_time) as value, year(date_time) as label from st_incidents order by 1 desc');
        return $year;
    }

    public function incident(Request $request) {
        $mode = $request->requestMode;
        $value = $request->requestValue;
        if ($mode == 'Month') {
            $incident = DB::select("select * from st_incidents where format(date_time,'yyyy-MM') = ? order by incident_id", [$value]);
            return $incident;
        } elseif ($mode == 'Year') {
            $incident = DB::select("select * from st_incidents where year(date_time) = ? order by incident_id", [$value]);
            return $incident;
        } else {
            $incident = DB::select("select * from st_incidents where convert(date, date_time, 121) between ? and ? order by incident_id", [$request->dateFr, $request->dateTo]);
            return $incident;
        };
    }

    public function incidentFile() {
        $file = DB::select('select * from st_incident_files order by incident_id, file_name');
        return $file;
    }

    public function incidentNextNo() {
        $nextNo = DB::select('select max(cast(incident_no as int)) + 1 as next from st_incidents where year(date_time) = year(getdate())');
        return $nextNo;
    }

    public function addIncident(Request $request){
        $check = DB::table('st_incidents')
                ->where('date_time', $request->date_time)
                ->where('incident_title', $request->incident_title);

        if ($check->count()){
            $success = false;
            $message = 'This incident already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            $max = DB::table('st_incidents')->max('incident_id');
            $newId = $max + 1;
            $id = substr(str_repeat(0, 4).$newId, - 4);

            DB::table('st_incidents')
            ->insert([
                'incident_id' => $id,
                'incident_title' => $request->incident_title,
                'date_time' => $request->date_time,
                'location' => $request->location,
                'company' => $request->company,
                'department' => $request->department,
                'incident_group' => $request->incident_group,
                'incident_type' => $request->incident_type,
                'injury_type' => $request->injury_type,
                'injury_group' => $request->injury_group,
                'injury_part' => $request->injury_part,
                'significant' => $request->significant,
                'flash_alert' => $request->flash_alert,
                'actual_severity' => $request->actual_severity,
                'potential_severity' => $request->potential_severity,
                'risk_rating' => $request->risk_rating,
                'invest_status' => $request->invest_status,
                'invest_lead' => $request->invest_lead,
                'action_status' => $request->action_status,
                'action_duedate' => $request->action_duedate,
                'incident_manager' => $request->incident_manager,
                'followup_by' => $request->followup_by,
                'corrective_action' => $request->corrective_action,
                'incident_descr' => $request->incident_descr,
                'created_at' => $datetime,
                'created_by' => $username
            ]);

            // Add attachments
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = $id.'-'.$file->getClientOriginalName();
                    $file->move('assets/images/incidents/', $fileName);
                    $fileSize = (round(filesize('assets/images/incidents/'.$fileName)/1024,0)).' KB';

                    DB::table('st_incident_files')
                    ->insert([
                        'incident_id' => $id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => strtolower($file->getClientOriginalExtension()),
                        'new_name' => $fileName,
                        'size' => $fileSize
                    ]); 
                }
            }

            $success = true;
            $message = 'Insert completed!';
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function updIncident(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);

        DB::table('st_incidents')
        ->where('data_id', $request->data_id)
        ->update([
            'incident_title' => $request->incident_title,
            'date_time' => $request->date_time,
            'location' => $request->location,
            'company' => $request->company,
            'department' => $request->department,
            'incident_group' => $request->incident_group,
            'incident_type' => $request->incident_type,
            'injury_type' => $request->injury_type,
            'injury_group' => $request->injury_group,
            'injury_part' => $request->injury_part,
            'significant' => $request->significant,
            'flash_alert' => $request->flash_alert,
            'actual_severity' => $request->actual_severity,
            'potential_severity' => $request->potential_severity,
            'risk_rating' => $request->risk_rating,
            'invest_status' => $request->invest_status,
            'invest_lead' => $request->invest_lead,
            'action_status' => $request->action_status,
            'action_duedate' => $request->action_duedate,
            'incident_manager' => $request->incident_manager,
            'followup_by' => $request->followup_by,
            'corrective_action' => $request->corrective_action,
            'incident_descr' => $request->incident_descr,
            'updated_at' => $datetime,
            'updated_by' => $username
        ]);

        // Add attachments
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = $request->incident_id.'-'.$file->getClientOriginalName();
                $file->move(('assets/images/incidents/'), $fileName);
                $fileSize = (round(filesize('assets/images/incidents/'.$fileName)/1024,0)).' KB';

                DB::table('st_incident_files')
                ->insert([
                    'incident_id' => $request->incident_id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => strtolower($file->getClientOriginalExtension()),
                    'new_name' => $fileName,
                    'size' => $fileSize
                ]); 
            }
        };
    }

    public function delIncident(Request $request){
        DB::table('st_incidents')->where('incident_id', $request->incident_id)->delete();
        DB::table('st_incident_files')->where('incident_id', $request->incident_id)->delete();

        foreach($request->fileList as $list) {
            if(file_exists('assets/images/incidents/'.$list['new_name'])){
                unlink('assets/images/incidents/'.$list['new_name']);
            };
        };   
    }

    public function downloadIncidentFile($file){
        return response()->download('assets/images/incidents/'.$file);
    }

    public function delFile(Request $request){
        DB::table('st_incident_files')->where('file_id', $request->file_id)->delete();

        if(file_exists('assets/images/incidents/'.$request->new_name)){
            unlink('assets/images/incidents/'.$request->new_name);
        }
    }










}
