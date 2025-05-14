<?php

namespace App\Models;

use CodeIgniter\Model;

class JuegoCategoriaModel extends Model
{
    protected $table      = 'juegos_categorias';
    protected $primaryKey = 'game_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'game_id',
        'category_id'
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
    public function game()
    {
        return $this->belongsTo(JuegosModel::class, 'game_id', 'game_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoriaModel::class, 'category_id', 'category_id');
    }
}
