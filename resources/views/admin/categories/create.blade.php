@extends('layouts.admin')

@section('content')
	
	<div class="d-flex justify-content-between align-items-center my-4">
        <div class="edit">
            <h4>Categorie toevoegen</h4>
            <form action="{{ route('admin.categories.store') }}" method="POST" style="min-width: 320px;" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" name="name">
                </div>
                <div class="form-group">
                    <input type="radio" id="active" name="active" value="1">
                    <label for="active">Actief</label><br>
                    <input type="radio" id="inactive" name="active" value="0">
                    <label for="inactive">Inactive</label><br>
                </div>

                <div class="form-group">
                    <!-- <label for="submit">Toevoegen</label> -->
                    <input type="submit" value="Toevoegen">
                </div>
            </form>

        </div>

	</div>

@endsection