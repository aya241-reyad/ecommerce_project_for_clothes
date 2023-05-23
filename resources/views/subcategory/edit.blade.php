@extends('dashboard.master')
@section('title')
    edit category
@endsection
@section('content')
    <form action="{{ url('subCategories/' . $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('Patch')
        <div class="container mt-3">
            <div class="card mb-4">
                <h5 class="card-header">{{ __('dashboard.editcategory') }}</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach (languages() as $lang)
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <label for="account-name">{{ __('site.title_' . $lang) }} </label>
                                        <input class="form-control" value="{{ $category->getTranslations('name')[$lang] }}"
                                            name="name[{{ $lang }}]" id=""
                                            placeholder="{{ __('site.write') . __('site.title_' . $lang) }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="alert-danger">{{ $errors->first('name') }}</div>
                        @foreach (languages() as $lang)
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <label for="account-name">{{ __('site.description_' . $lang) }} </label>
                                        <textarea class="form-control" cols="30" rows="10" name="description[{{ $lang }}]" id=""
                                            placeholder="{{ __('site.write') . __('site.description_' . $lang) }}">{{ $category->getTranslations('description')[$lang] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="alert-danger">{{ $errors->first('description') }}</div>
                    <div class="form-group">
                        <select class="form-control" name="category_id" aria-label="Default select example">
                            <option value="{{ $category->category->id ?? null }}">{{ $category->category->name ?? null }}
                            </option>
                            @foreach ($categories as $category)
                                <option value={{ $category->id }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 ">
                        <label class="form-label">Image</label></br>
                        <label class="btn btn-primary btn-file">
                            Choose Image<input type="file" name="attachment" style="display: none;" required>
                        </label>
                    </div>
                    <div class="alert-danger">{{ $errors->first('attachment') }}</div>
                    <button type="submit"onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();"
                        class="btn btn-primary">Edit</button>
                </div>
                <br />
            </div>
        </div>
    </form>
@endsection
