{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Gallery!</title>
</head>
<body>
    <h3>Gallery Sample View!</h3>
</body>
</html> --}}
@extends('laravel-gallery::layouts.master')
<link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css') }}">
<link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/panzoom.css') }}">
<style>
    .imagecheck {
        position: relative;
    }

    .imagecheck-figure {
        height: 120px !important;
        /* width: 120px !important; */
        overflow: hidden !important;
        ;
    }

    .imagecheck-figure img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: top center;
    }

    .view {
        padding: 0;
        width: 40px;
        height: 40px;
        position: absolute;
        top: 15%;
        right: -4%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
        z-index: 999;
        opacity: 0;
    }

    .imgcontainer:hover .view {
        opacity: 1;
    }

    .preview {
        width: 100%;
    }

    .preview img {
        width: 100%;
    }

    .btn-copy {
        cursor: pointer;
    }
</style>
@section('content')


<div class="row">
    <section class="section">
        <!-- Content Header (Page header) -->
        @include('admin.includes.content_header', ['title' => 'Media'])
        <!-- /.content-header -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (Session::has('danger') || Session::has('success'))
                        <div class="alert alert-{{ Session::has('danger') ? 'danger' : 'success' }} alert-dismissible fade show"
                            role="alert">
                            {{ Session::get('success') ?? Session::get('danger') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-header d-flex justify-content-between">
                        {{-- <h3 class="card-title">Fixed Header Table</h3> --}}
                        <div class="table-btn-actions align-items-center">

                            <form class="ajaxform_with_reset" action="{{ route('admin.media.store') }}" method="post"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="file" name="images[]" id="media" multiple />
                                <button class="btn btn-primary ajaxbtn" type="submit">Upload</button>
                            </form>

                            <div>
                                <button type="button" class="btn btn-danger deleteBtn">Delete
                                </button>
                            </div>
                        </div>

                        @include('admin.layouts.components.datafilter', [
                            // 'bulk_action_route' => route('admin.media.status'),
                            'search_route' => url('admin/media'),
                        ])

                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <section id="ajax_container">
                                {{-- ajax table  --}}
                                @if (count($media) > 0)
                                    @include('admin.media.ajax')
                                @else
                                    <div style="text-align: center;">
                                        <p>No data found!</p>
                                    </div>
                                @endif
                            </section>
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

                </div>
            </div>
        </div>
        <!-- /.card -->
        
    </section>
</div>

@endsection


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    function success(response, refresh) {
        let url = window.location.href;
        loadData(url)
    }

    $(document).on('click', '.deleteBtn', function() {
        if ($('.imagecheck-input:checked').length == 0) {
            toast("error", 'No image selected!');
            return;
        }
        $('.delete_form').submit();
    })

    $(document).on('click', '#download-image, #preview-image', function() {
        $(".card.options").hide()
    })


    $('.imgcontainer').bind('contextmenu', function(e) {
        e.preventDefault()
    
        let url = $(this).data('download-url')

        if($('.card.options').length) $('.card.options').remove()

        let optionsHTML = `<div class="card options">
                                <div class="dropdown-menu show">
                                <a href="${url}" id="preview-image" class="dropdown-item has-icon" data-fancybox >
                                    <i class="fa-solid fa-eye"></i>Preview
                                </a>
                                <a href="${url}" target="_blank" id="download-image" class="dropdown-item has-icon">
                                    <i class="fa-solid fa-download"></i>Download
                                </a>
                            </div>
                            </div>`
        
        Fancybox.bind("[data-fancybox]");
        $('body').append(optionsHTML)

        $(".card.options").css({
            left: e.clientX + window.scrollX,
            top: e.clientY + window.scrollY,
        }).show();
    });

    $(document).keyup(function(e) {
        if (e.key === "Escape") { // escape key maps to keycode `27`
            $(".card.options").hide()
        }
    });

    $(document).on('contextmenu, click', 'body', function(e) {
        $(".card.options").hide()
        // if(!$(e.target).hasClass('imgcontainer') && $(e.target).parents('.imgcontainer').length == 0){
            
        // }
    });

    $(document).on('click', '.view', function() {
        let previwUrl = $(this).data('preview-url');
        let url = $(this).data('url');
        let created_at = $(this).data('created-at');
        let html = `<div class='mb-2'>
                        <div class="input-group">
                            <input type="text" class="copy-url form-control" value="${url}">
                            <div class="input-group-append btn-copy">
                                <div class="input-group-text">
                                    <i class="fa-solid fa-copy"></i>
                                </div>
                                </div>
                            </div>
                    </div>
                    <div>
                        Created At: ${created_at}
                    </div>`
        $('.preview-img').attr('src', previwUrl)
        $('.image-info').html(html)
    })


    $(document).on('click', '.btn-copy', function() {
        $(".copy-url").select();
        document.execCommand("Copy");
    });
</script>
