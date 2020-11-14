<template>
    <div>
        <div class="calendar-wrapper">
            <div class="calendar">
                <ul class="pagination pagination-lg weekdays">
                    <li class="page-item"><button class="page-link">D</button></li>
                    <li class="page-item"><button class="page-link">S</button></li>
                    <li class="page-item"><button class="page-link">T</button></li>
                    <li class="page-item"><button class="page-link">Q</button></li>
                    <li class="page-item"><button class="page-link">Q</button></li>
                    <li class="page-item"><button class="page-link">S</button></li>
                    <li class="page-item"><button class="page-link">S</button></li>
                </ul>
                <ul class="pagination pagination-lg" v-for="(week, x) in month" :key="`week-${x}`">
                    <li class="page-item" v-for="(day, y) in week" :key="`day-${y}`">
                        <button class="page-link" :class="{'sunday': day.sunday, 'other-month': day.otherMonth}" v-on:click="() => this.selectDate(day.x, day.y)">{{ day.text }}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Doctor',
    props: [
        'doctor'
    ],
    data() {
        return {
            currentYear: 2020,
            currentMonth: 10
        }
    },
    computed: {
        month() {
            const monthDates = this.getMonth();
            let month = [];
            monthDates.forEach((week, x) => {
                month[x] = [];
                week.forEach((date, y) => {
                    month[x][y] = {
                        text: date.getDate(),
                        sunday: date.getDay() === 0,
                        otherMonth: date.getMonth() !== this.currentMonth,
                        x,
                        y
                    }
                });
            });

            return month;
        }
    },
    methods: {
        getMonth() {
            let month = []; 
            let date = new Date(this.currentYear, this.currentMonth, 1);
            let lastDate = new Date(this.currentYear, this.currentMonth, 1);
            lastDate.setMonth(lastDate.getMonth() + 1);
            lastDate.setDate(lastDate.getDate() - 1);
            date.setDate(date.getDate() - date.getDay());

            for (let x = 0; x < 6; x++) {
                let week = [];
                for (let y = 0; y < 7; y++) {
                    week = [...week, new Date(date.getTime())];
                    date.setDate(date.getDate() + 1);
                }

                month = [...month, week];

                if (date.getMonth() > lastDate.getMonth() || date.getYear() > lastDate.getYear()) {
                    break;
                }
            }

            return month;
        }
    }
};
</script>

<style scoped>
    .calendar-wrapper {
        text-align: center;
    }

    .calendar {
        text-align: left;
        display: inline-block;
    }

    .pagination-lg .page-link {
        padding: 0;
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 0;
        color: #444;
    }

    .pagination-lg {
        margin: 0;
    }

    .weekdays .page-link {
        font-weight: bold;
    }

    .page-link.sunday {
        font-weight: bold;
    }

    .page-link.other-month {
        color: #afadad;
    }
</style>