@extends('layout.panel')

@section('after_style')
<style>
    img{
        max-width: 180px;
    }
</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">Manage Candidates 
        @if($candidates->count() < 2)
        <a href="{{ route('candidateAdd') }}" class="btn btn-sm btn-success">+</a>
        @endif
    </h2>

    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Lead Name</th>
                        <th>Lead About</th>
                        <th>Deputy Name</th>
                        <th>Deputy About</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $key => $candidate)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            {{ $candidate->lead_name }} <br>
                            <img src="{{ '/storage/'.$candidate->lead_pic }}" alt="" class="img-rounded">
                        </td>
                        <td>{!! $candidate->lead_about !!}</td>
                        <td>
                            {{ $candidate->deputy_name }} <br>
                            <img src="{{ '/storage/'.$candidate->deputy_pic }}" alt="" class="img-rounded">
                        </td>
                        <td>{!! $candidate->deputy_about !!}</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning">
                                <span class="fa fa-pencil"></span>
                            </a><br>
                            <a href="#" class="btn btn-sm btn-danger">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>
                        <td colspan="2"><strong>Vision</strong><br> {!! $candidate->vision !!}</td>
                        <td colspan="2"><strong>Mission</strong><br> {!! $candidate->mission !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection