<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Algorithm\C45;
use App\Http\Controllers\Mining\MainController;
use App\Models\Attribute;
use App\Models\AttributeNilai;
use App\Models\DataSet;
use App\Models\DataSetDetail;

class CoreComponent extends Component
{
  public $target_attribute = 'Kategori';
  public $data = [];
  public $target_attributes = [];
  public $no = 1;


  public function getData()
  {
    $data_set = DataSet::all();
    $attributes = Attribute::pluck('nama_atribut')->toArray();
    $data = [];
    $data[0] = $attributes;
    foreach ($data_set as $key => $item) {
      foreach ($item->dataSetDetail as $detail) {
        if ($detail->attributeNilai) {
          $data[$key + 1][] = $detail->attributeNilai?->nilai_atribut;
        }
      }
    }
    // dd($data);
    $c45 = new MainController();
    $c45->loadFile($data); // load example file
    $c45->setTargetAttribute($this->target_attribute); // set target attribute

    $initialize = $c45->initialize(); // initialize


    return $initialize;
  }


  public function perhitunganDataSet($final = false, $jenis_kelamin = null)
  {
    $data = [];
    $total = [];

    $data_set = DataSet::all();
    $attribute = AttributeNilai::whereHas('attribute', function ($query) use ($jenis_kelamin) {
      return $query->where('nama_atribut', $this->target_attribute);
    });
    dd($attribute->get(), $jenis_kelamin);
    $target_attribute = $attribute->pluck('id')->toArray();
    $this->target_attributes = $attribute->get();
    foreach ($data_set as $set) {
      foreach ($set->dataSetDetail as $key => $detail) {
        $nama_atribut = $detail?->attributeNilai?->attribute?->nama_atribut ?? '-';
        $nilai_atribut = $detail?->attributeNilai?->nilai_atribut ?? '-';
        $id_atribut = $detail?->attributeNilai?->id;
        if (!in_array($id_atribut, $target_attribute)) {
          foreach ($target_attribute as $target) {
            $nilai = DataSetDetail::where('data_set_id', $set->id)->where('attribute_nilai_id', $target)->pluck('attribute_nilai_id')->toArray();
            if (count($nilai) > 0) {
              $total[$id_atribut][$target][] = count($nilai);
            } else {
              $total[$id_atribut][$target][] = 0;
            }
          }
        } else {
          foreach ($target_attribute as $target) {
            $nilai = DataSetDetail::where('data_set_id', $set->id)->where('attribute_nilai_id', $target)->pluck('attribute_nilai_id')->toArray();
            if (count($nilai) > 0) {
              $total['total'][$target][] = count($nilai);
            } else {
              $total['total'][$target][] = 0;
            }
          }
        }
        // 
      }
    }

    // dd($total);
    foreach ($data_set as $set) {
      foreach ($set->dataSetDetail as $key => $detail) {
        $nama_atribut = $detail->attributeNilai?->attribute?->nama_atribut;
        $nilai_atribut = $detail->attributeNilai?->nilai_atribut;
        $id_atribut = $detail->attributeNilai?->id;
        $lists = [];
        $attributes = [];
        if (!in_array($id_atribut, $target_attribute)) {
          foreach ($target_attribute as $target) {
            if (isset($total[$id_atribut][$target])) {
              $lists[] = count($total[$id_atribut][$target]);
              $attribute_nilai = AttributeNilai::where('attribute_id', $detail->attributeNilai?->attribute?->id)->pluck('id')->toArray();
              $data[$id_atribut][$target] = [
                'atribut' => $nama_atribut,
                'nilai' => $nilai_atribut,
                'total' => ($total[$id_atribut][$target]),
                'id_attribute' => $attribute_nilai,
                'data_set_id' => $set->id,
              ];
            }
          }
        } else {
          foreach ($target_attribute as $target) {
            $data['total'][$target] = [
              'atribut' => 'Total',
              'nilai' => 'Total',
              'total' => $total['total'][$target],
              'id_attribute' => null
            ];
          }
        }
      }
    }

    $newData = [];
    $no = 0;
    foreach ($data as $key => $items) {
      if ($key == 'total') {
        $listData = [];
        foreach ($items as $item) {
          $listData[] = count($item['total']);
          $newData[0] = $item;
          $newData[0]['no'] = $no;
          $newData[0]['total'] = $listData;
          $newData[0]['nilai_total'] = array_sum($listData);
          // $newData[0]['entrophy'] = $this->_entrophy($listData, array_sum($listData));
          $no++;
        }
      }
    }

    foreach ($data as $key => $items) {
      if ($key != 'total') {
        $listData = [];
        $attributes = [];
        foreach ($items as $item) {
          $id_attribute = $item['id_attribute'];
          $data_attribute = AttributeNilai::with('dataSetDetail')->whereIn('id', $id_attribute)->get();

          foreach ($data_attribute as $atribut) {
            $attributes[$atribut->id] = $atribut->dataSetDetail()->count();
          }

          $listData[] = count($item['total']);
          $newData[$key] = $item;
          $newData[$key]['no'] = $no++;
          $newData[$key]['total'] = $listData;
          $newData[$key]['nilai_total'] = array_sum($listData);
          $newData[$key]['attribute_total'] = $attributes;
        }
      }
    }




    $datas = [];
    $entrophy_total = 0;
    $all_total = 0;
    foreach ($newData as $key => $data_new) {
      $datas[$key] = $data_new;
      if ($data_new['atribut'] == 'Total') {
        $all_total = array_sum($data_new['total']);
        $entrophy_total = $this->_entrophy($data_new['total'], $data_new['nilai_total']);
      }

      $entrophy = $this->_entrophy($data_new['total'], $data_new['nilai_total']);

      $datas[$key]['entrophy'] = $entrophy;
      if ($data_new['atribut'] != 'Total') {
        $datas[array_key_first($data_new['attribute_total'])]['gain'] = $this->_gain($all_total, $data_new['attribute_total'], $entrophy_total, $entrophy);
      } else {
        $datas[$key]['gain'] = 0;
      }
    }
    // dd($datas);
    if ($final) {
      return $datas;
    }
    return $newData;
    // dd($datas);

  }


  public function _entrophy($datas = [], $total = 0)
  {
    $entrophy = [];
    foreach ($datas as $key => $data) {
      $entrophy[$key] = (-$data / $total) * log($data / $total, 2);
    }
    return array_sum($entrophy);
  }


  public function _gain($total = 0, $datas = [], $entrophy_total = 0, $entrophy = 0)
  {
    $gain = $entrophy_total;
    foreach ($datas as $key => $jumlah) {
      $total_gain = ($jumlah / $total) * $entrophy;
      $gain -= $total_gain;
    }


    return  $gain;
  }
}
