<?php $page = 'Home'; ?>
<?php $page_title = 'Edit Album'; ?>
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

@include('layouts.header')

<div class="inner align-content-center row">
    <form id="a-form" class="col-xl-8 col-sm-10 m-auto dropzone"
          method="POST" action="{{route('album.update',$album->id)}}" enctype="multipart/form-data" >
        @csrf
        {{method_field('patch')}}

        <h3>Album Form</h3>
        {{--        success messages--}}
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
{{--        Name of Album--}}
        <div class="form-group  col-xl-10">
            <label style="width: 30%;" for="album_name">Album Name</label>
            <input  type="text" name="album_name" class="form-control" value="{{$album->name}}">
            @error('name')
            <span class="invalid-feedback" role="alert">
                       <strong style="color: red">{{ $message }}</strong>
                    </span>
            @enderror
        </div>

        <div id="imageFields">
            @foreach($album->photos as $photo)
            <div class="image-field">
                <input type="hidden" name="images_ids[]" value="{{$photo->id}}" accept="image/*">
                <img src="{{ asset('storage/'.$photo['path']) }}" class="img-fluid rounded-3" alt="" style="height: 100px;">
                <input class="upload_photo" type="file" name="images[]" accept="image/*">
                <input type="text" name="image_names[]" value="{{$photo->name}}"  required>
                <a href="#" class="ml-4 remove-link"><span style="color: red">X</span> Remove</a>
            </div>
            @endforeach
        </div>
{{--        options buttons/--}}
        <div class="d-flex justify-content-between">
            <button type="button" style="background-color: cornflowerblue" id="addImageField">Add another Image</button>
            <a href="{{url('/')}}" class="btn btn-info" id="addImageField">Cancel</a>
            <button class="align-content-center " style="color: white;" >Update Album</button>
        </div>
        <div id="imagePreview"></div>
    </form>
</div>
@extends('layouts.footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
{{--
- remove new photo
- update new preview image
--}}
<script>
    $(document).ready(function() {
    //remove section of photo
    $('.remove-link').click(function(e) {
        e.preventDefault();
        $(this).closest('.image-field').remove();
    });
    // update image preview
    $('.upload_photo').change(function() {
        var $imageField = $(this).closest('.image-field');
        var $imagePreview = $imageField.find('img');
        var file = this.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            $imagePreview.attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    });
    });
</script>
{{--
- Add new photo
- remove old sections
- preview old sections
--}}
<script>
        const imageFieldsContainer = document.getElementById('imageFields');
        const addImageFieldButton = document.getElementById('addImageField');

        addImageFieldButton.addEventListener('click', function () {
            const newImageField = document.createElement('div');
            newImageField.classList.add('image-field');
            newImageField.innerHTML = `
            <img src="https://img.freepik.com/premium-vector/smiling-face-emoji_6735-648.jpg?w=2000" class="img-fluid rounded-3" alt="" style="height: 100px;">
            <input class="upload_photo" type="file" name="images[]" value="kk" accept="image/*" required>
            <input type="hidden" name="images_ids[]" value="na" accept="image/*">
            <input type="text" name="image_names[]" placeholder="Image Name" required>
            <a href="#" class="ml-4 remove-link"><span style="color: red">X</span> Remove</a>

        `;
            const removeLink = newImageField.querySelector('.remove-link');

            removeLink.addEventListener('click', function (e) {
                e.preventDefault();
                newImageField.remove();
            });

            const uploadPhotoInput = newImageField.querySelector('.upload_photo');
            uploadPhotoInput.addEventListener('change', function () {
                const imagePreview = newImageField.querySelector('img');
                const file = this.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });

            imageFieldsContainer.appendChild(newImageField);
        });
</script>
</body>
</html>
