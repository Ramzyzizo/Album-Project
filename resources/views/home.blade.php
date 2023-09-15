<?php $page = 'Home'; ?>
<?php $page_title = 'Home'; ?>
@include('layouts.header')
<style>
    .cart_h:hover {
        transform: scale(1.1);
    }
</style>

<link rel="stylesheet" href="{{asset('css/modal.css')}}">


<section class="h-100 h-custom" style="background-color: #eee;">
    <div class="container py-5 h-100">
        @if (session('success'))
            <div class="alert alert-success">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('success') }}
            </div>
        @endif
            {{--        errors messages--}}
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="mb-3">Your Albums</h5>
                                <hr>
                                @if(count($albums)>0)
                                    {{--                                loop on each album --}}
                                    @foreach($albums as $album)
                                        <div class="card  mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <a style="text-decoration: none" href="{{route('album.show',$album->id)}}">
                                                        <div class="cart_h d-flex flex-row align-items-center">
                                                            <div>
                                                                @if($album->photos->first()!=null)
                                                                <img
                                                                    src="{{asset('storage/'.$album->photos->first()->path)}}"
                                                                    class="img-fluid rounded-3" alt="{{$album->photos->first()->name}}" style="width: 65px;">
                                                                @else
                                                                    <h5 class="mr-5" style="color:red;">There aren't any photo for this album</h5>
                                                                    <br>
                                                                @endif
                                                            </div>
                                                            <div class="ms-3">
                                                                <h5>{{ $album->name}}</h5>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div>
                                                        <a href="{{route('album.edit',$album->id)}}" class="btn btn-success" style="color:white">Edit</a>

                                                        <a id="myBtn" onclick="openDeleteModal(this)" data-album_id="{{ $album->id }}"
                                                           data-album_name="{{ $album->name }}"
                                                           data-toggle="modal" title="Delete" class="btn btn-warning">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card  mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                               <h1>You don't have albums yet. </h1>
                                                <a href="{{route('album.create')}}" class="btn btn-success" style="color:white">Create One</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- The Modal -->


<div id="id01" class="modal">
    <span onclick="closeDeleteModal()" class="close" title="Close Modal">×</span>
    <form class="modal-content" method="POST" action="{{route('album.delete')}}">
        @csrf
        <div class="container">
            <h1>Are you sure you want to delete <span id="albumName"></span>?</h1>
            <br>
            <div class="clearfix mt-2">
                <input type="hidden" id="album_id" name="album_id" value="">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <button type="submit" class="deletebtn">Delete Full Album</button>
            </div>
        </div>
    </form>
    <form id="moveForm" class="modal-content pt-4 pb-4" style="margin-top: -100px" method="POST" action="{{route('album.move')}}">
        @csrf
        <div class="container justify-content-center align-items-center">
            <h1> Or Move your images & Delete Album <span id="albumName"></span>?</h1>
                <input type="hidden" id="album_id_2" name="album_id" value="">

            <select class="form-select form-select-lg mb-3 mr-4" name="new_album" style="width:50%;" required>
                <option selected disabled>Select Album </option>
                @foreach($albums as $album)
                    <option value="{{$album->id}}">{{$album->name}}</option>
                @endforeach
            </select>
                <button type="submit" class="btn btn-warning mt-3" >Move and Delete </button>
        </div>
    </form>

</div>
@extends('layouts.footer')
<script>
    function openDeleteModal(button) {
        var albumId = button.getAttribute("data-album_id");
        var albumName = button.getAttribute("data-album_name");

        // Set the album name in the modal
        document.getElementById("albumName").textContent = albumName;

        // Set the album ID in the modal (optional)
        // You can use the albumId value in your deleteAlbum() function
        document.getElementById("album_id").value= albumId;
        document.getElementById("album_id_2").value= albumId;

        // Remove the option corresponding to the selected album
        var albumSelect = document.getElementsByName("new_album")[0];

        for (var i = 0; i < albumSelect.options.length; i++) {
            if (albumSelect.options[i].value == albumId) {
                albumSelect.remove(i);
                break;
            }
        }
        // Make an API call to check if the album has photos
        fetch('{{url("/album_check/")}}' +'/'+albumId )
            .then(response => response.json())
            .then(data => {
                // Check if the album has photos based on the response data
                var hasPhotos = data.hasPhotos;
                console.log(hasPhotos);
                // Show/hide the move form based on whether the album has photos
                var moveForm = document.getElementById("moveForm");
                if (hasPhotos) {
                    moveForm.style.display = "block";
                } else {
                    moveForm.style.display = "none";
                }
                // Show the modal
                document.getElementById("id01").style.display = "block";
            })
    }
    function closeDeleteModal() {
        // Reset the dropdown list to its original state
        var albumSelect = document.getElementsByName("new_album")[0];
        var originalOptions = {!! json_encode($albums) !!};

        // Clear existing options
        albumSelect.innerHTML = "";

        // Add the default option
        var defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.text = "Select Album";
        defaultOption.disabled = true;
        defaultOption.selected = true;
        albumSelect.appendChild(defaultOption);

        // Add the original options
        originalOptions.forEach(function(album) {
            var option = document.createElement("option");
            option.value = album.id;
            option.text = album.name;
            albumSelect.appendChild(option);
        });

        // Hide the modal
        document.getElementById("id01").style.display = "none";
    }
</script>





