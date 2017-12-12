@extends('layout.panel')

@section('after_style')
<style>
</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">Group Admin</h2>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>FB APP ID</th>
                        <th>NAME</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $key => $admin)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection