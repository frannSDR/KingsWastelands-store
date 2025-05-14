<?php

namespace App\Models;

use CodeIgniter\Model;

class DeseadosItemModel extends Model
{
    protected $table      = 'wishlist_items';
    protected $primaryKey = 'item_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'user_id',
        'game_id',
        'added_at'
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
    public function wishlist()
    {
        return $this->belongsTo(DeseadosModel::class, 'user_id', 'user_id');
    }

    public function game()
    {
        return $this->belongsTo(JuegosModel::class, 'game_id', 'game_id');
    }

    public function user()
    {
        return $this->belongsTo(UsuarioModel::class, 'user_id', 'user_id');
    }
}
