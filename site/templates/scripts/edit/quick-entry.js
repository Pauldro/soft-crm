$(function() {
    $("body").on("change", ".calculates-price", function(e) {
        var line = $(this).parent('.detail');
        var input_qty = line.find("input[name=qty]");
        var input_price = line.find("input[name=price]");
        var input_minprice = line.find("input[name=min-price]");
        var text_totalprice = line.find('.total-price');

        //ADD code to calculate total price
        // Replace value in text_totalprice
        // check if config.edit.pricing.allow_belowminprice is true
        // if it is then check if price is below minimum allowed
        // if below minimum show error.

    });
});
