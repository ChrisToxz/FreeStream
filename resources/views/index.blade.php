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


        div#dropzone {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999999999;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            transition: visibility 175ms, opacity 175ms;
            display: table;
            text-shadow: 1px 1px 5px #00000075;
            color: #fff;
            background: rgba(0, 0, 0, 0.45);
            font: bold 42px Oswald, DejaVu Sans, Tahoma, sans-serif;
        }
        div#textnode {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            transition: font-size 175ms;
        }
    </style>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">{{ config('app.name') }}</h1>
                <p class="lead text-muted">Simple, quick & opensource</p>
                    <p class="text-center">
                    <form id="upload">
                    <div style="visibility:hidden; opacity:0" id="dropzone">
                        <div id="textnode">Drop It Like It's Hot</div>
                    </div>
                    <button type="button" id="upload" class="btn btn-outline-primary">Select video</button> <input type="file" id="file" style="visibility: hidden; position: absolute">

                    <p class="text-muted">or drop it</p>

                    <div id="text"></div>
{{--                        <div class="loader"><img src="{{ asset('img/loading.gif') }}" /></div>--}}
{{--                        <div class="file-drop-area"> <span class="choose-file-button">Choose video</span> <span class="file-message">or drop video here</span> <input class="file-input" type="file" name="file" id="file">--}}
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

        $(document).on('click', 'button#upload', function(){
            $('#file').click();
        });


        var lastTarget = null;

        function isFile(evt) {
            var dt = evt.dataTransfer;

            for (var i = 0; i < dt.types.length; i++) {
                if (dt.types[i] === "Files") {
                    return true;
                }
            }
            return false;
        }

        window.addEventListener("dragenter", function (e) {
            if (isFile(e)) {
                lastTarget = e.target;
                document.querySelector("#dropzone").style.visibility = "";
                document.querySelector("#dropzone").style.opacity = 1;
                document.querySelector("#textnode").style.fontSize = "48px";
            }
        });

        window.addEventListener("dragleave", function (e) {
            e.preventDefault();
            if (e.target === document || e.target === lastTarget) {
                document.querySelector("#dropzone").style.visibility = "hidden";
                document.querySelector("#dropzone").style.opacity = 0;
                document.querySelector("#textnode").style.fontSize = "42px";
            }
        });

        window.addEventListener("dragover", function (e) {
            e.preventDefault();
        });

        window.addEventListener("drop", function (e) {
            e.preventDefault();
            document.querySelector("#dropzone").style.visibility = "hidden";
            document.querySelector("#dropzone").style.opacity = 0;
            document.querySelector("#textnode").style.fontSize = "42px";
            if(e.dataTransfer.files.length == 1)
            {
                document.querySelector("#text").innerHTML =
                    "<b>File selected:</b><br>" + e.dataTransfer.files[0].name;

                upload(e.dataTransfer.files[0]);
                //fcutnionm redirect
            }
        });

        function upload(file){
            var fd = new FormData();
            fd.append('file',file);

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
        }

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
                upload($('#file')[0].files[0]);
                {{--console.log(this);--}}
                {{--var fd = new FormData();--}}
                {{--var files = $('#file')[0].files;--}}
                {{--fd.append('file',files[0]);--}}

                {{--$.ajax({--}}
                {{--    type:'POST',--}}
                {{--    url: "{{ url('upload')}}",--}}
                {{--    data: fd,--}}
                {{--    cache:false,--}}
                {{--    contentType: false,--}}
                {{--    processData: false,--}}
                {{--    beforeSend:function(){--}}
                {{--        $('.choose-file-button').hide();--}}
                {{--        $('.file').attr('disabled', 'disabled');--}}
                {{--        $('.choose-file-button').attr('disabled', 'disabled');--}}
                {{--        $('.file-message').html('Uploading...');--}}
                {{--        $('.file').val('');--}}
                {{--        $(".loader").show();--}}
                {{--    },--}}
                {{--    success: (data) => {--}}
                {{--        location.reload();--}}
                {{--        console.log("File uploaded!");--}}
                {{--        console.log(data);--}}
                {{--    },--}}
                {{--    error: function(data){--}}
                {{--        console.log(data);--}}
                {{--    }--}}
                {{--});--}}
            });
        });
    </script>

@endsection
