@extends('layout.panel')

@section('after_style')
<style>
    label.error{font-size: 10px; color: orangered; }
    .form-group input[type=file]{opacity: 1; top: 15px;}
</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">Header Config</h2>

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
            <div class="col-md-12">
                <div class="form-group">
                    <label for="config_header">Picture</label>
                    <input type="file" class="form-control required" id="config_header" name="config_header">
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
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('form').validate();
    });
</script>
@endsection