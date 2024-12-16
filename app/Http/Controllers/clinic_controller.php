<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class clinic_controller extends Controller
{
    public function category() {
        $category = DB::select('select * from clinic_category order by category');
        return $category;
    }

    public function code() {
        $code = DB::select('select * from clinic_codes order by category, code');
        return $code;
    }

    public function patient() {
        $patient = DB::select("select concat(name, ' ', surname) as fullname, * from clinic_patients order by name, surname");
        return $patient;
    }

    public function addCode(Request $request){
        $check = DB::table('clinic_codes')
                ->where('category', $request->category)
                ->where('code', $request->code);

        if ($check->count()){
            $success = false;
            $message = 'This code already exists in the database!';
        } else {

            $datetime = now('Asia/Bangkok')->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            DB::table('clinic_codes')
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

    public function updateCode(Request $request){
        $datetime = now('Asia/Bangkok')->toDateTimeString();
        $username = Str::lower(auth()->user()->username);
        
        DB::table('clinic_codes')
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
        if ($request->code !== $request->code_old && $request->tbl_name) {
            DB::table($request->tbl_name)
                ->where($request->col_name, $request->code_old)
                ->update([$request->col_name => $request->code]);
        }
    }

    public function deleteCode(Request $request){
        $check = DB::table($request->tbl_name)->where($request->col_name, $request->code);
        if ($check->count()) {
            $success = false;
            $message = 'This code has already been used; it cannot be deleted.';
        } else {

            DB::table('clinic_codes')->where('code_id', $request->code_id)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function medicine() {
        $medicine = DB::select('select a.*, b.descr_eng as unit_eng, b.descr_lao as unit_lao from clinic_medicines a, clinic_codes b where b.code_id = a.unit_id order by a.medicine_eng');
        return $medicine;        
    }

    public function addMedicine(Request $request){
        $check = DB::table('clinic_medicines')->where('medicine_eng', $request->medicine_eng);
        if ($check->count()){
            $success = false;
            $message = 'This medicine already exists in the database!';
        } else {

            DB::table('clinic_medicines')
                ->insert([
                    'medicine_eng' => $request->medicine_eng,
                    'medicine_lao' => $request->medicine_lao,
                    'descr' => $request->descr,
                    'unit_id' => $request->unit_id,
                    'unit_price' => $request->unit_price,
                    'min_remind' => $request->min_remind,
                    'created_at' => now('Asia/Bangkok')->toDateTimeString(),
                    'created_by' => auth()->user()->username,
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

    public function updateMedicine(Request $request){
        DB::table('clinic_medicines')
            ->where('medicine_id', $request->medicine_id)
            ->update([
                'medicine_eng' => $request->medicine_eng,
                'medicine_lao' => $request->medicine_lao,
                'descr' => $request->descr,
                'unit_id' => $request->unit_id,
                'unit_price' => $request->unit_price,
                'min_remind' => $request->min_remind,
                'updated_at' => now('Asia/Bangkok')->toDateTimeString(),
                'updated_by' => auth()->user()->username,
        ]);
    }

    public function deleteMedicine(Request $request){
        $check = DB::table('clinic_medications')->where('medicine_id', $request->medicine_id);
        if ($check->count()) {
            $success = false;
            $message = 'This medicine has already been used; it cannot be deleted.';
        } else {

            DB::table('clinic_medicines')->where('medicine_id', $request->medicine_id)->delete();

            $success = true;
            $message = "Delete completed.";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function addPatient(Request $request){
        $p = $request->patient;
        $t = $request->treatment;

        $check = DB::table('clinic_patients')
                    ->where('name', $p['name'])
                    ->where('surname', $p['surname']);

        if ($check->count()){
            $success = false;
            $message = 'This name and surname already exists in the database.';
        } else {

            $datetime = now("Asia/Bangkok")->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            // Patient
            $patientId = DB::table('clinic_patients')->max('patient_id') + 1;
            DB::table('clinic_patients')
                ->insert([
                    'patient_id' => $patientId,
                    'sex' => $p['sex'],
                    'name' => $p['name'],
                    'surname' => $p['surname'],
                    'company' => $p['company'],
                    'department' => $p['department'],
                    'position' => $p['position'],
                    'employee_id' => $p['employee_id'],
                    'age' => $p['age'],
                    'blood_group' => $p['blood_group'],
                    'phone' => $p['phone'],
                    'disease' => $p['disease'],
                    'drug_allergy' => $p['drug_allergy'],
                    'note' => $p['note'],
                    'created_at' => $datetime,
                    'created_by' => $username
                ]);
            
            
            // Treatment
            $treatmentId = DB::table('clinic_treatments')->max('treatment_id') + 1;
            DB::table('clinic_treatments')
                ->insert([
                    'treatment_id' => $treatmentId,
                    'patient_id' => $patientId,
                    'date_time' => $t['date_time'],
                    'medical_type' => $t['medical_type'],
                    'injury_type' => $t['injury_type'],
                    'injury_part' => $t['injury_part'] ? implode(', ', $t['injury_part']) : null,
                    'work_related' => $t['work_related'],
                    'temp_c' => $t['temp_c'],
                    'blood_press' => $t['blood_press'],
                    'puls' => $t['puls'],
                    'oxigen' => $t['oxigen'],
                    'weight' => $t['weight'],
                    'syndrome' => $t['syndrome'],
                    'diagnosis' => $t['diagnosis'],
                    'patient_type' => $t['patient_type'],
                    'transfer' => $t['transfer'],
                    'hospital' => $t['hospital'],
                    'medic' => $t['medic'],              
                    'created_at' => $datetime,                    
                    'created_by' => $username   
                ]);

            // Medication
            foreach($request->medicationList as $m) {
                DB::table('clinic_medications')
                ->insert([
                    'treatment_id' => $treatmentId,
                    'medicine_id' => $m['medicine_id'],  
                    'qty' => $m['qty'],          
                    'unit_eng' => $m['unit_eng'],
                    'created_at' => $datetime,                    
                    'created_by' => $username  
                ]);
            }
        
            $success = true;
            $message = "Insert completed!";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function updatePatient(Request $request){
        DB::table('clinic_patients')
            ->where('patient_id', $request->patient_id)
            ->update([
                'sex' => $request->sex,
                'name' => $request->name,
                'surname' => $request->surname,
                'company' => $request->company,
                'department' => $request->department,
                'position' => $request->position,
                'employee_id' => $request->employee_id,
                'age' => $request->age,
                'blood_group' => $request->blood_group,
                'phone' => $request->phone,
                'disease' => $request->disease,
                'drug_allergy' => $request->drug_allergy,
                'note' => $request->note,
                'updated_at' => now('Asia/Bangkok')->toDateTimeString(),
                'updated_by' => auth()->user()->username,
        ]);        
    }

    public function deletePatient(Request $request){
        $check = DB::table('clinic_patients as p')
                    ->join('clinic_treatments as t', 'p.patient_id', 't.patient_id')
                    ->join('clinic_medications as m', 't.treatment_id', 'm.treatment_id')
                    ->where('p.patient_id', $request->patient_id);

        if ($check->count()) {
            $success = false;
            $message = 'This patient name has already been used; it cannot be deleted.';
        } else {
            DB::table('clinic_patients')
                ->where('patient_id', $request->patient_id)
                ->delete();
            $success = true;
            $message = "Delete completed!";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function treatment($patient_id){
        $treatment = DB::table('clinic_treatments')->where('patient_id', $patient_id)->orderBy('treatment_id', 'desc')->get();
        return $treatment;
    }

    public function addTreatment(Request $request){
        $t = $request->treatment;

        // Check duplicate
        $check = DB::table('clinic_treatments')
                    ->where('patient_id', $request->patient_id)
                    ->where('date_time', $t['date_time']);

        if ($check->count()){
            $success = false;
            $message = 'Duplicated data.';
        } else {

            $datetime = now("Asia/Bangkok")->toDateTimeString();
            $username = Str::lower(auth()->user()->username);

            // Treatment
            $treatmentId = DB::table('clinic_treatments')->max('treatment_id') + 1;
            DB::table('clinic_treatments')
                ->insert([
                    'treatment_id' => $treatmentId,
                    'patient_id' => $request->patient_id,
                    'date_time' => $t['date_time'],
                    'medical_type' => $t['medical_type'],
                    'injury_type' => $t['injury_type'],
                    'injury_part' => $t['injury_part'] ? implode(', ', $t['injury_part']) : null,
                    'work_related' => $t['work_related'],
                    'temp_c' => $t['temp_c'],
                    'blood_press' => $t['blood_press'],
                    'puls' => $t['puls'],
                    'oxigen' => $t['oxigen'],
                    'weight' => $t['weight'],
                    'syndrome' => $t['syndrome'],
                    'diagnosis' => $t['diagnosis'],
                    'patient_type' => $t['patient_type'],
                    'transfer' => $t['transfer'],
                    'hospital' => $t['hospital'],
                    'medic' => $t['medic'],              
                    'created_at' => $datetime,                    
                    'created_by' => $username   
                ]);

            // Medications
            foreach($request->medicationList as $m) {
                DB::table('clinic_medications')
                ->insert([
                    'treatment_id' => $treatmentId,
                    'medicine_id' => $m['medicine_id'],  
                    'qty' => $m['qty'],          
                    'unit_eng' => $m['unit_eng'],
                    'created_at' => $datetime,                    
                    'created_by' => $username  
                ]);
            }

            $success = true;
            $message = "Insert completed!";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function updateTreatment(Request $request){
        DB::table('clinic_treatments')
            ->where('treatment_id', $request->treatment_id)
            ->update([
                'date_time' => $request->date_time,
                'medical_type' => $request->medical_type,
                'injury_type' => $request->injury_type,
                'injury_part' => $request->injury_part ? implode(', ', $request->injury_part) : null,
                'work_related' => $request->work_related,
                'temp_c' => $request->temp_c,
                'blood_press' => $request->blood_press,
                'puls' => $request->puls,
                'oxigen' => $request->oxigen,
                'weight' => $request->weight,
                'syndrome' => $request->syndrome,
                'diagnosis' => $request->diagnosis,
                'patient_type' => $request->patient_type,
                'transfer' => $request->transfer,
                'hospital' => $request->hospital,
                'medic' => $request->medic,              
                'updated_at' => now("Asia/Bangkok")->toDateTimeString(),                    
                'updated_by' => Str::lower(auth()->user()->username)
            ]);
    }

    public function deleteTreatment(Request $request){
        $check = DB::table('clinic_treatments as t')
                    ->join('clinic_medications as m', 't.treatment_id', 'm.treatment_id')
                    ->where('t.treatment_id', $request->treatment_id);

        if ($check->count()) {
            $success = false;
            $message = 'This treatment id has already been used; it cannot be deleted.';
        } else {
            DB::table('clinic_treatments')
                ->where('treatment_id', $request->treatment_id)
                ->delete();

            $success = true;
            $message = "Delete completed!";
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }


    public function medication($patient_id){
        $medication = DB::table('clinic_treatments as t')
                        ->join('clinic_medications as m', 't.treatment_id', 'm.treatment_id')
                        ->join('clinic_medicines as n', 'm.medicine_id', 'n.medicine_id')
                        ->where('t.patient_id', $patient_id)
                        ->select('t.treatment_id', 'n.medicine_eng', 'n.medicine_lao', 'm.*')
                        ->orderBy('n.medicine_eng', 'asc')
                        ->get();
        return $medication;
    }

    public function addMedication(Request $request){
        foreach($request->medicationList as $m) {
            DB::table('clinic_medications')
                ->insert([
                    'treatment_id' => $request->treatment_id,   
                    'medicine_id' => $m['medicine_id'],  
                    'qty' => $m['qty'],          
                    'unit_eng' => $m['unit_eng'],
                    'created_at' => now("Asia/Bangkok")->toDateTimeString(),                    
                    'created_by' => Str::lower(auth()->user()->username)  
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

    public function updateMedication(Request $request){
        DB::table('clinic_medications')
            ->where('medication_id', $request->medication_id)
            ->update([
                'medicine_id' => $request->medicine_id,
                'qty' => $request->qty,
                'unit_eng' => $request->unit_eng,
                'updated_at' => now("Asia/Bangkok")->toDateTimeString(),                    
                'updated_by' => Str::lower(auth()->user()->username)
            ]);
    }   

    public function deleteMedication(Request $request){
        DB::table('clinic_medications')
            ->where('medication_id', $request->medication_id)
            ->delete();
            
        $success = true;
        $message = "Delete completed!";

        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }







}
 