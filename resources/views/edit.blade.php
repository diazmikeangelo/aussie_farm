@extends('template.main')

@section('content')
<form class="mt-4" id="updateForm" data-kangaroo-id={{ $kangaroo->id }}>
    <div class="form-group mt-1">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" value={{ $kangaroo->name }}>
    </div>
    <div class="form-group mt-1">
        <label for="nickname">Nickname:</label>
        <input type="text" class="form-control" name="nickname" value={{ $kangaroo->nickname }}>
    </div>
    <div class="form-group mt-1">
        <label for="weight">Weight in kg:</label>
        <input type="number" class="form-control" name="weight" value={{ $kangaroo->weight }}>
    </div>
    <div class="form-group mt-1">
        <label for="height">Height in cm:</label>
        <input type="number" class="form-control" name="height" value={{ $kangaroo->height }}>
    </div>
    <div class="form-group mt-1">
        <label for="gender">Gender:</label>
        <select class="form-control" name="gender">
          <option value="male" {{ $kangaroo->gender == 'male' ? 'selected' : '' }}>Male</option>
          <option value="female" {{ $kangaroo->gender == 'female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    <div class="form-group mt-1">
        <label for="color">Color:</label>
        <input type="text" class="form-control" name="color" value={{ $kangaroo->color }}>
    </div>
    <div class="form-group">
        <label for="friendliness">Friendliness:</label>
        <select class="form-control" name="friendliness">
          <option value="">N/A</option>
          <option value="friendly" {{ $kangaroo->friendliness == 'friendly' ? 'selected' : ''}}>Friendly</option>
          <option value="not friendly" {{ $kangaroo->friendliness == 'not friendly' ? 'selected' : ''}}>Not Friendly</option>
        </select>
    </div>
    <div class="form-group mt-1">
        <label for="birthday">Birthday:</label>
        <input
            type="date"
            class="form-control"
            name="birthday"
            max="{{ today()->format('Y-m-d')}}"
            value={{ $kangaroo->birthday }}
        >
    </div>
</form>

<div class="d-flex flex-row-reverse py-4">
    <button id="submit" class="btn btn-primary">Update</button>
</div>
@endsection

@push('scripts')
    <script>
    $(function() {
        $('#submit').click(function () {
            let kangarooId = $('#updateForm').data('kangaroo-id');
            
            $.ajax({
                type: 'PATCH',
                url: `/api/kangaroos/${kangarooId}`,
                data: $('#updateForm').serialize(),
                success: function (response) {
                    alert('Record updated!');

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
