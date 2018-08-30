$(function() {
    $("body").on("click", ".finish-item", function(e) {
        e.preventDefault();
        var button = $(this);
        
        if (pickitem.item.qty.remaining > 0) {
            swal({
                title: 'Are you sure?',
                text: "You have not met the Quantity Requirments",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: 'Yes!'
            }).then(function (result) {
                console.log(result);
                if (result) {
                    window.location.href = button.attr('href');
                }
            }).catch(swal.noop);
        } else {
            window.location.href = button.attr('href');
        }
    });
});
