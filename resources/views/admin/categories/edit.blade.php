@extends('layouts.admin')

@section('content')
	
	<div class="d-flex justify-content-between align-items-center my-4">
        <div class="edit">
            <h4>Categorie aanpassen</h4>
            <form action="{{ route('products.update', $category) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" value="{{ $category->name }}">
                </div>

                <div class="form-group">
                    <label for="submit">Aanpassen</label>
                    <input type="submit" value="Aanpassen">
                </div>
            </form>

        </div>
        <div class="products">
            <h4>Producten</h4>
            <ul>
                @foreach($products as $product)
                    <li>{{ $product->title }}</li>
                @endforeach
            </ul>
        </div>
	</div>

@endsection