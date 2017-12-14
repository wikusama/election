@extends('layout.panel')

@section('after_style')
<link href="{{ asset('vendor/summernote/summernote.css') }}" rel="stylesheet"/>
<style>
    label.error{font-size: 10px; color: orangered; }
    .form-group input[type=file]{opacity: 1; top: 15px;}
</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">Add Candidate</h2>

    <div class="row">
        <form method="POST" enctype='multipart/form-data'>
            {{ csrf_field() }}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-6">
                <h3>Leader Candidate Information</h3>
                <div class="form-group">
                    <label for="lead_name">Name</label>
                    <input type="text" class="form-control required" id="lead_name" name="lead_name" value="{{ old('lead_name') }}">
                </div>
                <div class="form-group">
                    <label for="lead_about">About</label>
                    <textarea class="form-control required" id="lead_about" name="lead_about" value="{{ old('lead_about') }}">{{ old('lead_about') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="lead_pic">Picture</label>
                    <input type="file" class="form-control required" id="lead_pic" name="lead_pic">
                </div>
            </div>
            <div class="col-md-6">
                <h3>Deputy Candidate Information</h3>
                <div class="form-group">
                    <label for="deputy_name">Name</label>
                    <input type="text" class="form-control required" id="deputy_name" name="deputy_name" value="{{ old('deputy_name') }}">
                </div>
                <div class="form-group">
                    <label for="deputy_about">About</label>
                    <textarea class="form-control required" id="deputy_about" name="deputy_about" value="{{ old('deputy_about') }}">{{ old('deputy_about') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="deputy_pic">Picture</label>
                    <input type="file" class="form-control required" id="deputy_pic" name="deputy_pic">
                </div>
            </div>
            <div class="col-md-12">
                <h3>Their Vision</h3>
                <div class="form-group">
                    <textarea class="form-control required" id="vision" name="vision">{{ old('vision') }}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <h3>Their Mission</h3>
                <div class="form-group">
                    <textarea class="form-control required" id="mission" name="mission">{{ old('mission') }}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <br clear="all">
                <button type="submit" class="btn btn-success btn-block">Submit</button>
            </div>
        </form>
    </div>

</div>
@endsection

@section('after_script')
<script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('textarea').summernote({
            tabsize: 2,
            minHeight: 200
        });

        $('form').validate();
    });
</script>
@endsection