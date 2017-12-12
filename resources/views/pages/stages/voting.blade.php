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
                                    <small class="text-muted">Lead Engineer</small>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ '/storage/'.$candidate->deputy_pic }}" alt="Thumbnail Image" class="img-raised img-rounded">
                                <h4 class="title">{{ $candidate->deputy_name }}<br />
                                    <small class="text-muted">Former Football Player</small>
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
                    <a href="#" class="btn btn-block {{ ($key%2==0)?'btn-warning':'btn-info' }} btn-vote" data-id="{{ $candidate->id }}">vote for no. {{ $key+1 }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

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
            var data = {"id":$(this).attr('data-id')};
            $.ajax({
                method: 'POST',
                url: '{{ route('voting') }}',
                data: data
            }).done(function( msg ) {
                console.log(msg);
            });
            return false;
        });
    });
</script>
@endsection