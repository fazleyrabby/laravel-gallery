

    @foreach ($media as $image)
    <div class="col-2 imgcontainer">
      <label class="imagecheck mb-2">
        <input type="checkbox" name="{{ request()->modal_type == 'single' ? 'image_ids' : 'image_ids[]' }}" value="{{ $image->id }}" class="imagecheck-input" data-type="{{ request()->modal_type }}"  data-url="{{ Storage::url($image->url) }}">
        <figure class="imagecheck-figure">
          <img src="{{ Storage::url($image->url) }}" alt="{{ basename($image->url) }}" class="imagecheck-image">
        </figure>
      </label>
      
      {{-- <a href="{{ route("admin.media.download") .'?url='. $image->url }}" target="_blank">Download</a> --}}
    </div>
    @endforeach