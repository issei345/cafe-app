@extends('layouts.admin')

@section('title', 'Kategori Menu')

@section('content')

<h3>Kategori Menu</h3>

<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Nama kategori">
    <button type="submit">Tambah</button>
</form>

<hr>

<ul>
@foreach($categories as $category)
    <li>
        {{ $category->name }}

        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </li>
@endforeach
</ul>

@endsection
