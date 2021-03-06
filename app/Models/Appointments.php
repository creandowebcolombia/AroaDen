<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appointments extends Model
{
    protected $table = 'appointments';
    protected $fillable = ['idpat','day','hour','notes'];
    protected $primaryKey = 'idapp';

    public function patients()
    {
        return $this->belongsTo('App\Models\Patients');
    }    

    public function scopeAllOrderByDay($query)
    {
        return $query->join('patients','appointments.idpat','=','patients.idpat')
                        ->select('appointments.*','patients.surname','patients.name')
                        ->whereNull('patients.deleted_at')
                        ->orderBy('appointments.day' , 'DESC')
                        ->orderBy('appointments.hour' , 'ASC')
                        ->get();
    }

    public static function CountAll()
    {
        $result = DB::table('appointments')
            ->join('patients','appointments.idpat','=','patients.idpat')
            ->select('appointments.*','patients.surname','patients.name')
            ->whereNull('patients.deleted_at')
            ->count();

        $count = count($result);

        return (int)$count;
    }

    public function scopeAllBetweenRangeOrderByDay($query, $date1, $date2)
    {
        return $query->join('patients','appointments.idpat','=','patients.idpat')
                        ->select('appointments.*','patients.surname','patients.name')
                        ->whereBetween('day', [$date1, $date2])
                        ->whereNull('patients.deleted_at')
                        ->orderBy('day' , 'DESC')
                        ->orderBy('hour' , 'ASC')
                        ->get(); 
    }

    public function scopeAllTodayOrderByDay($query)
    {
        $today = date('Y-m-d');

        return $query->join('patients','appointments.idpat','=','patients.idpat')
                        ->select('appointments.*','patients.surname','patients.name')
                        ->where('appointments.day', $today)
                        ->whereNull('patients.deleted_at')
                        ->orderBy('appointments.day' , 'DESC')
                        ->orderBy('appointments.hour' , 'ASC')
                        ->get();
    }

    public static function CountAllToday()
    {
        $today = date('Y-m-d');

        $result = DB::table('appointments')
                        ->join('patients','appointments.idpat','=','patients.idpat')
                        ->where('appointments.day', $today)
                        ->whereNull('patients.deleted_at')
                        ->get();

        $count = count($result);

        return (int)$count;
    }

    public function scopeAllByPatientId($query, $id)
    {
        return $query->select('appointments.*')
                    ->where('idpat', $id)
                    ->orderBy('day', 'DESC')
                    ->orderBy('hour', 'DESC')
                    ->get();
    }

    public function scopeFirstById($query, $id)
    {
        return DB::table('appointments')
            ->join('patients','appointments.idpat','=','patients.idpat')
            ->select('appointments.*', 'patients.name', 'patients.surname', 'patients.idpat')
            ->where('idapp', $id)
            ->first();
    }

    public function scopeCheckIfIdExists($query, $id)
    {
        return $query->where('idapp', $id)
                        ->exists();
    }

}
