<template>
    <div>
        <p>{{ doctor.description }}</p>
        <div class="calendar-wrapper">
            <div class="calendar">
                <ul class="pagination pagination-lg">
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
                        <button class="page-link">{{ day.text }}</button>
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
            currentMonth: 11,
            month: []
        }
    },
    mounted() {
        let date = new Date(this.currentYear, this.currentMonth, 1);
        let lastDate = new Date(this.currentYear, this.currentMonth, 1);
        lastDate.setMonth(lastDate.getMonth() + 1);
        lastDate.setDate(lastDate.getDate() - 1);
        date.setDate(date.getDate() - date.getDay());
        this.month = [];

        for (let i = 0; i < 6; i++) {
            let week = [];
            for (let j = 0; j < 7; j++) {
                week = [...week, {
                    text: date.getDate()
                }];

                date.setDate(date.getDate() + 1);
            }

            this.month = [...this.month, week];

            if (date.getMonth() > lastDate.getMonth() || date.getYear() > lastDate.getYear()) {
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
