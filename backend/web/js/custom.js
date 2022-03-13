// disable auto discover

// init dropzone on id (form or div)

function initializeMyPlugin() {

    $('[data-switchery]').each(function () {
        var $this = $(this),
            color = $this.attr('data-color') || '#188ae2',
            jackColor = $this.attr('data-jackColor') || '#ffffff',
            size = $this.attr('data-size') || 'default'

        new Switchery(this, {
            color: color,
            size: size,
            jackColor: jackColor
        });
    });
}

$(document).on('pjax:complete', function (event) {
    //$(event.target).initializeMyPlugin()
    initializeMyPlugin()
})

$(document).ready(function () {

    $(".image_list_container, .content_container").on('click', '.remove-btn', function () {

        var $data_url = $(this).data("url");

        //alert($data_url);

        Swal.fire({
            title: 'Are you sure?',
            text: "You will not be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            //cancelButtonText: 'No',
        }).then(function (result) {

            /*if (result.dismiss === 'cancel') {
                alert('Cancel clicked');
            }*/

            if (result.value === true) {

                $.ajax({
                    type: 'POST',
                    url: $data_url,
                    dataType: 'json',
                    /*beforeSend: function () {
                        swal.fire({
                            title: 'Please Wait..!',
                            text: 'Is working..',
                            willOpen: function () {
                                swal.showLoading()
                            }
                        })
                    },*/
                    success: function (data) {
                        /*const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted successfully'
                        }).then(function () {
                            location.reload();
                        })*/

                        iziToast.success({
                            title: 'Success',
                            message: 'Deleted successfully',
                            position : "topCenter",
                            timeout: 1500,
                            onClosing: function (){
                                location.reload();
                            }
                        })

                    },
                    complete: function () {
                        //swal.hideLoading();
                        //location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //swal.hideLoading();
                        swal.fire("!Opps ", "Something went wrong, try again later", "error");
                    }
                })

            }
        })
    });

    $(".image_list_container, .content_container").on('change', '.isActive', function () {
        //alert('tiklandi');
        //console.log('tiklandi');
        $data = ($(this).prop("checked") === true) ? 1 : 0;
        //console.log($data);
        var $data_url = $(this).data("url");
        if (typeof $data !== "undifined" && typeof $data !== "undifined") {

            console.log($data);
            $.ajax({
                type: 'POST',
                url: $data_url,
                data: $data,
                success: function (data) {
                    console.log(data);
                },
                error: function (exception) {
                    alert(exception);
                }
            })
        }
    })


    $(".image_list_container, .content_container").on('change', '.isCover', function () {
        //alert('tiklandi');
        //console.log('tiklandi');
        $data = ($(this).prop("checked") === true) ? 1 : 0;
        //console.log($data);
        var $data_url = $(this).data("url");
        if (typeof $data !== "undifined" && typeof $data !== "undifined") {

            console.log($data);
            $.ajax({
                type: 'POST',
                url: $data_url,
                data: $data,
                success: function (data) {
                    console.log(data);
                },
                error: function (exception) {
                    alert(exception);
                }
            })
        }
    })

    Dropzone.autoDiscover = false;
    /*$(document).on('pjax:complete', function() {
        $('[data-switchery]').each(function(){
            var $this = $(this),
                color = $this.attr('data-color') || '#188ae2',
                jackColor = $this.attr('data-jackColor') || '#ffffff',
                size = $this.attr('data-size') || 'default'

            new Switchery(this, {
                color: color,
                size: size,
                jackColor: jackColor
            });
        });
    })*/

    var uploadSection = Dropzone.forElement("#dropzone2");

    uploadSection.on("complete", function (file) {
        var $data_url = $("#dropzone2").data('url');
        //alert('dosya yüklendi');
        console.log($data_url);
        /*$.post($data_url, {}, function (response) {
            $(".image_list_container").html(response);
        })*/
        $('[data-switchery]').remove();
        $.pjax.reload({container: '#image-reflesh-list'});

        /*$(document).on('pjax:complete', function(event) {
            //$(event.target).initializeMyPlugin()
            initializeMyPlugin()
        })*/


    });

});