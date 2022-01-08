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
    <section class="py-sm-0 text-center container">
        <div class="row py-lg-3">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">{{ config('app.name') }}</h1>
                <p class="lead text-muted">Simple, quick & opensource</p>
                <p class="text-center">

                @livewire('upload-video')

                </p>
            </div>
        </div>
    </section>
    <div class="album py-5 bg-light">
        <div class="container">
            <livewire:load-videos />
    </div>
@endsection
