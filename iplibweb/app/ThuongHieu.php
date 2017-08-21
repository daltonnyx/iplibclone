<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    protected $table = 'thuong_hieu';
    public $timestamps = false;

    public static function search($inputs) {
        $whereClause = array();
        $bindings = array();
        foreach($inputs as $field => $value) {
            if($value != null && $field != 'page' && $field != 'total') {
                array_push($whereClause, "MATCH($field) AGAINST (? IN BOOLEAN MODE)");
                $bindings[] = $value;       
            }
        }
        $offset = isset($inputs['page']) ? $inputs['page'] : 0 * 15;
        $paginate = "LIMIT $offset, 15";
        $thuong_hieu = DB::select('select id, ten_nhan_hieu, so_hieu, ngay_nop_don, so_bang, chu_so_huu, logo from thuong_hieu where '. implode(" AND ", $whereClause) .' '. $paginate, $bindings);
        if(!isset($inputs['total'])) {
            $count = DB::select("select count(*) as total from thuong_hieu where ". implode(" AND ", $whereClause), $bindings);
            $total_page = ceil($count[0]->total / 15);
        }
        else {
            $total_page = $inputs['total'];
        }
        return array( 'rows' => ThuongHieu::hydrate($thuong_hieu), 'total_page' => $total_page);
    }

    public function nhoms() {
        return $this->belongsToMany('App\LoaiSanPham', 'thuong_hieu_loai', 'thuong_hieu', 'loai');
    }
    public function get_nhoms() {
        $ten_nhom = array_map(array($this, 'get_ten_nhom'), $this->nhoms()->get()->toArray());
        return implode(', ', $ten_nhom);
    }

    public function get_ten_nhom($nhom) {
        return '<b>'.$nhom['ma_spdv'] . '</b> ' . $nhom['ten'];
    }

    public function get_phan_loai_hinh() {
        if($this->phan_loai_hinh == null)
            return '';
        $loai_hinh = unserialize($this->phan_loai_hinh);
        if( is_null($loai_hinh) )
            return '';
        return implode('<br/>', $loai_hinh);
    }
    public function get_tai_lieu() {
        if($this->tai_lieu == null)
            return '';
        $tai_lieu = unserialize($this->tai_lieu);
        if(is_null($tai_lieu))
            return '';
        return implode(', ', $tai_lieu);
    }
}
