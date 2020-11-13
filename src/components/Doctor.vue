<template>
    <div>
        <p>{{ doctor.description }}</p>
        <div class="calendar-wrapper">
            <div class="calendar">
                <ul class="pagination pagination-lg" v-for="(week, x) in month" :key="`week-${x}`">
                    <li class="page-item" v-for="(day, y) in week" :key="`day-${y}`">
                        <button class="page-link">{{ day }}</button>
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
            currentYear: 2021,
            currentMonth: 0,
            month: [
                [1, 2, 3, 4, 5, 6, 7],
                [8, 9, 10, 11, 12, 13, 14],
                [15, 16, 17, 18, 19, 20, 21],
                [22, 23, 24, 25, 26, 27, 28],
                [29, 30, 31]
            ]
        }
    },
    mounted() {
        const firstDay = new Date(this.currentYear, this.currentMonth, 1);
        let lastDay = new Date(this.currentYear, this.currentMonth, 1);
        lastDay.setMonth(lastDay.getMonth() + 1);
        lastDay.setDate(lastDay.getDate() - 1);
        const dayOfWeek = firstDay.getDay();
        this.month = [];

        let day = 1;
        for (let i = 0; i < 6; i++) {
            let week = [];
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < dayOfWeek) {
                    week = [...week, ''];
                    continue;
                }

                if (day > lastDay.getDate()) {
                    week = [...week, ''];
                    continue;
                }

                week = [...week, day];
                day++;
            }

            this.month = [...this.month, week];

            if (day > lastDay.getDate()) {
                break;
            }
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
    }

    .pagination-lg {
        margin: 0;
    }
</style>
