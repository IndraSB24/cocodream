<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_item extends Model
{
    protected $table      = 'item';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'kode_item', 'barcode', 'nama', 'id_kategori_jenis', 'id_satuan', 'id_kategori_item', 'created_by',
        'id_brand', 'id_supplier', 'stok_minimum', 'harga_dasar'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
 
    // count all not deleted row
    public function countNoFiltered()
    {
        $this->select('
                *
            ')
            ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // get all
    public function get_all(){
        $this->select('
            item.*,
            sd.nama as nama_satuan,
            k1.nama as nama_jenis
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan', 'LEFT')
        ->join('kategori k1', 'k1.id=item.id_kategori_jenis', 'LEFT')
        ->where('item.deleted_at', NULL);
        
        return $this->get()->getResult();
    }

    // get all array
    public function get_all_array(){
        $this->select('
            item.*,
            sd.nama as nama_satuan,
            k1.nama as nama_jenis
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan', 'LEFT')
        ->join('kategori k1', 'k1.id=item.id_kategori_jenis', 'LEFT')
        ->where('item.deleted_at', NULL);
        
        return $this->get()->getResultArray();
    }

    // get by id
    public function get_by_id($id){
        $this->select('
            item.*,
            sd.nama as nama_satuan,
            b.nama as nama_brand,
            v.nama as nama_supplier,
            k1.nama as nama_jenis,
            k2.nama as nama_kategori,
            COALESCE(ip.price, 0) as item_price
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan', 'LEFT')
        ->join('brand b', 'b.id=item.id_brand', 'LEFT')
        ->join('vendors v', 'v.id=item.id_supplier', 'LEFT')
        ->join('kategori k1', 'k1.id=item.id_kategori_jenis', 'LEFT')
        ->join('kategori k2', 'k2.id=item.id_kategori_item', 'LEFT')
        ->join('item_pricing ip', 'ip.id_item=item.id AND ip.is_active=1 ', 'LEFT')
        ->where('item.id', $id);
        
        return $this->get()->getResult();
    }

    // get
    public function get_datatable_main()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'item.kode_item', 'item.barcode', 'item.nama', 'k2.nama', 'k1.nama', 'b.nama', 'v.nama', 'item.stok_minimum',
            'sd.nama', 'item.harga_dasar'
        ];
        $column_orderable = [
            'id', 'item.kode_item', 'item.barcode', 'item.nama', 'k2.nama', 'k1.nama', 'b.nama', 'v.nama', 'item.stok_minimum',
            'sd.nama', 'ip.price'
        ];

        // filter set
        if ($request->getPost('filter_kategori')) {
            $this->where('item.id_kategori_item', $request->getPost('filter_kategori'));
        }
        if ($request->getPost('filter_jenis')) {
            $this->where('item.id_kategori_jenis', $request->getPost('filter_jenis'));
        }
        if ($request->getPost('filter_brand')) {
            $this->where('item.id_brand', $request->getPost('filter_brand'));
        }

        $this->select('
            item.*,
            sd.nama as nama_satuan,
            b.nama as nama_brand,
            v.nama as nama_supplier,
            k1.nama as nama_jenis,
            k2.nama as nama_kategori,
            COALESCE(ip.price, 0) as item_price
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan', 'LEFT')
        ->join('brand b', 'b.id=item.id_brand', 'LEFT')
        ->join('vendors v', 'v.id=item.id_supplier', 'LEFT')
        ->join('kategori k1', 'k1.id=item.id_kategori_jenis', 'LEFT')
        ->join('kategori k2', 'k2.id=item.id_kategori_item', 'LEFT')
        ->join('item_pricing ip', 'ip.id_item=item.id AND ip.is_active=1 ', 'LEFT')
        ->where('item.deleted_at', NULL);

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

    // ajax for  list item
    protected $main_column_searchable = [
        'item.kode_item', 'item.barcode', 'item.nama', 'k2.nama', 'k1.nama', 'b.nama', 'v.nama', 'item.stok_minimum',
        'sd.nama', 'item.harga_dasar'
    ];
    protected $main_column_orderable = [
        'id', 'item.kode_item', 'item.barcode', 'item.nama', 'k2.nama', 'k1.nama', 'b.nama', 'v.nama', 'item.stok_minimum',
        'sd.nama', 'ip.price'
    ];
    public function get_datatable_main_1()
    {
        $request = service('request');

        // filter set
        if ($request->getPost('filter_kategori')) {
            $this->where('item.id_kategori_item', $request->getPost('filter_kategori'));
        }
        if ($request->getPost('filter_jenis')) {
            $this->where('item.id_kategori_jenis', $request->getPost('filter_jenis'));
        }
        if ($request->getPost('filter_brand')) {
            $this->where('item.id_brand', $request->getPost('filter_brand'));
        }

        $this->select('
            item.*,
            sd.nama as nama_satuan,
            k1.nama as nama_jenis,
            COALESCE(ip.price, 0) as item_price
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan', 'LEFT')
        ->join('kategori k1', 'k1.id=item.id_kategori_jenis', 'LEFT')
        ->join('item_pricing ip', 'ip.id_item=item.id AND ip.is_active=1 ', 'LEFT')
        ->where('item.deleted_at', NULL);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0;
            foreach ($this->main_column_searchable as $item) {
                if ($i === 0) {
                    $this->groupStart(); 
                    $this->like($item, $searchValue);
                } else {
                    $this->orLike($item, $searchValue);
                }
                if (count($this->main_column_searchable) - 1 == $i) {
                    $this->groupEnd(); 
                }
                $i++;
            }
        }

        if ($request->getPost('order')) {
            $orderColumn = $this->main_column_orderable[$request->getPost('order')[0]['column']];
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

    // regex search
    public function search_item($keyword)
    {
        $this->select('
            item.*,
            sd.nama as nama_satuan,
            k1.nama as nama_jenis,
            k2.nama as nama_kategori
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan', 'LEFT')
        ->join('kategori k1', 'k1.id=item.id_kategori_jenis', 'LEFT')
        ->join('kategori k2', 'k2.id=item.id_kategori_item', 'LEFT')
        ->like('item.nama', $keyword, 'both')
        ->orLike('item.kode_item', $keyword, 'both')
        ->where('item.deleted_at', NULL);
        
        return $this->get()->getResult();
    }

    // get rekap stock
    public function get_datatable_rekap_stock()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'item.nama'
        ];
        $column_orderable = [
            'item.id', 'item.nama'
        ];

        // Get the distinct entity IDs from the EntitasModel
        $entitasModel = new Model_entitas_usaha();
        $entities = $entitasModel->findAll();

        $entityIDs = [];
        foreach ($entities as $entity) {
            $entityIDs[] = $entity->id;
        }

        // Construct the SUM statements dynamically
        $sumStatements = '';
        foreach ($entityIDs as $entityID) {
            $sumStatements .= "SUM(CASE WHEN e.id = $entityID AND its.id_entitas = $entityID THEN its.jumlah ELSE 0 END) AS quantity_entity_$entityID, ";
        }
        // Remove the trailing comma
        $sumStatements = rtrim($sumStatements, ', ');

        $this->select('
            item.*,
            sd.nama as nama_satuan,
            ' . $sumStatements . '
        ')
        ->join('satuan_dasar sd', 'sd.id=item.id_satuan', 'LEFT')
        ->join('item_transaksi_stock its', 'its.id_item=item.id', 'LEFT')
        ->join('entitas e', 'e.id=its.id_entitas', 'LEFT')
        ->groupBy('item.id')
        ->where('item.deleted_at', NULL);

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
        $result['list_entitas_id'] = $entityIDs;
        $result['return_data'] = $this->get()->getResult();
        $result['count_filtered'] = $this->countAllResults();
        $result['count_all'] = $this->countNoFiltered();

        return $result;
    }

}
