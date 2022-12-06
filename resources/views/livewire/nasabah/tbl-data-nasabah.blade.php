<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>data nasabah</span>
                        </a>
                        <div class="pull-right">
                            @if (!$form && !$modal)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i class="fas fa-times"></i> Cancel</button>
                            @else
                            @if (auth()->user()->hasTeamPermission($curteam, $route_name.':create'))
                            <button class="btn btn-primary btn-sm" wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i> Add
                                New</button>
                            <button class="btn btn-success btn-sm" wire:click="$emit('showModalImport','show')"><i class="fas fa-cloud-download-alt"></i>Import</button>
                            @endif
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.data-nasabah-table params="{{$route_name}}" />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">{{$update_mode ? 'Update' : 'Tambah'}} data nasabah</h5>
                    </div>
                    <div class="modal-body">

                        <x-text-field type="text" name="nama_nasabah" label="Nama Nasabah" />
                        <x-text-field type="number" name="nomor_hp" label="Nomor Hp" />
                        <x-text-field type="date" name="tanggal_lahir" label="Tanggal Lahir" />
                        {{-- <x-select name="jenis_kelamin" label="Jenis Kelamin">
                            <option value="">Select Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </x-select> --}}
                        {{--
                        <x-text-field type="text" name="pekerjaan" label="Pekerjaan" />
                        <x-select name="status_perkawinan" label="Status Perkawinan">
                            <option value="">Select Status Perkawinan</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                        </x-select>
                        <x-select name="tanggal_bergabung" label="Tanggal Bergabung">
                            <option value="">Select Tanggal Bergabung</option>
                            @for ($i = date('Y'); $i > 2000; $i--) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </x-select> --}}

                        <x-text-field type="date" name="tgl_pinjaman" label="Tanggal Pinjaman" />
                        <div>
                            @foreach ($attributes as $key => $attribute)
                            <x-select name="attribute_nilai_id.{{$attribute->id}}" label="{{$attribute->nama_atribut}}">
                                <option value="">Pilih Nilai Atribut</option>
                                @foreach ($attribute->attributeNilai as $nilai)
                                <option value="{{$nilai->id}}">{{$nilai->nilai_atribut}}</option>
                                @endforeach
                            </x-select>
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

        <div id="import-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Import Data</h5>
                    </div>
                    <div class="modal-body">
                        <x-input-file file="{{$file}}" path="{{optional($file_path)->getClientOriginalName()}}" name="file_path" label="Input File" />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='saveImport' class="btn btn-success btn-sm"><i class="fa fa-check pr-2"></i>Simpan</button>
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

            window.livewire.on('showModalImport', (data) => {
                $('#import-modal').modal(data)
            });
        })
    </script>
    @endpush
</div>