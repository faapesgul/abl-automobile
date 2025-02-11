<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

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

    public function getOrderWithCar($orderId)
    {
        return $this->select('automobiles.*')
                    ->join('automobiles', 'orders.automobile_id = automobiles.automobile_id', 'left')
                    ->where('orders.order_id', $orderId)
                    ->first(); // Ambil satu data berdasarkan ID
    }

    /**
     * Ambil data order dengan customer berdasarkan ID order
     */
    public function getOrderWithCustomer($orderId)
    {
        return $this->select('customers.*')
                    ->join('customers', 'orders.customer_id = customers.customer_id', 'left')
                    ->where('orders.order_id', $orderId)
                    ->first(); // Ambil satu data berdasarkan ID
    }
}
