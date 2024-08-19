<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_item_pricing extends Model
{
    protected $table      = 'item_pricing';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_item', 'price', 'start_date', 'end_date', 'id_entitas', 'created_by', 'is_active',
        'price_type'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function countNoFiltered()
    {
        $this->select('
            *
        ')
        ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // datatable get sellin price
    public function get_datatable_selling_price(){
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'i.nama'
        ];
        $column_orderable = [
            'item_pricing.id', 'i.nama'
        ];

        $this->select('
            item_pricing.*,
            i.kode_item as item_code,
            i.nama as item_name,
            sd.nama as nama_satuan,
            e.nama as entitas_name
        ')
        ->join('item i', 'i.id=item_pricing.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->join('entitas e', 'e.id=item_pricing.id_entitas', 'LEFT')
        ->where('item_pricing.price_type', 'selling')
        ->where('item_pricing.deleted_at', NULL);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0;
            foreach ($column_searchable as $item) {
                if ($i === 0) {
                    $this->groupStart(); 
                    $this->like($item, $searchValue);
                } else {
                    $this->orLike($item, $searchValue);
                }
                if (count($column_searchable) - 1 == $i) {
                    $this->groupEnd(); 
                }
                $i++;
            }
        }

        if ($request->getPost('order')) {
            $orderColumn = $column_orderable[$request->getPost('order')[0]['column']];
            $orderDirection = $request->getPost('order')[0]['dir'];
            $this->orderBy($orderColumn, $orderDirection);
        } else {
            $this->orderBy('id', 'ASC');
        }

        if ($request->getPost('length') != -1) {
            $this->limit($request->getPost('length'), $request->getPost('start'));
        }

        // result set
        $result['return_data'] = $this->get()->getResult();
        $result['count_filtered'] = $this->countAllResults();
        $result['count_all'] = $this->countNoFiltered();

        return $result;
    }

    // datatable get hpp
    public function get_datatable_hpp(){
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'i.nama'
        ];
        $column_orderable = [
            'item_pricing.id', 'i.nama'
        ];

        $this->select('
            item_pricing.*,
            i.kode_item as item_code,
            i.nama as item_name,
            sd.nama as nama_satuan,
            e.nama as entitas_name
        ')
        ->join('item i', 'i.id=item_pricing.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->join('entitas e', 'e.id=item_pricing.id_entitas', 'LEFT')
        ->where('item_pricing.price_type', 'hpp')
        ->where('item_pricing.deleted_at', NULL);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0;
            foreach ($column_searchable as $item) {
                if ($i === 0) {
                    $this->groupStart(); 
                    $this->like($item, $searchValue);
                } else {
                    $this->orLike($item, $searchValue);
                }
                if (count($column_searchable) - 1 == $i) {
                    $this->groupEnd(); 
                }
                $i++;
            }
        }

        if ($request->getPost('order')) {
            $orderColumn = $column_orderable[$request->getPost('order')[0]['column']];
            $orderDirection = $request->getPost('order')[0]['dir'];
            $this->orderBy($orderColumn, $orderDirection);
        } else {
            $this->orderBy('id', 'ASC');
        }

        if ($request->getPost('length') != -1) {
            $this->limit($request->getPost('length'), $request->getPost('start'));
        }

        // result set
        $result['return_data'] = $this->get()->getResult();
        $result['count_filtered'] = $this->countAllResults();
        $result['count_all'] = $this->countNoFiltered();

        return $result;
    }

    // get by id
    public function get_by_id($id){
        $this->select('
            item.*,
            sd.nama as nama_satuan,
            b.nama as nama_brand,
            v.nama as nama_supplier,
            k1.nama as nama_jenis,
            k2.nama as nama_kategori
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan')
        ->join('brand b', 'b.id=item.id_brand')
        ->join('vendor v', 'v.id=item.id_supplier')
        ->join('kategori k1', 'k1.id=item.id_kategori_jenis')
        ->join('kategori k2', 'k2.id=item.id_kategori_item')
        ->where('id', $id);
        
        return $this->get()->getResult();
    }

    // set auto inactive
    public function autoInactive($id_item, $id_entitas)
    {
        // Data to be updated
        $data = [
            'is_active' => 0
        ];

        $this->where('id_item', $id_item);

        // Update the record where 'id' is $id
        return $this->set($data)->update();
    }

    // update item hpp by update formula hpp
    public function updateItemHppByFormula($formulaId)
    {
        // Start transaction
        $this->db->transBegin();

        try {
            // Find all item_utama that contain the specified bahan in item_detail
            $query = $this->db->query("
                SELECT DISTINCT id_item_utama
                FROM item_detail
                WHERE id_item = ?
                ", [$formulaId])
            ;

            $itemUtamaIds = array_column($query->getResultArray(), 'id_item_utama');

            // Process each item_utama
            foreach ($itemUtamaIds as $itemUtamaId) {
                // Get item_detail for each item_utama, including item ID and quantity
                $query = $this->db->query("
                    SELECT id_item, jumlah
                    FROM item_detail
                    WHERE id_item_utama = ?
                    ", [$itemUtamaId])
                ;

                $itemDetails = $query->getResultArray();

                $totalHpp = 0;

                // Calculate the HPP by summing up item_pricing values for each item detail
                foreach ($itemDetails as $itemDetail) {
                    $idItem = $itemDetail['id_item'];
                    $jumlah = $itemDetail['jumlah'];

                    // Get the HPP value for this item from item_pricing
                    $query = $this->db->query("
                        SELECT price
                        FROM item_pricing
                        WHERE id_item = ?
                        AND price_type = 'hpp'
                        ORDER BY created_at DESC
                        LIMIT 1
                    ", [$idItem]);

                    $pricing = $query->getRow();

                    if ($pricing) {
                        // Calculate the contribution to the total HPP
                        $totalHpp += $pricing->value * $jumlah;
                    }
                }

                // set last hpp to inactive
                $this->autoInactive($itemUtamaId, 1);

                // Insert the calculated HPP into item_pricing for the item_utama
                $this->db->query("
                    INSERT INTO item_pricing (price_type, id_item, price, start_date, id_entitas, is_active)
                    VALUES ('hpp', ?, ?, NOW(), 1, 1)
                ", [$itemUtamaId, $totalHpp]);

            }


            // Commit transaction
            $this->db->transCommit();
            return true;
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            throw $e; // Re-throw the exception to handle it where this method is called
        }
    }


}
