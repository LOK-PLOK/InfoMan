
function prepopulateValues(payment_billing_info_json, billingId, tenantId, billTotal, billDateIssued, billDueDate, isPaid) {
    // Populate hidden billing ID
    document.getElementById('editBillingId').value = billingId;
    document.getElementById('editPaidBillingId').value = billingId;

    // Populate tenant select dropdown
    document.getElementById('editTenantName').value = tenantId;
    document.getElementById('editPaidTenantName').value = tenantId;

    // Populate other fields
    document.getElementById('editBillTotal').value = billTotal;
    document.getElementById('editPaidBillTotal').value = billTotal;
    document.getElementById('editBillDateIssued').value = billDateIssued;
    document.getElementById('editPaidBillDueDate').value = billDateIssued;
    document.getElementById('editBillDueDate').value = billDueDate;

    // Populate status dropdown
    document.getElementById('editStatusPayment').value = isPaid; 

    if(payment_billing_info_json){
        // document.getElementById('').value = 
        // console.log(payment_billing_info_json);
        var paymentInfo = JSON.parse(payment_billing_info_json);
        document.getElementById('edit-datePaid').value = paymentInfo[0].payDate; 
        document.getElementById('edit-payer-fname').value = paymentInfo[0].payerFname
        document.getElementById('edit-payer-MI').value = paymentInfo[0].payerMI; 
        document.getElementById('edit-payer-lname').value = paymentInfo[0].payerLname; 
        document.getElementById('edit-payMethod').value = paymentInfo[0].payMethod;

    }
    console.log(document.getElementById('editBillingId').value);

    // console.log('Values prepopulated successfully!');
    // console.log('Billing ID:', billingId);
    // console.log('Tenant ID:', tenantId);
    // console.log('Bill Total:', billTotal);
    // console.log('Bill Date Issued:', billDateIssued);
    // console.log('Bill Due Date:', billDueDate);
    // console.log('Is Paid:', isPaid);
}
