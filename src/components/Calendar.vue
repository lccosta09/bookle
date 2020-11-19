<template>
    <div>
        <div class="calendar-wrapper">
            <div class="calendar">
                <div class="btn-toolbar">
                    <button type="button" class="btn btn-secondary prev" v-on:click="() => prevMonth()">&lt;</button>
                    <div class="month">{{ monthName }} {{ date.year }}</div>
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
                    <li class="page-item" v-for="(date, y) in week" :key="`date-${y}`">
                        <button class="page-link" :class="{'sunday': date.sunday, 'other-month': date.otherMonth, 'today': date.today, 'available': date.available}" v-on:click="$emit('choose-date', {'year': date.year, 'month': date.month, 'day': date.day})">{{ date.day }}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Doctor',
    props: {
        'doctor': {},
        'date': {
            default: () => {
                const date = new Date();
                return {
                    year: date.getFullYear(),
                    month: date.getMonth(),
                    day: date.getDate()
                };
            }
        },
        'schedule': {}
    },
    computed: {
        monthName() {
            const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            return months[this.date.month];
        },
        month() {
            const today = new Date();
            let date = new Date(this.date.year, this.date.month, 1);
            let lastDate = new Date(this.date.year, this.date.month, 1);
            lastDate.setMonth(lastDate.getMonth() + 1);
            lastDate.setDate(lastDate.getDate() - 1);
            date.setDate(date.getDate() - date.getDay());
            let month = [];

            do {
                let week = [];
                for (let i = 0; i < 7; i++) {
                    const scheduleDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                    const schedule = this.schedule[scheduleDate.getTime()] ?? [];

                    week = [...week, {
                        year: date.getFullYear(),
                        month: date.getMonth(),
                        day: date.getDate(),
                        sunday: date.getDay() === 0,
                        otherMonth: date.getMonth() !== this.date.month,
                        today: today.getDate() === date.getDate() && today.getMonth() === date.getMonth() && today.getYear() === date.getYear(),
                        available: schedule.length > 0
                    }];

                    date.setDate(date.getDate() + 1);
                }

                month = [...month, week];
            } while (date.getMonth() <= lastDate.getMonth() && date.getYear() <= lastDate.getYear());

            return month;
        }
    },
    methods: {
        nextMonth() {
            this.incrementMonth(1);
        },
        prevMonth() {
            this.incrementMonth(-1);
        },
        incrementMonth(increment) {
            const date = new Date(this.date.year, this.date.month, 1);
            date.setMonth(date.getMonth() + increment);
            this.$emit('set-date', {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            });
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

    .available {
        font-weight: bold;
        color: green !important;
    }

    .page-link.other-month {
        color: #afadad;
    }
</style>