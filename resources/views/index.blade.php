@extends('layouts.app')

@section('content')
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">{{ config('app.name') }}</h1>
                <p class="lead text-muted">Simple, quick & opensource</p>
                <p>
                    <form method="POST" enctype="multipart/form-data" id="video" action="javascript:void(0)" >
                        <label class="form-label" for="file">Video upload</label>
                        <input type="file" class="form-control" name="file" id="file" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </p>
            </div>
        </div>
        <div id="alert" role="alert">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong id="msg"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">

        <div class="container">


            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="results"></div>
            <p>
                <div class="ajax-loading text-center"><img src="{{ asset('img/loading.gif') }}" /></div>
            </p>
        </div>
    </div>
    <script>
        var page = 1;
        var total = 0;
        load_more(page);
        $(window).scroll(function() { //detect page scroll
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                load_more(page); //load content
            }
        });
        function load_more(page){
            $.ajax({
                url: "?page=" + page,
                type: "get",
                datatype: "html",
                beforeSend: function()
                {
                    $('.ajax-loading').show();
                }
            })
                .done(function(data)
                {
                    if(data.length == 0){
                        total += data.length;
                        console.log(data.length);
                        if(total == 0 && page == 1){
                            $('.ajax-loading').html("Upload your first video!");
                            return;
                        }
                        $('.ajax-loading').html("No more videos!");
                        return;
                    }
                    $('.ajax-loading').hide();
                    $("#results").append(data);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    alert('Oops, something went wrong.');
                });
        }
    </script>
    <script type="text/javascript">
        $('#alert').hide();
        $(document).on('click', '#button', function(){
            tag = $(this).closest('.col').attr('id');
            switch(this.value){
                case 'delete':
                    console.log('Delete Tag: '+ tag);
                    $.ajax({
                        type:'DELETE',
                        url: "{{ url('delete')}}/"+tag,
                        success: (data) => {

                            $('#msg').text('Deleted!')
                            $('#alert').show();
                            $(this).closest('.col').remove();
                            console.log("Deleted");
                            console.log(data);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });

            }


        });
    </script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#video').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: "{{ url('upload')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        this.reset();
                        location.reload();
                        console.log("File uploaded!");
                        console.log(data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
        });
    </script>

@endsection
