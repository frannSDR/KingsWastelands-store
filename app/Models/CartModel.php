<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table      = 'carritos';
    protected $primaryKey = 'cart_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id',
        'created_at',
        'updated_at',
        'session_id'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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
        return $this->hasMany(CartItemModel::class, 'cart_id', 'cart_id');
    }
}
