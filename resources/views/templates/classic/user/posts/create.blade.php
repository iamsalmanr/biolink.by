@extends($activeTheme.'layouts.main')
@section('title', ___('Create Post'))
@section('content')
<div class="container pt-170 pb-100 sm-pb-80">
    <div class="mt-10 text-center">
        <h3 class="mb-1">{{ ___('Add New BioLink') }}</h3>
        <p>{{ ___('Let’s setup your bio link') }}</p>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form id="deatilsForm" action="{{ route('biolinks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section class="card our-bio-link">
                        <div class="mx-auto sm-mb-32">
                            <div class="bio-link-upload-img">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input id="upload2" type="file" name="logo" onchange="readURL(this,'uploadedAvatar2')"
                                               accept="image/jpg, image/jpeg, image/png" hidden />
                                        <label for="upload2"></label>
                                    </div>
                                    <div class="avatar-preview text-center">
                                        <img src="{{ asset('storage/post/default.png') }}" id="uploadedAvatar2" class="rounded-3"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between flex-column w-100">
                            <input class="form-control text-field mb-16" type="text" name="name" placeholder="{{ ___('Name') }}" value="{{ old('name') }}">
                            <input class="form-control text-field mb-16" type="text" name="bio" placeholder="{{ ___('Bio') }}" value="{{ old('bio') }}">
                            <input class="form-control text-field" type="text" name="slug" placeholder="{{ ___('Slug') }}" value="{{ old('slug') }}">
                            <small class="text-start mt-1">{{ ___('URL slug is just the last part of the URL that serves as an identifier of the page.') }} {{ ___('Example') }} : <code>{{ url('/') }}/<strong>{{ ___('Slug') }}</strong></code></small>
                        </div>

                        <div class="position-relative mt-32">
                            <button class="button -primary w-100 -lg" type="submit">{{ ___('Get Started') }}</button>
                        </div>
                    </section>
                    <a href="{{ route('dashboard') }}"><i class="fa-regular fa-arrow-left ml-5"></i> {{ ___('Back') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
