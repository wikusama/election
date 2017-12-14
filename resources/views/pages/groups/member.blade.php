@extends('layout.panel')

@section('after_style')
<style>
</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">
        Group Member
        <a href="{{ route('fbGetMembers') }}" class="btn btn-sm btn-success" id="member-retrieve"><span class="fa fa-refresh"></span></a>
    </h2>

    <div class="row">
        <div class="col-md-12">
            <h5>
                {{ $members->currentPage() * $members->count() }} of <span id="member-total">{{ $members->total() }}</span>
            </h5>
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

@section('after_script')
<script>
    $(function(){
        $('a#member-retrieve').on('click', function(){
            $(this).addClass('disabled')
            $(this).find('.fa').addClass('fa-spin');

            $.ajax({
                method: 'POST',
                url: $(this).attr('href'),
                dataType: 'json'
            }).success(function(res){
                if(data.success){
                    $('#member-total').text(data.memberQty);
                    $(this).removeClass('disabled');
                    $(this).find('.fa').removeClass('fa-spin');
                };
            });
            return false;
        });
    });
</script>
@endsection