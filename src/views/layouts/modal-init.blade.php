



<div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">
        {{ $modal_id }} Modal
    </button>
    <div id="{{ $modal_id }}-wrapper">
    </div>
</div>


<!-- Modal -->
<div class="modal fade media-modal" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}Label" aria-hidden="true"
data-image-input="{{ $input_name }}"
data-route="{{ url('/gallery') }}?type=modal&modal_type={{ $modal_type }}"
>
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $modal_id }} title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <section class="section">
                    <!-- Content Header (Page header) -->
                    {{-- @include('admin.includes.content_header', ['title' => 'Media']) --}}
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    @if (Session::has('danger') || Session::has('success'))
                                        <div class="alert alert-{{ Session::has('danger') ? 'danger' : 'success' }} alert-dismissible fade show"
                                            role="alert">
                                            {{ Session::get('success') ?? Session::get('danger') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="table-btn-actions align-items-center">
                                        <form class="ajaxform" action="{{ route('gallery.store') }}" method="post" enctype="multipart/form-data"
                                            novalidate>
                                            @csrf
                                            <input type="file" name="images[]" id="media" multiple />
                                            <button class="btn btn-primary ajaxbtn" type="submit">Upload</button>
                                        </form>
        
                                        <div>
                                            <button type="button" class="btn btn-danger deleteBtn">Delete
                                            </button>
                                        </div>
                                    </div>
        
                                    {{-- @include('admin.layouts.components.datafilter', [
                                    // 'bulk_action_route' => route('admin.media.status'),
                                    'search_route' => url('admin/media'),
                                ]) --}}

                           
        
                                </div>
        
        
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="container">
                                            <section class="row" id="ajax_container_{{ $modal_id }}">
                                                {{-- ajax table  --}}
                                                @if (count($media) > 0)
                                                    @include('laravel-gallery::item')
                                                @else
                                                    <div style="text-align: center;">
                                                        <p>No data found!</p>
                                                    </div>
                                                @endif
                                            </section>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-4">
                                            <div class="preview mb-3">
                                                <img class="preview-img" src="https://via.placeholder.com/600x400">
                                            </div>
                                            <div class="image-info">
                                                <p>No data found!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div>
                                    <button id="load-more_{{ $modal_id }}" class="btn btn-primary">Load More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
        
                </section>
            </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}

          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save-media_{{ $modal_id }}">Save</button>
        </div>
        </div>
      </div>
    </div>
  </div>
  
 

 