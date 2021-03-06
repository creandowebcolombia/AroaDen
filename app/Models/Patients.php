<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patients extends Model
{
    use SoftDeletes;
    
	protected $table = 'patients';
    protected $dates = ['deleted_at'];
    protected $fillable = ['surname','name','dni','tel1','tel2','tel3','sex','address','city','birth','notes'];
    protected $primaryKey = 'idpat';

    public function record()
    {
        return $this->hasOne('App\Models\Record', 'idpat', 'idpat');
    }

    public function treatments()
    {
        return $this->hasMany('App\Models\Treatments', 'idpat', 'idpat');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointments', 'idpat', 'idpat');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoices', 'idpat', 'idpat');
    }

    public function budgets()
    {
        return $this->hasMany('App\Models\Budgets', 'idpat', 'idpat');
    }

    public function scopeAllOrderBySurname($query, $num_paginate)
    {
        return $query->select('idpat', 'surname', 'name', 'dni', 'tel1', 'city')
                        ->whereNull('deleted_at')
                        ->orderBy('surname', 'ASC')
                        ->orderBy('name', 'ASC')
                        ->paginate($num_paginate);
    }

    public static function CountAll()
    {
        $result = DB::table('patients')
                    ->whereNull('deleted_at')
                    ->get();

        return (int)count($result);
    }

    public function scopeFirstById($query, $id)
    {
        return $query->where('idpat', $id)
                        ->whereNull('deleted_at')
                        ->first();
    }

    public function scopeFirstByDniDeleted($query, $dni)
    {
        return $query->where('dni', $dni)
                        ->first();
    }

    public static function CheckIfExistsOnUpdate($id, $dni)
    {
        $exists = DB::table('patients')
                        ->where('idpat', '!=', $id)
                        ->where('dni', $dni)
                        ->first();

        if ( is_null($exists) ) {
            return true;
        }

        return $exists;
    }

    public static function FindStringOnField($sLimit, $sWhere, $sOrder)
    {
        $where = '';

        if ($sWhere != '')
          $where = "
            AND (surname LIKE '%". $sWhere ."%' 
            OR name LIKE '%". $sWhere ."%' OR dni LIKE '%". $sWhere ."%'
            OR tel1 LIKE '%". $sWhere ."%' OR city LIKE '%". $sWhere ."%') 
          ";

        if ($sOrder != '') {
          $order = "ORDER BY " . $sOrder;
        } else {
          $order = 'ORDER BY surname ASC';
        }

        $query = "
            SELECT idpat, CONCAT(surname, ', ', name) AS surname_name, dni, tel1, city
            FROM patients
            WHERE deleted_at IS NULL " . $where . " 
            " . $order . " 
            " . $sLimit . "
        ;";

        return DB::select($query);
    }

    public static function CountFindStringOnField($sWhere = '')
    {
        $where = '';
                
        if ($sWhere != '')
          $where = "
            AND (surname LIKE '%". $sWhere ."%' 
            OR name LIKE '%". $sWhere ."%' OR dni LIKE '%". $sWhere ."%'
            OR tel1 LIKE '%". $sWhere ."%' OR city LIKE '%". $sWhere ."%') 
          ";

        $query = "
            SELECT count(*) AS total
            FROM patients
            WHERE deleted_at IS NULL " . $where . "
        ;";

        return DB::select($query);
    }

    public static function GetTotalPayments($number, $all = false)
    {
        $query = "
            SELECT pa.surname, pa.name, pa.idpat, 
            SUM(tre.units*tre.price) as total, 
            SUM(tre.paid) as paid, 
            SUM(tre.units*tre.price)-SUM(tre.paid) as rest 
            FROM treatments tre
            INNER JOIN patients pa
            ON tre.idpat=pa.idpat 
            WHERE pa.deleted_at IS NULL 
            GROUP BY tre.idpat 
            HAVING tre.idpat=tre.idpat  
            ORDER BY rest DESC
        ";

        if (!$all)
            $query .= " LIMIT $number";

        return DB::select($query);
    }

}
