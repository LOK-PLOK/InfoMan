const amountCalculator = () => {
    const payOccType = document.getElementById('payment-occupancyType');
    const noOfAppliances = document.getElementById('noOfAppliances');
    const applianceRate = document.getElementById('applianceRate');
    const totalAmountPayment = document.getElementById('dummy-create-billing-billTotal');
    const actualAmountPayment = document.getElementById('create-billing-billTotal');


    const payOccTypeValue = parseInt(payOccType.value, 10);
    const noOfAppliancesValue = parseInt(noOfAppliances.value, 10);
    
    console.log(payOccTypeValue);
    console.log(noOfAppliancesValue);
    
    totalAmountPayment.value = payOccTypeValue + noOfAppliancesValue * 100;
    actualAmountPayment.value = payOccTypeValue + noOfAppliancesValue * 100;
};

// shittiest solution ever but idgaf
const amountCalculatorEdit = () => {
    const payOccType = document.getElementById('payment-occupancyType');
    const noOfAppliances = document.getElementById('noOfAppliances');
    const applianceRate = document.getElementById('applianceRate');
    const totalAmountPayment = document.getElementById('dummy-create-billing-billTotal');
    const actualAmountPayment = document.getElementById('create-billing-billTotal');


    const payOccTypeValue = parseInt(payOccType.value, 10);
    const noOfAppliancesValue = parseInt(noOfAppliances.value, 10);
    
    console.log(payOccTypeValue);
    console.log(noOfAppliancesValue);
    
    totalAmountPayment.value = payOccTypeValue + noOfAppliancesValue * 100;
    actualAmountPayment.value = payOccTypeValue + noOfAppliancesValue * 100;
};

amountCalculator();
