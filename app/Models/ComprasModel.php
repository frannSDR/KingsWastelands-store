<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasModel extends Model
{
    protected $table            = 'compras';
    protected $primaryKey       = 'compra_id';
    protected $allowedFields    = [
        'user_id',
        'fecha',
        'total',
        'email',
        'telefono',
        'nombre_completo',
        'dni',
        'direccion',
        'ciudad',
        'provincia',
        'pais',
        'codigo_postal',
        'metodo_pago',
        'created_at'
    ];
    public $timestamps = false;
}
