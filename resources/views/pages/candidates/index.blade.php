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
                        <th align="center">#</th>
                        <th>Lead Name</th>
                        <th>Lead About</th>
                        <th>Deputy Name</th>
                        <th>Deputy About</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $key => $candidate)
                    <tr>
                        <td rowspan="2" align="center">
                            {{ $key+1 }}
                            <br>
                            <a href="#" class="btn btn-sm btn-warning">
                                <span class="fa fa-pencil"></span>
                            </a><br>
                            <a href="{{ route('candidateDelete', $candidate->id) }}" data-no="{{ $key + 1 }}" class="btn btn-sm btn-danger btn-delete">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>
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

<!-- Modal -->
<div id="confirm-delete" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete No. <strong><span id="candidate-no"></span></strong>? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger btn-ok">Yes</button>
            </div>
        </div>

    </div>
</div>


@section('after_script')
<script>
    $(function(){
        var $deleteUrl;
        $('a.btn-delete').on('click', function(){
            $('#confirm-delete').modal('show');
            $('#candidate-no').text($(this).attr('data-no'));
            $deleteUrl = $(this);
            return false;
        });

        $('#confirm-delete').on('click', '.btn-ok', function(e) {
            $('#confirm-delete').addClass('loading');
            
            $.ajax({
                method: 'POST',
                url: $deleteUrl.attr('href'),
                dataType: "json"
            }).done(function( msg ) {
                $('#confirm-delete').modal('hide').removeClass('loading');
            }).success(function(res){
                if(res.success) location.reload();
            });

        });
    });
</script>
@endsection