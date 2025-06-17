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
        'is_active',
        'title',
        'price',
        'special_price',
        'special_price_active',
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
}
