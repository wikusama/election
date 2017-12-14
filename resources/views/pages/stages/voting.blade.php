@extends('layout.panel')

@section('after_style')
<style>
.team > div.row > div.col-md-6:first-child{
    border-right: solid 1px #f8f8f8;
}
.tag-number{
    text-align: center;
    padding-bottom: 30px;
}
.tag-number span{
    padding: 20px;
    display: inline-block;
    color: white;
    border-radius: 50%;
    font-size: 2em;
    font-weight: bold;
    width: 60px;
    height: 60px;
}
.team > div.row > div.col-md-6:first-child .tag-number span{
    background-color: #fbc02d;
}
.team > div.row > div.col-md-6:last-child .tag-number span{
    background-color: #03a9f4;
}
</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">Candidates</h2>

    <div class="team">
        <div class="row">
            @foreach($candidates as $key => $candidate)
            <div class="col-md-6">
                <div class="team-player">
                    <div class="candidate-content">
                        <div class="tag-number">
                            <span>{{ $key+1 }}</span>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-6">
                                <img src="{{ '/storage/'.$candidate->lead_pic }}" alt="Thumbnail Image" class="img-raised img-rounded">
                                <h4 class="title">{{ $candidate->lead_name }}<br />
                                    <button class="btn btn-info btn-xs btn-{{ ($key%2==0)?'warning':'info' }}" data-toggle="modal" data-target="#about-lead-{{ $key }}">About</button>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ '/storage/'.$candidate->deputy_pic }}" alt="Thumbnail Image" class="img-raised img-rounded">
                                <h4 class="title">{{ $candidate->deputy_name }}<br />
                                    <button class="btn btn-info btn-xs btn-{{ ($key%2==0)?'warning':'info' }}" data-toggle="modal" data-target="#about-deputy-{{ $key }}">About</button>
                                </h4>
                            </div>
                        </div>
                        <p class="description">
                            <h3 class="text-center">Vision</h3><br>
                            {!! $candidate->vision !!}
                            
                            <br><br>

                            <h3 class="text-center">Mission</h3><br>
                            {!! $candidate->mission !!}

                        </p>
                    </div>
                    @if(Auth::check())
                        @if(Auth::user()->members->voted_at == 0)
                            <a href="#" class="btn btn-block btn-{{ ($key%2==0)?'warning':'info' }} btn-vote" data-id="{{ $candidate->id }}" data-no="{{ $key+1 }}">vote for no. {{ $key+1 }}</a>
                        @else
                            <button class="btn btn-block btn-disable }}">you have voted</button>
                        @endif
                    @else
                        <a href="#top" class="btn btn-disable btn-block">Login to vote</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

<!-- Modal -->
<div id="confirm-vote" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to vote for No. <strong><span id="candidate-no"></span></strong>? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger btn-ok" data-id="0">Yes</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal About -->
@foreach($candidates as $key => $candidate)
<div id="about-lead-{{ $key }}" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><strong>About : </strong> {{ $candidate->lead_name }}</h4>
            </div>
            <div class="modal-body">
                {!! $candidate->lead_about !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="about-deputy-{{ $key }}" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><strong>About : </strong> {{ $candidate->deputy_name }}</h4>
            </div>
            <div class="modal-body">
                {!! $candidate->deputy_about !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endforeach

@section('after_script')
<script>
    $(document).on('ready', function(){
        setTimeout(() => {
            var maxHeight = 0;
            $('.team > div.row > div.col-md-6').each(function(){
                if($(this).height() > maxHeight) maxHeight = $(this).height();
            });

            $('.candidate-content').css('height', (maxHeight-50));
        }, 500);

        $('a.btn-vote').on('click', function(){
            $('#confirm-vote').modal('show');
            $('#candidate-no').text($(this).attr('data-no'));
            $('#confirm-vote .btn-ok').attr('data-id', $(this).attr('data-id'));
            return false;
        });

        $('#confirm-vote').on('click', '.btn-ok', function(e) {
            $('#confirm-vote').addClass('loading');
            
            var data = {"id":$(this).attr('data-id')};
            $.ajax({
                method: 'POST',
                url: '{{ route('voting') }}',
                dataType: "json",
                data: data
            }).done(function( msg ) {
                $('#confirm-vote').modal('hide').removeClass('loading');
            }).success(function(res){
                if(data.success) location.reload();
            });

        });
    });
</script>
@endsection