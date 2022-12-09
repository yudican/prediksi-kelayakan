<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Hasil perhitungan data set</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No.</th>
                                <th rowspan="2">Attribute</th>
                                <th rowspan="2">Nilai Attribute</th>
                                <th colspan="{{count($target_attributes)+1}}">Jumlah Kasus</th>
                                <th rowspan="2">Entrophy</th>
                                <th rowspan="2">Gain</th>
                            </tr>
                            <tr>
                                <th>Total</th>
                                @foreach ($target_attributes as $attribute)
                                <th>{{$attribute?->nilai_atribut ?? '-'}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$item['atribut']}}</td>
                                <td>{{$item['nilai']}}</td>
                                <td>{{($item['nilai_total'])}}</td>
                                @foreach ($item['total'] as $total)
                                <td>{{($total)}}</td>
                                @endforeach
                                <td>{{$item['entrophy']}}</td>
                                @if (isset($item['gain']))
                                <td rowspan="{{$item['atribut'] == 'Total' ? 1 : count($item['total'])}}">{{$item['gain']}}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>