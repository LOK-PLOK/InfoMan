function prepopulateValues(billingData, payment_billing_info_json) {
        console.log(billingData);
        console.log(payment_billing_info_json);

        // Populate hidden billing ID
        document.getElementById('editBillingId').value = billingData.billRefNo;
        document.getElementById('editPaidBillingId').value = billingData.billRefNo;
        document.getElementById('add-payment-button').value = billingData.billRefNo;

        // Populate tenant select dropdown
        document.getElementById('editTenantName').value = billingData.full_name;
        document.getElementById('editPaidTenantName').value = billingData.full_name;

        // Populate other fields
        document.getElementById('editBillTotal').value = billingData.billTotal;
        document.getElementById('editPaidBillTotal').value = billingData.billTotal;
        document.getElementById('editBillDateIssued').value = billingData.billDateIssued;
        document.getElementById('editPaidBillDueDate').value = billingData.billDueDate;
        document.getElementById('editBillDueDate').value = billingData.billDueDate;

        // Populate status dropdown
        document.getElementById('editStatusPayment').value = billingData.isPaid; 


        // add payment section
        document.getElementById('billRefNo').value = billingData.billRefNo;
        document.getElementById('paymentTenantName').value = billingData.full_name;
        document.getElementById('paymentBillDueDate').value = billingData.billDueDate;

        //
        document.getElementById('paymentTenantID').value = billingData.tenID;
        console.log
        

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
}

function prepopulatePayment(billingData, payment_billing_info_json){
    console.log(billingData);
    console.log(payment_billing_info_json);

    document.getElementById('paymentTenantName').value = billingData.full_name;
    document.getElementById('paymentBillDueDate').value = billingData.billDueDate;
    document.getElementById('paymentAmount').value = billingData.billTotal;
    document.getElementById('paymentTenantID').value = billingData.tenID;
    document.getElementById('billRefNo').value = billingData.billRefNo;
    console.log(document.getElementById('billRefNo').value);
    console.log(document.getElementById('paymentTenantID'));
}
