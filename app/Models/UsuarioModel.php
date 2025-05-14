<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'user_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'email',
        'nickname',
        'password_hash',
        'first_name',
        'last_name',
        'created_at',
        'updated_at',
        'is_active',
        'last_login'
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
    public function reviews()
    {
        return $this->hasMany(ReviewModel::class, 'user_id', 'user_id');
    }

    public function cart()
    {
        return $this->hasOne(CartModel::class, 'user_id', 'user_id');
    }

    public function wishlist()
    {
        return $this->hasOne(DeseadosModel::class, 'user_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(OrdenModel::class, 'user_id', 'user_id');
    }
}
