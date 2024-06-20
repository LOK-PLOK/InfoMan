document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('start-date').addEventListener('change', function() {
        const startDate = new Date(this.value);
        
        if (!isNaN(startDate.getTime())) {
            const endDate = new Date(startDate);
            endDate.setDate(endDate.getDate() + 30);
            
            const endDateString = endDate.toISOString().split('T')[0];
            document.getElementById('end-date').value = endDateString;
        } else {
            console.log('Invalid start date');
        }
    });
});
