<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCompraModel extends Model
{
    protected $table            = 'detalle_compra';
    protected $primaryKey       = 'detalle_id';
    protected $allowedFields    = [
        'compra_id',
        'game_id',
        'precio_unitario'
    ];
    public $timestamps = false;
}
