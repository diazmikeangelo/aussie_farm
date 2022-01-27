@extends('template.main')

@section('content')
    <form class="mt-4" id="createForm">
        <div class="form-group mt-1">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group mt-1">
            <label for="nickname">Nickname:</label>
            <input type="text" class="form-control" name="nickname">
        </div>
        <div class="form-group mt-1">
            <label for="weight">Weight in kg:</label>
            <input type="number" class="form-control" name="weight">
        </div>
        <div class="form-group mt-1">
            <label for="height">Height in cm:</label>
            <input type="number" class="form-control" name="height">
        </div>
        <div class="form-group mt-1">
            <label for="gender">Gender:</label>
            <select class="form-control" name="gender">
              <option hidden selected> --- </option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group mt-1">
            <label for="color">Color:</label>
            <input type="text" class="form-control" name="color">
        </div>
        <div class="form-group">
            <label for="friendliness">Friendliness:</label>
            <select class="form-control" name="friendliness">
              <option value="null">N/A</option>
              <option value="friendly">Friendly</option>
              <option value="not friendly">Not Friendly</option>
            </select>
        </div>
        <div class="form-group mt-1">
            <label for="birthday">Birthday:</label>
            <input type="date" class="form-control" name="birthday" max="{{ today()->format('Y-m-d')}}">
        </div>
    </form>

    <div class="d-flex flex-row-reverse py-4">
        <button id="submit" class="btn btn-primary">Create</button>
    </div>
@endsection

@push('scripts')
    <script>
    $(function() {
        $('#submit').click(function () {
            $.ajax({
                type: 'POST',
                url: '/api/kangaroos',
                data: $('#createForm' ).serialize(),
                success: function (response) {
                    alert('Record saved!');

                    location.replace('/');
                },
                dataType: 'json'
            })
                .fail(function (error) {
                    let keyForErrorAlert = Object.keys(error.responseJSON.errors)[0];

                    alert(error.responseJSON.errors[keyForErrorAlert][0]);
                });
        });
    });
    </script>
@endpush
