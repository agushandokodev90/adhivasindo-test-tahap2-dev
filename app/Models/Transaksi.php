<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'transaksi';

    protected $fillable = [
        'produk_id',
        'qty',
        'harga',
        'total_harga',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->id();
            $model->save();
        });

        static::creating(function ($model) {

        });
        static::created(function ($model) {

        });

        static::updated(function ($model) {

        });

        static::deleted(function ($model) {
            $produk=Produk::find($model->produk_id);
            $produk->stok += $model->qty;
            $produk->save();
        });
    }
}
