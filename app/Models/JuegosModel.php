<?php

namespace App\Models;

use CodeIgniter\Model;

class JuegosModel extends Model
{
    protected $table      = 'juegos';
    protected $primaryKey = 'game_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'title',
        'release_date',
        'about',
        'synopsis',
        'developer',
        'youtube_trailer_id',
        'cover_image_url',
        'banner_image_url',
        'card_image_url',
        'rating',
        'created_at',
        'updated_at'
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

    // Relaciones (usamos esto para poder realizar las relaciones con los modelos)
    public function reviews()
    {
        return $this->hasMany(ReviewModel::class, 'game_id', 'game_id');
    }

    public function gallery()
    {
        return $this->hasMany(GaleriaModel::class, 'game_id', 'game_id');
    }

    public function categories()
    {
        return $this->hasMany(JuegoCategoriaModel::class, 'game_id', 'game_id');
    }

    public function keys()
    {
        return $this->hasMany(KeyModel::class, 'game_id', 'game_id');
    }
}
