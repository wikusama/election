@extends('layout.panel')

@section('after_style')
<style>
</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">Group Member</h2>

    <div class="row">
        <div class="col-md-12">
            {{ $members->currentPage() * $members->count() }} of {{ $members->total() }}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>FB APP ID</th>
                        <th>NAME</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $key => $member)
                        <tr>
                            <td>{{ $starting_at + $key + 1 }}</td>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {{ $members->links() }}
        </div>
    </div>

</div>
@endsection