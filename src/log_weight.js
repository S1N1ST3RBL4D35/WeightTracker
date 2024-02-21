document.addEventListener('DOMContentLoaded', function() {
    new Vue({
        el: 'body',
        data: {
            showForm: true,
            showTreands: false,
            isFirstLog: true,
            isLoss: false,
            isGain: false,
            logDate: '',
            weight: '',
            unit: 'lbs',   //default to Lbs
            today: new Date().toISOString().split('T')[0],   //Get today's date here
            logs: [],
            message: '',
            trends: {
                initialWeight: 0,
                totalLossGain: 0,
                lossSinceLast: 0,
            }
        },
        methods: {
            submitLog() {
                if(!this.logDate || !this.weight) {
                    //Cannot be empty
                    alert('Please fill in both Date and Weight fields.');
                    return;
                }

                const newLog = {
                    date: this.logDate,
                    weight: parseFloat(this.weight),
                    unit: this.unit
                };

                if(this.logs.length === 0) {
                    //first log entry?
                    this.isFirstLog = true;
                    this.message = 'Congrats on your first entry!';
                    this.showForm = false;
                } else {
                    const previousLog = this.logs[this.logs.length - 1];

                    //Check if log is less than previous entry
                    if(newLog.weight < previousLog.weight) {
                        this.isLoss = true;
                        this.message = 'Great job! Keep up the great work';
                    } else if (newLog.weight > previousLog.weight) {
                        //new log is > than previous, provide encouragement
                        this.isGain = true;
                        this.message = 'Don\'t get discouraged! You can do it';
                    }

                    this.showForm = false;
                }

                this.logs.push(newLog);  //push logs into array
            },
            showTrends() {
                if(this.logs.length === 0) {
                    alert('No logs available. Please log your weight first');
                    return;
                }

                //Calculate your trends
                this.trends.initialWeight = this.logs[0].weight; //based on first entry
                this.trends.totalLossGain = (this.logs[this.logs.length - 1].weight - this.trends.initialWeight).toFixed(1);
                this.trends.lossSinceLast = (this.logs[this.logs.length - 1].weight - this.logs[this.logs.length - 2].weight).toFixed(1);

                this.showTrends = true;
            },
        },
        mounted() {
            this.today = this.getTodayDayDate();
        }
    });
});