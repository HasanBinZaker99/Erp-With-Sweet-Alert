@extends('CRM.layouts_successLeeds.leedsNav')
@section('leedContent')

<div class="col-md-12 card mr-4">
<div class="card-title py-2">
  <a href="{{route('add-meeting',['id'=>$leed->id])}}" class="btn btn-success float-right">+Add</a>
</div>

<div class="card">
  <div class="row g-0">
  @foreach ($meetings as $meeting)
    <div class="col-md-4">
      <div class="card mt-5 bg-dark" style="max-width: 150px; max-height: 30px;">
        <div class="card-title ml-2">
            <h1 class="text-white text-lg">{!! date('d M y', strtotime($meeting->meetingDateAndTime)) !!}</h1>
        </div>
      </div>
    </div>
    <div class="col-md-8 mb-0">
      <div class="card-body">
        <h5 class="card-title">{{$meeting->meetingDateAndTime}}</h5>
        <p class="card-text">
          Internet call logs
        </p>
        <p class="card-text">
          Created By {{$meeting->meetingDateAndTime}} on {{$meeting->userId}}
        </p>
        <p class="card-text">
          <button class="btn btn-danger btn-sm mx-1">Edit</button>
          <button class="btn btn-dark btn-sm">delete</button>
        </p>
        <hr>
      </div>
    </div>
    @endforeach
  </div>
</div>

</div>
<script>
    function create()
    {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 9000
        });
        event.preventDefault();
        Toast.fire({
            icon: 'success',
            title: 'New Company Information Added Successfully'
        })
    }
    function wise_words()
    {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 9000
        });
        event.preventDefault();
        Toast.fire({
            icon: 'success',
            title: 'Company Information Deleted Successfully'
        })
    }
    function update()
    {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 9000
        });
        event.preventDefault();
        Toast.fire({
            icon: 'success',
            title: 'Company Information Updated Successfully'
        })
    }
</script>


@endsection('leedContent')
