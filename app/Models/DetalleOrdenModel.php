<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleOrdenModel extends Model
{
    protected $table      = 'detalle_venta';
    protected $primaryKey = 'item_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'order_id',
        'game_id',
        'quantity',
        'unit_price',
        'discount'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(OrdenModel::class, 'order_id', 'order_id');
    }

    public function game()
    {
        return $this->belongsTo(JuegosModel::class, 'game_id', 'game_id');
    }

    public function keys()
    {
        return $this->hasMany(KeyModel::class, 'order_item_id', 'item_id');
    }
}
