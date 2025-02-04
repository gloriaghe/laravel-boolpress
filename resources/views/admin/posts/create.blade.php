@extends('admin.layouts.base')

@section('mainContent')
<h1>Crea un nuovo post:</h1>

<form action="{{route('admin.posts.store')}}" method="post"  enctype="multipart/form-data" novalidate>
    {{-- con novalidate non abbiamo la validazione front-end --}}
    @csrf
    <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}">
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="slug">Slug</label>
        <input class="form-control @error('slug') is-invalid @enderror" type="text" name="slug" id="slug" value="{{ old('slug') }}">
        {{-- <button type="button" class="btn btn-primary">Reset</button> --}}
        @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="image">Image</label>
        <input class="form-control @error('image') is-invalid @enderror" type="file" accept="image/*" name="image" id="image" value="{{ old('image') }}">
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <img id="preview" class="img-fluid" src="">

    </div>

    <div class="mb-3">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
            <option @if(!old('category_id')) selected @endif disabled value="">Scegli...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if($category->id == old('category_id')) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <fieldset class="mb-3">
        <legend>Tags</legend>
        @foreach ($tags as $tag)
            <div class="form-check">
                <input
                class="form-check-input"
                type="checkbox"
                {{--  aggiungendo [] al nome abbiamo un array come valore di ritorno --}}
                    name="tags[]"
                    value="{{ $tag->id }}"
                    id="tag-{{ $tag->id }}"
                    @if(in_array($tag->id, old('tags') ?: [])) checked @endif
                >
                <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
            </div>
        @endforeach

        {{-- TODO: l'errore non funziona --}}

         {{-- @error('tags')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror --}}

        {{-- così funziona --}}
        @foreach ($errors->get('tags.*') as $messagges)
            @foreach ($messagges as $message)

                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @endforeach
        @endforeach
    </fieldset>

    <div class="mb-3">
        <label class="form-label" for="content">Content</label>
        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content">{{ old('content') }}</textarea>
        @error('content')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="excerpt">Excerpt</label>
        <textarea class="form-control @error('excerpt') is-invalid @enderror" name="excerpt" id="excerpt">{{ old('excerpt') }}</textarea>
        @error('excerpt')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Salva Post</button>
</form>


@endsection
