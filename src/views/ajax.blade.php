<style>
    .card.options{
      position: absolute;
      left: 5%;
      /* display: none; */
    }

    .card.options .dropdown-menu{
      box-shadow: box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; !important;
    }
  </style>

<div class="card-body" id="ajaxTable">
  <form class="delete_form" action="{{ route('admin.media.delete') }}" method="post">
    @csrf
  <div class="row gutters-sm">
    @foreach ($media as $image)
    <div class="col-6 col-sm-2 imgcontainer" data-download-url="{{ route('admin.media.download') . '?url=' . $image->url }}">
      <label class="imagecheck mb-2">
        <input type="checkbox" name="image_ids[]" value="{{ $image->id }}" class="imagecheck-input">
        <figure class="imagecheck-figure">
          <img src="{{ Storage::url($image->url) }}" alt="}" class="imagecheck-image">
        </figure>
      </label>
      <span class="view btn btn-primary" 
      data-created-at="{{ Carbon\Carbon::parse($image->created_at)->isoFormat('LLL') }}"
      data-preview-url="{{ Storage::url($image->url) }}" 
      data-url="{{ $image->url }}"><i class="fa fa-eye"></i>
      </span>
      {{-- <a href="{{ route("admin.media.download") .'?url='. $image->url }}" target="_blank">Download</a> --}}
    </div>
    @endforeach
  </div>
</form>
  {{-- <div class="row">
    <div class="col-12">
      <div class="gallery">
        @foreach ($media as $image)
        <div class="gallery-item" data-image="{{ asset($image->url) }}" data-title="Image 1" href="{{ asset($image->url) }}" title="Image 1" style="background-image: url(&quot;{{ asset($image->url) }}&quot;);"></div>
        @endforeach
      </div>
    </div>
  </div> --}}
  
</div>
<div class="card-footer clearfix">
  <div class="float-left">
    {!! $media->links('pagination::bootstrap-4') !!}
  </div>
</div>