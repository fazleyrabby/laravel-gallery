@extends('laravel-gallery::layouts.master')
@push('style')
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
            display: flex;
            align-items: center;
            justify-content: center;
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

        .imgcontainer {
            position: relative
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
@endpush
@section('content')
    <!-- Button trigger modal -->
    @include('laravel-gallery::layouts.modal-init', [
        'modal_id' => 'test_modal',
        'modal_type' => 'single',
        'input_name' => 'image_input',
    ])

    @include('laravel-gallery::layouts.modal-init', [
        'modal_id' => 'test_modal2',
        'modal_type' => 'multiple',
        'input_name' => 'image_inputs[]',
    ])
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script>
        function success(response, refresh) {
            let url = window.location.href;
            load(url)
        }

        function load(url) {
            $("#ajaxTable").addClass("onLoading");
            $.ajax({
                    url: url,
                })
                .done(function(data) {
                    $("#ajax_container").empty().html(data);
                    $("#ajaxTable").removeClass("onLoading");
                })
                .fail(function() {
                    console.log("Failed to load data!");
                    $("#ajaxTable").removeClass("onLoading");
                });
        }

        $(document).on('click', '.deleteBtn', function() {
            if ($('.imagecheck-input:checked').length == 0) {
                alert('Image not selected');
                // toast("error", 'No image selected!');
                return;
            } else {
                if (confirm("Are you sure?") == true) {
                    $('.delete_form').submit();
                }
            }
        })



        $(document).on('click', '#download-image, #preview-image', function() {
            $(".card.options").hide()
        })


        $('.imgcontainer').bind('contextmenu', function(e) {
            e.preventDefault()

            let url = $(this).data('download-url')

            if ($('.card.options').length) $('.card.options').remove()

            let optionsHTML = `<div class="card options">
                              <div class="dropdown-menu show">
                              <a href="${url}" id="preview-image" class="dropdown-item has-icon" data-fancybox >
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:25px;height:25px">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                              Preview
                              </a>
                              <a href="${url}" target="_blank" id="download-image" class="dropdown-item has-icon">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:25px;height:25px">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                              </svg>
                              Download
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
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:25px;height:25px">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                          </svg>

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

        /*----------------------------
          Ajaxform Submit
          ------------------------------*/
        $(document).on("submit", ".ajaxform", function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            var ajaxbtn = $(this).find('button[type="submit"]');
            var ajaxbtnhtml = ajaxbtn.html();
            $.ajax({
                type: "POST",
                url: this.action,
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    ajaxbtn.html("Please Wait....");
                    ajaxbtn.attr("disabled", "");
                },

                success: function(response) {
                    ajaxbtn.removeAttr("disabled");
                    // toast("success", response.msg ?? response);
                    alert(response.msg ?? response)
                    ajaxbtn.html(ajaxbtnhtml);

                    //response.refresh contains refresh div id

                    if (typeof success == 'function') success(response.msg ?? response, response
                        .refresh ?? '');

                },
                error: function(xhr, status, error) {
                    ajaxbtn.html(ajaxbtnhtml);
                    ajaxbtn.removeAttr("disabled");
                    // $(".errorarea").show();
                    $.each(xhr?.responseJSON?.errors, function(key, item) {
                        alert(item)
                        // toast("error", item);
                        // $("#errors").html(
                        //     "<li class='text-danger'>" + item + "</li>"
                        // );
                    });
                    // errosresponse(xhr, status, error);
                },
            });
        });
    </script>

    <script>
        let modal = null;
        let url = null;

        $(document).ready(function() {
            // let assetUrl = $('#asset-url').val();
            // Media Modal Dynamic

            $(document).on('shown.bs.modal', '.media-modal', function() {
                let page = 1;
                modal = $(this).attr('id')
                let modalContainer = '#' + modal
                let route = $(this).data('route')
                let inputName = $(this).data('image-input')
                let imageWrapper = $(`#${modal}-wrapper`)
                url = route;

                $("#ajax_container_" + modal).html("");
                appendMediaData(url, modal)


                $(document).on('click', '#save-media_' + modal, function() {
                    let checkboxes = $(`${modalContainer} .imagecheck-input:checked`);
                    console.log(checkboxes)
                    $('.' + modal + '-preview').html("")
                    imageWrapper.html("");
                    imageWrapper.append('<div class="mb-3">Image Preview:</div>');
                    if (checkboxes.length == 1) {
                        let imgUrl = checkboxes.data('url');
                        imageWrapper.append(`<img width="200" src="${imgUrl}">`)
                        imageWrapper.append(`<input hidden name=${inputName} value="${imgUrl}">`)
                    } else {
                        $(checkboxes).each(function() {
                            let imgUrl = $(this).data('url');
                            imageWrapper.append(
                                `<img width="200" src="${imgUrl}" class="mr-3 mb-3">`)
                            imageWrapper.append(
                                `<input hidden name=${inputName} value="${imgUrl}">`)
                        })

                    }
                    $('#' + modal).modal('hide');
                })


                $(document).on('click', '#load-more_' + modal, function() {
                    page++;
                    let url = route + `&page=${page}`;
                    appendMediaData(url, modal, page)
                })

                $(document).on('change', '.imagecheck-input', function() {
                    if ($(this).data('type') == 'single') {
                        if (this.checked) {
                            $('.imagecheck-input').not($(this)).prop('checked', false);
                        }
                    }
                })
            });



        });

        function appendMediaData(url, modal, page = 1) {
            $('.loader').show()
            $.ajax({
                    url: url,
                })
                .done(function(data) {
                    if (!data) {
                        $('#load-more_' + modal).prop('disabled', true)
                    } else {
                        $('#load-more_' + modal).prop('disabled', false)
                    }

                    // console.log(data)
                    if (page == 1) {
                        $("#ajax_container_" + modal).html(data);
                    } else {
                        $("#ajax_container_" + modal).append(data);
                    }
                    $('.loader').hide()
                })
                .fail(function() {
                    console.log("Failed to load data!");
                    $('.loader').hide()
                });
        }
    </script>
@endpush
