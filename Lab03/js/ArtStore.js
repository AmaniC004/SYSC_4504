var currentTotal =0;
for( var i = 0; i<3; i++){
    currentTotal += calculateTotal(quantities[i], prices[i]);
    outputCartRow(filenames[i], titles[i], quantities[i], prices[i], calculateTotal(quantities[i], prices[i]));
}

//Subtotal
document.write('<tr class ="total"><td colspan = "4">Subtotal</td>');
document.write("<td> $"+ currentTotal.toFixed(2) + "</td></tr>");

//Tax
var tax = (0.1*currentTotal);
document.write('<tr class ="total"><td colspan = "4">Tax</td>' );
document.write("<td> $" + tax.toFixed(2) + "</td></tr>");

//Shipping
var shipping = 0;
if (currentTotal < 1000){
    shipping = 40;
}
document.write('<tr class ="total"><td colspan = "4">Shipping</td>');
document.write("<td> $"+ shipping.toFixed(2) + "</td></tr>");

//Grand Total
document.write('<tr class="total focus"><td colspan="4">Grand Total</td>');
document.write("<td> $"+ (currentTotal + tax + shipping).toFixed(2) +"</td></tr>");