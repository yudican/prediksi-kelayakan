<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>data latih</span>
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
                                @foreach ($items as $key => $item)
                                @if ($key == 0)
                                @foreach ($item->dataLatih as $data_set)
                                <th>{{$data_set->attributeNilai?->attribute?->nama_atribut ?? '-'}}</th>
                                @endforeach
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $key=> $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->nama_nasabah }}</td>
                                @foreach ($item->dataLatih as $data_set)
                                <td>{{ $data_set->attributeNilai?->nilai_atribut ?? '-' }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>