document.addEventListener('DOMContentLoaded', function () {
    new Vue({
        el: '#app',
        data: {
            logDate: '',
            weight: '',
            unit: 'lbs',  // default to lbs
            logs: [],
        },
        methods: {
            submitLog() {
                // Form Validation
                if (!this.logDate || !this.weight || !this.unit) {
                    alert('Please fill in all fields.');
                    return;
                }

                // Additional validation
                if (isNaN(parseFloat(this.weight)) || parseFloat(this.weight) <= 0) {
                    alert('Please enter a valid weight.');
                    return;
                }

                // Submit log and display it
                this.logs.unshift({
                    date: this.logDate,
                    weight: parseFloat(this.weight),
                    unit: this.unit,
                });

                // Clear form fields
                this.logDate = '';
                this.weight = '';
                this.unit = 'lbs'; // Reset unit to default
            }
        },
    });
});
