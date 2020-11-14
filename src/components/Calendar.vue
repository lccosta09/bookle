<template>
    <div>
        <div class="calendar-wrapper">
            <div class="calendar">
                <div class="btn-toolbar">
                    <button type="button" class="btn btn-secondary prev" v-on:click="() => prevMonth()">&lt;</button>
                    <div class="month">{{ monthName }} {{ currentYear }}</div>
                    <button type="button" class="btn btn-secondary next" v-on:click="() => nextMonth()">&gt;</button>
                </div>
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
                        <button class="page-link" :class="{'sunday': day.sunday, 'other-month': day.otherMonth, 'today': day.today}" v-on:click="() => this.setDate(day.date)">{{ day.text }}</button>
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
        const date = new Date();
        return {
            currentYear: date.getFullYear(),
            currentMonth: date.getMonth(),
            currentDate: {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            }
        }
    },
    computed: {
        monthName() {
            const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            return months[this.currentMonth];
        },
        month() {
            const monthDates = this.getMonth();
            let month = [];
            monthDates.forEach((week, x) => {
                month[x] = [];
                week.forEach((date, y) => {
                    const today = new Date();

                    month[x][y] = {
                        text: date.getDate(),
                        sunday: date.getDay() === 0,
                        otherMonth: date.getMonth() !== this.currentMonth,
                        date: {
                            year: date.getFullYear(),
                            month: date.getMonth(),
                            day: date.getDate()
                        },
                        today: today.getDate() === date.getDate() && today.getMonth() === date.getMonth() && today.getYear() === date.getYear()
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

            do {
                let week = [];
                for (let i = 0; i < 7; i++) {
                    week = [...week, new Date(date.getTime())];
                    date.setDate(date.getDate() + 1);
                }

                month = [...month, week];
            } while (date.getMonth() <= lastDate.getMonth() && date.getYear() <= lastDate.getYear());

            return month;
        },
        setDate(date) {
            this.currentDate = date;
            this.$emit('choose-date', date);
        },
        nextMonth() {
            const date = new Date(this.currentYear, this.currentMonth, 1);
            date.setMonth(date.getMonth() + 1);
            this.currentYear = date.getFullYear();
            this.currentMonth = date.getMonth();
        },
        prevMonth() {
            const date = new Date(this.currentYear, this.currentMonth, 1);
            date.setMonth(date.getMonth() - 1);
            this.currentYear = date.getFullYear();
            this.currentMonth = date.getMonth();
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

    .btn-toolbar {
        margin-bottom: 5px;
        position: relative;
        height: 30px;
    }

    .btn-toolbar .btn {
        position: absolute;
        padding: 0;
        height: 30px;
        width: 30px;
        z-index: 220;
    }

    .btn-toolbar .prev {
        left: 30px;
    }

    .btn-toolbar .next {
        right: 30px;
    }

    .btn-toolbar .month {
        height: 30px;
        line-height: 30px;
        text-align: center;
        width: 100%;
        position: absolute;
        z-index: 200;
        font-weight: bold;
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

    .weekdays .page-link:hover {
        background: none;
    }

    .page-link.sunday {
        font-weight: bold;
    }

    .today {
        font-weight: bold;
        color: red !important;
    }

    .page-link.other-month {
        color: #afadad;
    }
</style>