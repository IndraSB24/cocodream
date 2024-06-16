<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_item_transaksi_stock extends Model
{
    protected $table      = 'item_transaksi_stock';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_item', 'jumlah', 'jenis', 'kegiatan', 'id_kegiatan', 'tanggal_kegiatan',
        'id_entitas', 'created_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
 
    // protected $modelItemDetail;

    // public function __construct()
    // {
    //     $this->modelItemDetail = new Model_item_detail();
    // }

    // count all not deleted row
    public function countNoFiltered()
    {
        $this->select('
            *
        ')
        ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // get transaksi stok
    public function get_datatable_main()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'i.nama'
        ];
        $column_orderable = [
            'item_transaksi_stock.id', 'i.nama'
        ];

        $this->select('
            item_transaksi_stock.*,
            i.kode_item as kode_item,
            i.nama as nama_item,
            sd.nama as nama_satuan,
            e.nama as nama_entitas
        ')
        ->join('item i', 'i.id=item_transaksi_stock.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->join('entitas e', 'e.id=item_transaksi_stock.id_entitas', 'LEFT')
        ->where('item_transaksi_stock.deleted_at', NULL)
        ->orderBy('item_transaksi_stock.id', 'DESC');

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

    // add transaksi stock
    public function addTransaksiStock($payload) {
        $id_item = $payload['id_item'];
        // data main item
        $data_main_item = [
            'id_item' => $payload['id_item'],
            'jumlah' => $payload['jumlah'],
            'jenis' => $payload['jenis'],
            'kegiatan' => $payload['kegiatan'],
            'id_kegiatan' => $payload['id_kegiatan'],
            'tanggal_kegiatan' => $payload['tanggal_kegiatan'],
            'id_entitas' => $payload['id_entitas'],
            'created_by' => $payload['created_by']
        ];
        $this->insert($data_main_item);

        return true;
    }
}
