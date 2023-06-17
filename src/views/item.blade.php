@push('style')
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
@endpush

<div class="card-body" id="ajaxTable">
  <form class="delete_form" action="{{ route('gallery.delete') }}" method="post">
    @csrf
  <div class="row gutters-sm">
    @foreach ($media as $image)
    <div class="col-6 col-sm-2 imgcontainer" data-download-url="{{ route('gallery.download') . '?url=' . $image->url }}">
      <label class="imagecheck mb-2">
        <input type="checkbox" name="image_ids[]" value="{{ $image->id }}" class="imagecheck-input">
        <figure class="imagecheck-figure">
          <img src="{{ Storage::url($image->url) }}" alt="}" class="imagecheck-image">
        </figure>
      </label>
      <span class="view btn btn-primary" 
      data-created-at="{{ Carbon\Carbon::parse($image->created_at)->isoFormat('LLL') }}"
      data-preview-url="{{ Storage::url($image->url) }}" 
      data-url="{{ $image->url }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:25px;height:25px">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      
      {{-- <i class="fa fa-eye"></i> --}}
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

@if($media->count() > 10)
<div class="card-footer clearfix">
  <div class="float-left">
    {!! $media->links('pagination::bootstrap-4') !!}
  </div>
</div>
@endif
