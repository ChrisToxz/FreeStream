@extends('layouts.app')

@section('content')
    <style>

        .file-drop-area {
            position: relative;
            display: flex;
            align-items: center;
            width: 450px;
            max-width: 100%;
            padding: 25px;
            border: 1px dashed rgba(255, 255, 255, 0.4);
            border-radius: 3px;
            transition: 0.2s;
            margin: auto;
        }

        .file-drop-area:hover .choose-file-button{
            background-color: rgb(211 211 211);
            border: 1px solid rgb(17 17 17 / 20%);
        }


        .choose-file-button {
            flex-shrink: 0;
            background-color: rgb(211 211 211 / 75%);
            border: 1px solid rgb(17 17 17 / 20%);
            border-radius: 3px;
            padding: 8px 15px;
            margin-right: 10px;
            font-size: 12px;
            text-transform: uppercase
        }



        .file-message {
            font-size: small;
            font-weight: 300;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: auto;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
            opacity: 0
        }

        .mt-100 {
            margin-top: 100px
        }
    </style>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">{{ config('app.name') }}</h1>
                <p class="lead text-muted">Simple, quick & opensource</p>
                    <p class="text-center">
                    <form id="upload">
                        <div class="loader"><img src="{{ asset('img/loading.gif') }}" /></div>
                        <div class="file-drop-area"> <span class="choose-file-button">Choose video</span> <span class="file-message">or drop video here</span> <input class="file-input" type="file" name="file" id="file">
                    </form>
                    </div>
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
            $(".loader").hide();
            $('input[type=file]').change(function(e) {
                e.preventDefault();
                console.log(this);
                var fd = new FormData();
                var files = $('#file')[0].files;
                fd.append('file',files[0]);

                $.ajax({
                    type:'POST',
                    url: "{{ url('upload')}}",
                    data: fd,
                    cache:false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('.choose-file-button').hide();
                        $('.file').attr('disabled', 'disabled');
                        $('.choose-file-button').attr('disabled', 'disabled');
                        $('.file-message').html('Uploading...');
                        $('.file').val('');
                        $(".loader").show();
                    },
                    success: (data) => {
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
