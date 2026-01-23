@extends('layouts.admin')

@section('title', 'Menu Cafe')

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Menu Cafe</h3>
        <small class="text-muted">Kelola daftar menu cafe Anda</small>
    </div>

    <button class="btn btn-primary" data-toggle="modal" data-target="#createMenuModal">
        + Tambah Menu
    </button>
</div>

{{-- List Menu --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        {{-- Header Kolom --}}
        <div class="row fw-semibold text-muted border-bottom py-3 px-3 bg-light">
            <div class="col-auto" style="width:80px">Foto</div>
            <div class="col">Nama Menu</div>
            <div class="col-auto" style="width:120px">Kategori</div>
            <div class="col-auto text-end" style="width:120px">Harga</div>
            <div class="col-auto text-center" style="width:150px">Status</div>
            <div class="col-auto text-center" style="width:100px">Aksi</div>
        </div>

        {{-- Data --}}
        @forelse ($menus as $menu)
            <div class="row align-items-center py-3 px-3 border-bottom">

                {{-- Foto --}}
                <div class="col-auto" style="width:80px">
                    <img src="{{ $menu->image ?? asset('images/menu-dummy.png') }}"
                         class="rounded"
                         style="width:60px;height:60px;object-fit:cover;">
                </div>

                {{-- Nama --}}
                <div class="col">
                    <div class="fw-semibold">{{ $menu->name }}</div>
                    <small class="text-muted">{{ $menu->description }}</small>
                </div>

                {{-- Kategori --}}
                <div class="col-auto" style="width:120px">
                    <span class="badge bg-light text-dark border">
                        {{ $menu->category?->name ?? '-' }}
                    </span>
                </div>

                {{-- Harga --}}
                <div class="col-auto fw-semibold text-end" style="width:120px">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </div>

                {{-- Status --}}
                <div class="col-auto text-center" style="width:150px">
                    <form action="{{ route('admin.menus.toggle', $menu->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="custom-control custom-switch d-inline-block">
                            <input type="checkbox"
                                   class="custom-control-input"
                                   id="status{{ $menu->id }}"
                                   onchange="this.form.submit()"
                                   {{ $menu->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="status{{ $menu->id }}">
                                {{ $menu->is_active ? 'Tersedia' : 'Nonaktif' }}
                            </label>
                        </div>
                    </form>
                </div>

                {{-- Aksi --}}
                <div class="col-auto text-center" style="width:100px">
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-sm btn-outline-warning mr-1"
                                data-toggle="modal"
                                data-target="#editMenuModal{{ $menu->id }}">
                            <i class="fas fa-pen"></i>
                        </button>

                        <form action="{{ route('admin.menus.destroy', $menu->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Menu</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <input type="text" name="name" class="form-control mb-2"
                                       value="{{ $menu->name }}" required>

                                <select name="category_id" class="form-control mb-2">
                                    <option value="">Pilih kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="number" name="price" class="form-control mb-2"
                                       value="{{ $menu->price }}" required>

                                <textarea name="description" class="form-control mb-2">{{ $menu->description }}</textarea>

                                <input type="text" name="image" class="form-control"
                                       value="{{ $menu->image }}">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @empty
            <div class="text-center p-4 text-muted">
                Belum ada menu
            </div>
        @endforelse

    </div>
</div>

{{-- Modal Tambah Menu --}}
<div class="modal fade" id="createMenuModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu Baru</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <select name="category_id" class="form-control mb-2">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="name" class="form-control mb-2" placeholder="Nama menu" required>
                    <input type="number" name="price" class="form-control mb-2" placeholder="Harga" required>
                    <textarea name="description" class="form-control mb-2" placeholder="Deskripsi"></textarea>
                    <input type="text" name="image" class="form-control" placeholder="URL gambar">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitMenu">
    Simpan
</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#createMenuModal form');
    const button = document.getElementById('btnSubmitMenu');

    form.addEventListener('submit', function () {
        button.disabled = true;
        button.innerText = 'Menyimpan...';
    });
});
</script>
@endpush


@endsection
