@extends('layouts.admin')

@section('title', 'Admin - Ürün Yönetimi')

@section('content')
    <h1>Ürün Yönetimi</h1>
    <!-- Admin ürün yönetim içeriği -->
    @include('admin.products.products')
@endsection
