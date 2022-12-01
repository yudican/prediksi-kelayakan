<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>data karyawan</span>
                        </a>
                        <div class="pull-right">
                            @if (!$form && !$modal)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i class="fas fa-times"></i> Cancel</button>
                            @else
                            @if (auth()->user()->hasTeamPermission($curteam, $route_name.':create'))
                            <button class="btn btn-primary btn-sm" wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i>
                                Add
                                New</button>
                            @endif
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.data-karyawan-table params="{{$route_name}}" />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">{{$update_mode ? 'Update' :
                            'Tambah'}} data karyawan</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <x-text-field type="number" name="nik" label="Nip" />
                                <x-text-field type="number" name="telepon" label="Telepon" />
                                <x-text-field type="text" name="eselon" label="Eselon" />
                                <x-text-field type="text" name="gol" label="Golongan" />

                            </div>
                            <div class="col-md-6">
                                <x-text-field type="text" name="nama" label="Nama" />
                                <x-select name="data_jabatan_id" label="Jabatan">
                                    <option value="">Select Jabatan</option>
                                    @foreach ($jabatans as $jabatan)
                                    <option value="{{$jabatan->id}}">{{$jabatan->nama_jabatan}}</option>
                                    @endforeach
                                </x-select>
                                <x-text-field type="date" name="tmt" label="Tmt" />
                                <x-text-field type="text" name="email" label="Email" />
                            </div>
                            <div class="col-md-12">
                                {{--
                                <x-text-field type="text" name="alamat" label="Alamat" /> --}}
                                <hr>
                            </div>
                            @foreach ($attributes as $key => $attribute)
                            <div class="col-md-6">
                                <x-select name="attribute_nilai_id.{{$key}}" label="{{$attribute->nama_atribut}}">
                                    <option value="">Pilih Nilai Atribut</option>
                                    @foreach ($attribute->attributeNilai as $nilai)
                                    <option value="{{$nilai->id}}">{{$nilai->nilai_atribut}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" wire:click={{$update_mode ? 'update' : 'store' }} class="btn btn-primary btn-sm"><i class="fa fa-check pr-2"></i>Simpan</button>

                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Batal</a>

                    </div>
                </div>
            </div>
        </div>


        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data ini.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='delete' class="btn btn-danger btn-sm"><i class="fa fa-check pr-2"></i>Ya, Hapus</button>
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')



    <script>
        document.addEventListener('livewire:load', function(e) {
             window.livewire.on('loadForm', (data) => {
                
                
            });
            window.livewire.on('showModal', (data) => {
                $('#form-modal').modal('show')
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
                $('#form-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>