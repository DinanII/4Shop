@extends('layouts.admin')

@section('content')
	

    <div class="flex_container">
        <div class="form-container">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                <h4>Categorie aanpassen</h4>
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" name="name" value="{{ $category->name }}">
                </div>
                </div>
                <div class="form-group">
                    <input type="radio" id="active" name="active" value="1">
                    <label for="active">Actief</label>

                    <input type="radio" id="inactive" name="active" value="0">
                    <label for="inactive">Inactief</label>
                </div>

                <div class="form-group">
                    <label for="submit">Aanpassen</label>
                    <input type="submit" value="Aanpassen">
                </div>

            </form>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="post">
                @method('DELETE')
                @csrf
                <div class="form-group">
                    <label for="delete">Verwijder</label>
                    <input type="submit" value="delete">
                </div>
            </form>
        </div>


        
        <div class="products">
            <h4>Producten</h4>
            <ul>
                @foreach($products as $product)
                    @if($product->category_id == $category->id)
                        <li>{{ $product->title }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    
    
    


@endsection