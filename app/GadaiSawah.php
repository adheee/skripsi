<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GadaiSawah extends Model
{
	protected $table = 'gadai_sawahs';
    protected $fillable = [
        'periode', 'harga', 'admin_by', 'sawah_id', 'keterangan', 'status', 'status_at',
    ];

    public function sawahs()
    {
        return $this->belongsTo('App\Sawah', 'sawah_id');
    }

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_by');
    }
}
