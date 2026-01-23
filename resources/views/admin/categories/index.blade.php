@extends('layouts.admin')

@section('title', 'Kategori Menu')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Kategori Menu</h3>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah Kategori --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Contoh: Minuman"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary mt-2">
                    + Tambah Kategori
                </button>
            </form>
        </div>
    </div>

    {{-- List Kategori --}}
    <div class="row">
        @forelse($categories as $category)
            <div class="col-lg-4 col-md-6 mb-4">

                <div class="card border-0 shadow-sm h-100">

                    {{-- Card Body --}}
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-folder fa-2x text-warning mr-3"></i>

                            <div>
                                <h5 class="mb-0">{{ $category->name }}</h5>
                                <small class="text-muted">
                                    Dibuat {{ $category->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">

                          {{-- Toggle Status --}} <form action="{{ route('admin.categories.toggle', $category) }}" method="POST"> @csrf @method('PATCH') <div class="custom-control custom-switch"> <input type="checkbox" class="custom-control-input" id="switch{{ $category->id }}" onchange="this.form.submit()" {{ $category->is_active ? 'checked' : '' }}> <label class="custom-control-label" for="switch{{ $category->id }}"> Status </label> </div> </form> {{-- Action --}} <div> <button class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#editModal{{ $category->id }}"> <i class="fas fa-pen"></i> </button>

                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade"
                 id="editModal{{ $category->id }}"
                 tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kategori</h5>
                            <button type="button"
                                    class="close"
                                    data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <form action="{{ route('admin.categories.update', $category) }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           value="{{ $category->name }}"
                                           required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal">
                                    Batal
                                </button>

                                <button type="submit"
                                        class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center text-muted">
                Belum ada kategori
            </div>
        @endforelse
    </div>

</div>
@endsection
