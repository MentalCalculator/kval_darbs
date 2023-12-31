// Funkcija

const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
})

// Sveramais ievades rediģēšana.

function changeStep(stepValue) {
    document.getElementById("Amount").step = stepValue;
}
function preventDecimal(event) {
    var sveramaistype = document.querySelector('input[name="producttype"]:checked').value;
    if (sveramaistype === "Amount") {
        event.target.value = event.target.value.replace(".", "");
    }
}

//
const productFields = document.getElementById('product-fields');
const addProductBtn = document.getElementById('add-product-btn');
const productFieldTemplate = document.querySelector('.product-field');

addProductBtn.addEventListener('click', () => {
    const newProductField = productFieldTemplate.cloneNode(true);
    productFields.appendChild(newProductField);
});

$(document).ready(function() {
    var productsTable = $('#products-table tbody');

    $('#add-product-btn').click(function() {
        var newRow = $('<tr>');

        // Add inputs for product name, price, type, and amount/weight
        newRow.append($('<td>').append($('<input>').attr('type', 'text').attr('name', 'productname[]').attr('required', true)));
        newRow.append($('<td>').append($('<input>').attr('type', 'number').attr('name', 'productprice[]').attr('step', '0.01').attr('required', true)));
        newRow.append($('<td>').append($('<select>').attr('name', 'producttype[]').append($('<option>').attr('value', 'amount').text('Amount')).append($('<option>').attr('value', 'weight').text('Weight')).attr('required', true).on('change', function() {
            var selectedOption = $(this).val();
            var inputAmount = $(this).closest('tr').find('input[name="productamount[]"]');
            if (selectedOption === 'amount') {
                inputAmount.prop('step', '1');
            } else if (selectedOption === 'weight') {
                inputAmount.prop('step', '0.001');
            }
        })));
        newRow.append($('<td>').append($('<input>').attr('type', 'number').attr('name', 'productamount[]')));
        newRow.append($('<td>').append($('<button>').attr('type', 'button').addClass('btn btn-danger remove-product-btn').text('-')));

        productsTable.append(newRow);
    });

    productsTable.on('click', '.remove-product-btn', function() {
        $(this).closest('tr').remove();
    });
});







