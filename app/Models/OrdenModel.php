<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenModel extends Model
{
    protected $table      = 'ordenes_venta';
    protected $primaryKey = 'oder_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id',
        'order_date',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
        'tracking_number'
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
    public function user()
    {
        return $this->belongsTo(UsuarioModel::class, 'user_id', 'user_id');
    }

    public function items()
    {
        return $this->hasMany(DetalleOrdenModel::class, 'order_id', 'order_id');
    }

    public function invoice()
    {
        return $this->hasOne(FacturaModel::class, 'order_id', 'order_id');
    }
}
