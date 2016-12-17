/*
Team Project: Assignment 3
*/
var $numOfSet, standard, express, $subtotal, shipping, $shippingMethod, totalQty;

$(function () {
    $('#loader').hide();
    initializeCartPage();
    imagePreview();
    $('#cartForm').change(formChangeListener);
    $('#filterForm').change(filterChangeListener);
    $('.prompt').keyup(searchListener);
});

/*******************************************************************************/
/*                     mouseover and diplay avg pic                            */
/*******************************************************************************/

this.imagePreview = function () {
    // these 2 variable determine popup's distance from the cursor
    yOffset = 300;
    xOffset = 30;
    $('.thumbnail').hover(function (e) {
            var $avgImg = this.src.replace('square-medium', 'average');
            $('main').append('<div id="preview"><img src="' + $avgImg + '"></div>');
            $('#preview')
                .css('position', 'absolute')
                .css('top', (e.pageY - yOffset) + 'px')
                .css('left', (e.pageX + xOffset) + 'px')
                .fadeIn('fast');
        },
        function () {
            $('#preview').remove();
        });
    $('.thumbnail').mousemove(function (e) {
        $('#preview')
            .css('top', (e.pageY - yOffset) + 'px')
            .css('left', (e.pageX + xOffset) + 'px');
    });
};

/*******************************************************************************/
/*                               shopping cart                                 */
/*******************************************************************************/

function initializeCartPage() {
    $numOfSet = $('#numOfSet').text();
    shipping = $subtotal = 0;
    $shippingMethod = 'Standard';
    $('[value="selected"]').text($shippingMethod);
    for (var i = 0; i < $numOfSet; i++) {
        var $qty = $('.qty' + i).val();
        displayAllItemsPrice($qty, i);
        displaySetPrice(i);
        displaySubtotal();
    }
    if ($numOfSet != 0) {
        updateShippingFee();
        updateShippingDropdown();
        calculateShippingFee();
        displayShipping();
        displayTotal();
    }

}

function formChangeListener(e) {
    e = e || window.Event;
    var target = e.target || e.srcElement;
    if (target.nodeName != 'SELECT' && target.nodeName != 'INPUT') return;
    else {
        var node = target.id || target.className;
        var parts = node.match(/[a-zA-Z]+|[0-9]+/g);
        switch (parts[0]) {
        case 'qty':
            qtyChange(parts[1], node);
            break;
        case 'frame':
        case 'glass':
        case 'matt':
            itemChange(parts[1], node, parts[0]);
            break;
        case 'shippingMethod':
            shippingChange();
            break;
        }
    }
    $.post($(this).attr('action'), $(this).serialize());
}

/*
update price when qty change
*/
function qtyChange(i, nodeName) {
    var $qty = $('.' + nodeName).val();
    displayAllItemsPrice($qty, i);
    displaySetPrice(i);
    displaySubtotal();
    updateShippingFee();
    updateShippingDropdown();
    calculateShippingFee();
    displayShipping();
    displayTotal();
    updateTotalQtyInCartIcon();
}

function itemChange(i, id, name) {
    var $unitPrice = organizeValueFromSelect($('#' + id).val());
    $('.unitPrice' + i + '.' + name).text(addComma($unitPrice));
    var $qty = $unitPrice === '0' ? '0' : $('#totalpainting' + i).parent().children()[2].textContent;
    displayQty(i, name, $qty);
    displayTotalItemPrice(i, name, $qty, $unitPrice);
    displaySetPrice(i);
    displaySubtotal();
    updateShippingFee();
    updateShippingDropdown();
    calculateShippingFee();
    displayShipping();
    displayTotal();
}

function shippingChange() {
    if ($numOfSet != 0) {
        $shippingMethod = $('#shippingMethod').val();
        calculateShippingFee();
        displayShipping();
        displayTotal();
    }

}

function displayAllItemsPrice(qty, i) {
    $('.unitPrice' + i).each(function (index, value) {
        var $str = $(value).text();
        switch (index) {
        case 3:
            $('#totalmatt' + i).text(addComma(basePrice(qty, $str)));
            if ($str != '0') displayQty(i, 'matt', qty);
            break;
        case 2:
            $('#totalglass' + i).text(addComma(basePrice(qty, $str)));
            if ($str != '0') displayQty(i, 'glass', qty);
            break;
        case 1:
            $('#totalframe' + i).text(addComma(basePrice(qty, $str)));
            if ($str != '0') displayQty(i, 'frame', qty);
            break;
        case 0:
            $('#totalpainting' + i).text(addComma(basePrice(qty, $str)));
            if ($str != '0') displayQty(i, 'painting', qty);
            break;
        }
    });
}

function calculateShippingFee() {
    switch ($shippingMethod) {
    case 'Standard':
        shipping = standard;
        break;
    case 'Express':
        shipping = express;
        break;
    }
}

function updateTotalQty() {
    totalQty = 0;
    for (var i = 0; i < $numOfSet; i++) {
        totalQty += ~~$('#totalpainting' + i).parent().children()[2].textContent;
    }
    return totalQty;
}

function displayShipping() {
    shipping = $subtotal == 0 ? 0 : (shipping * updateTotalQty());
    $('#shipping').text(addComma(shipping));
}

function displayTotal() {
    $subtotal = $subtotal || 0;
    $('#total').text(addComma(shipping + $subtotal));

}

function updateTotalQtyInCartIcon() {
    $('#qtyOfItem').text(totalQty);
}

function displayQty(i, name, qty) {
    $('#total' + name + i).next().next().text(qty);
}

function displaySetPrice(i) {
    $('#setPrice' + i).text(addComma(setPrice(i)));
}

function displayTotalItemPrice(i, name, qty, unitPrice) {
    $('#total' + name + i).text(addComma(basePrice(qty, unitPrice)));
}

function displaySubtotal() {
    $('#subtotal').text(addComma(subtotal()));
}

function subtotal() {
    $subtotal = 0;
    for (var i = 0; i < $numOfSet; i++) {
        $subtotal += removeComma($('#setPrice' + i).text());
    }
    return $subtotal;
}

function setPrice(i) {
    return removeComma($('#totalmatt' + i).text()) +
        removeComma($('#totalglass' + i).text()) +
        removeComma($('#totalframe' + i).text()) +
        removeComma($('#totalpainting' + i).text());
}

function updateShippingDropdown() {
    var strStd = standard == 25 ? '$25/item' : 'Free';
    var strExp = express == 50 ? '$50/item' : 'Free';
    $('[value="Standard"]').text('Standard  ' + strStd);
    $('[value="Express"]').text('Express  ' + strExp);
}

function updateShippingFee() {
    standard = 25;
    express = 50;
    if ($subtotal > 1500) standard = 0;
    if ($subtotal > 2500) express = 0;
}


function basePrice(qty, price) {
    return removeComma(price) * ~~qty;
}

function removeComma(price) {
    return ~~price.replace(',', '');
}

function addComma(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function organizeValueFromSelect(value) {
    return value.split('|')[1]; //id|price and only need price
}

/*******************************************************************************/
/*                            filter                                           */
/*******************************************************************************/
function filterChangeListener(e) {
    slideLeft();
    e = e || window.Event;
    var target = e.target || e.srcElement;
    if (target.nodeName != 'SELECT') return;
    resetOtherSelect(target);
    $.post($(this).attr('action'), $(this).serialize(), function (data) {
        displayFilteredData(data, generateHeader(target));
        slideRight();
    });
}

function generateHeader(target) {
    var selected = target.selectedOptions[0];
    return selected.value != '0' ? target.name.toUpperCase() + ' = ' + selected.textContent.toUpperCase() : 'ALL PAINTINGS [TOP20]';
}

function resetOtherSelect(target) {
    $('#filterForm select').not(target).prop('selectedIndex', 0);
}

/*
when click filter menu then run this
*/
function slideLeft() {
    $('#defalut20').transition({
        animation: 'slide left',
        duration: '0.5s',
        onComplete: function () {
            $('#loader').show();
        }
    });
}

/*
when ajax complete then run this
*/
function slideRight() {
    $('#defalut20').transition({
        animation: 'slide right',
        duration: '1s',
        onStart: function () {
            $('#loader').fadeOut('slow');
        }
    });
}

function displayFilteredData(data, header) {
    $('.top20Painting').text(header);
    for (var i = 0, len = data.length; i < 20; i++) {
        if (i < len) { //display 20 or less 20 new painting list
            updatePaintingList(data[i], i);
        } else { //if less 20 then the extra rows below in list should be hide, later they could be displayed
            $('#defalut20 #row' + i).hide(); //hide rest of row if there are less 20 after filter
        }
    }
}

function updatePaintingList(obj, i) {
    $('#defalut20 #row' + i).show(); //show the row that will be displayed which previously hidden
    $('#defalut20 #row' + i + ' .title').text(obj.Title);
    $('#defalut20 #row' + i + ' img').attr('alt', obj.Title);
    $('#defalut20 #row' + i + ' a').each(function () {
        $(this).attr('href', $(this).attr('href').replace(/id=[^&]+/, 'id=' + obj.PaintingID));
    });
    $('#defalut20 #row' + i + ' img').attr('src', 'images/art/works/square-medium/' + obj.ImageFileName + '.jpg');
    $('#defalut20 #row' + i + ' p').html(obj.Excerpt);
    $('#defalut20 #row' + i + '  .lastName').text(obj.LastName);
    $('#defalut20 #row' + i + '  .price').text('$' + addComma(obj.MSRP.split('.')[0]));
    var heartIconClassName = obj.Heart == 'red' ? 'red heart icon' : 'heart icon'; //update heart icon after being filtered
    var buttonPopUP = obj.Heart == 'red' ? 'View Favorite list' : 'Add item to Favorite'; //update heart icon popup after being filtered
    var $heartIcon = $('#defalut20 #row' + i + ' i:eq(1)');
    $heartIcon.removeClass($heartIcon.attr('class')).addClass(heartIconClassName);
    $heartIcon.parent().attr('data-tooltip', buttonPopUP);
}

/*******************************************************************************/
/*                     search dropdown                                         */
/*******************************************************************************/

function searchListener() {
    $.post('service-painting.php', {
            search: $(this).val()
        },
        function (data) {
            var content = organizeSearchedData(data);
            $('.ui.search').search({
                source: content,
                searchFields: 'title',
                searchFullText: false,
                minCharacters: 2,
                cache: false,
                maxResults: 20
            });
        }
    );
}

function organizeSearchedData(data) {
    var len = data.length;
    var content = new Array(len);
    for (var i = 0; i < len; i++) {
        content[i] = {
            title: data[i].Title,
            description: data[i].FirstName + ' ' + data[i].LastName,
            url: 'single-painting.php?id=' + data[i].PaintingID
        };
    }
    return content;
}