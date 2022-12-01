<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>Pengujian data latih</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                @foreach ($data as $key => $item)
                                @if ($key == 0)
                                @foreach ($item['data_latih'] as $data_set)
                                <th>{{$data_set->attributeNilai->attribute->nama_atribut}}</th>
                                @endforeach
                                @endif
                                @endforeach
                                <th>Promosi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item['nama'] }}</td>
                                @foreach ($item['data_latih'] as $data_set)
                                <td>{{ $data_set->attributeNilai->nilai_atribut }}</td>
                                @endforeach
                                <td>{{ $item['hasil_uji'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>