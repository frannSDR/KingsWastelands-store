<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table      = 'juegos_reviews';
    protected $primaryKey = 'review_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'game_id',
        'user_id',
        'rating',
        'review_text',
        'created_at',
        'updated_at',
        'is_approved'
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
    public function game()
    {
        return $this->belongsTo(JuegosModel::class, 'game_id', 'game_id');
    }

    public function user()
    {
        return $this->belongsTo(UsuarioModel::class, 'user_id', 'user_id');
    }

    public function helpfulMarks()
    {
        return $this->hasMany(ReviewHelpfulModel::class, 'review_id', 'review_id');
    }
}
