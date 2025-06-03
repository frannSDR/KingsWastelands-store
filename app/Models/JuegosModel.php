<?php

namespace App\Models;

use CodeIgniter\Model;

class JuegosModel extends Model
{
    protected $table      = 'juegos';
    protected $primaryKey = 'game_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'title',
        'price',
        'release_date',
        'about',
        'synopsis',
        'developer',
        'youtube_trailer_id',
        'cover_image_url',
        'banner_image_url',
        'card_image_url',
        'rating',
        'logo_url',
        'created_at',
        'updated_at'
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

    public function getJuegosPorCategoria($categoriaSlug, $perPage = null)
    {
        $builder = $this->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id')
            ->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
            ->join('categorias', 'categorias.category_id = juego_categorias.category_id')
            ->where('categorias.slug', $categoriaSlug)
            ->orderBy('juegos.created_at', 'DESC');

        if ($perPage) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }
}
