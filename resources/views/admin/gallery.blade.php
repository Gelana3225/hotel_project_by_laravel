<!DOCTYPE html>
<html>
  <head> 
    @include ('admin.css')
  </head>
  <body>
    @include ('admin.header')
    @include ('admin.sidebar')

      <!-- Sidebar Navigation end-->

     <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

          <center>

            <h1 style="font-size: 40px; font-weight: bolder; color:white">Gallary</h1>

        <div class="row">

            @foreach($gallery as $gallery)

           <div class="col-md-4">

            <img style="height:200!important; width:300!important;" src="/gallery/{{ $gallery->image }}">

            <a class="btn btn-primary" href="{{ url('delete_gallery',$gallery->id) }}">Delete Image</a>

           </div>


            @endforeach

        </div>

            <form action="{{ url('upload_gallery') }}" method="Post" enctype="multipart/form-data">
                @csrf
                <div style="padding: 30px;">
                    <label style="color:white; font-weight: bold;">Upload</label>
                    <input type="file" name="image" required>

                    <input class="btn btn-primary" type="submit" value="Add Image">
                </div>
            </form>

         </center>



          </div>
        </div>
      </div>
        @include ('admin.footer')
  </body>
</html>