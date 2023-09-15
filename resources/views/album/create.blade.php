<?php $page = 'Create'; ?>
<?php $page_title = 'Create New Album'; ?>
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

@include('layouts.header')

    <div class="inner align-content-center row">
        <form id="a-form" class="col-xl-8 col-sm-10 m-auto dropzone"
              method="POST" action="{{route('album.store')}}" enctype="multipart/form-data" >
            @csrf

            <h3>Album Form</h3>
            @if (session('success'))
                <div class="alert alert-success">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif
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
            <div class="form-group  col-xl-10">
                    <label style="width: 30%;" for="album_name">Album Name</label>
                    <input  type="text" name="album_name" class="form-control">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                       <strong style="color: red">{{ $message }}</strong>
                    </span>
                    @enderror
            </div>

            <div id="imageFields">
                <div class="image-field">
                    <label>Select image to upload:</label>
                    <input type="file" name="images[]" accept="image/*">
                    <input type="text" name="image_names[]" placeholder="Image Name" required>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" style="background-color: cornflowerblue" id="addImageField">Add another Image</button>
                <button class="align-content-center " style="color: white;" >Create Album</button>
            </div>


            <div id="imagePreview"></div>
        </form>
    </div>
@extends('layouts.footer')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
{{--Add new photo--}}
<script>
    const imageFieldsContainer = document.getElementById('imageFields');
    const addImageFieldButton = document.getElementById('addImageField');

    addImageFieldButton.addEventListener('click', function () {
        const newImageField = document.createElement('div');
        newImageField.classList.add('image-field');
        newImageField.innerHTML = `Select image to upload:
            <input type="file" name="images[]" accept="image/*">
            <input type="text" name="image_names[]" placeholder="Image Name" required>
        `;
        imageFieldsContainer.appendChild(newImageField);
    });
</script>
</body>
</html>
