<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="results">
    @foreach($videos as $video)
        <div class="col" id="rBEX" x-data="{ isReady: {{ $video->finished }}, modal{{ $video->tag }}: false  }">
            <div x-show="modal{{ $video->tag }}" class="modal-backdrop show"></div>
            <div x-show="modal{{ $video->tag }}">
                <div class="modal fade show" style="display: block;" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit-{{ $video->tag }}">Edit video: {{ $video->title }} </h5><small class="float-end">Tag: {{ $video->tag }}</small>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" wire:model="title">
                                        @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Tag</label>
                                        <input type="text" disabled class="form-control" id="tag" value="{{ $video->tag }}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Hash</label>
                                        <input type="text" disabled class="form-control" id="hash" value="{{ $video->hash }}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Stream hash</label>
                                        <input type="text" disabled class="form-control" id="streamhash" value="{{ $video->streamhash }}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Files</label>
                                        <textarea disabled class="form-control" id="files">@foreach($video->files as $file) {{ $file }} &#013; &#010; @endforeach</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Custom link</label>
                                        <input type="text" disabled class="form-control" id="slug" value="Slug" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Retention policy</label>
                                        <select class="form-control">
                                            <option>X views</option>
                                            <option>Date</option>
                                        </select>
                                    </div>


                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="modal{{ $video->tag }} = false" data-bs-dismiss="modal">Close</button>
                                <button type="button" wire:click.prevent="update()" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm h-100">
                <a href="http://localhost/v/{{ $video->tag }}">
                    <img class="card-img-top" style="    width: 100%; height: 15vw; object-fit: cover;" src="{{ asset('/storage/videos/'.$video->tag.'/thumb.jpg') }}" alt="Thumbnail"></a>
                <div class="card-body">
                    <h5 class="card-title ">@if($video->type == 2)<small><i class="bi-cast"></i></small> -@endif {{ $video->title }}  <small class="text-muted"> - 00:00</small><small class="text-muted float-end "><h5 class="@if($video->type == 2) text-success @endif">Tag: {{ $video->tag }}</h5></small></h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</h6>

                        @if(!$video->finished)
                        <p class="text-center">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $video->progressnow }}%"><span class="justify-content-center d-flex position-absolute w-100 text-dark">Processing video - {{ $video->progressnow }}%</span></div>
                            </div>
                        </p>
                        @else
                            <p class="card-text">
                                <button @click="modal{{ $video->tag }} = true" wire:click="edit('{{ $video->tag }}')" class="btn btn-sm btn-outline-secondary" >Edit</button>
                                <button wire:click="destroy('{{ $video->tag }}')" type="button" class="btn btn-sm btn-outline-danger" id="button" value="delete">Delete</button>
                                <small class="text-muted float-end" >0 MB - 0 views</small>
                            </p>
                        @endif

                </div>
            </div>

        </div>

    @endforeach

</div>
