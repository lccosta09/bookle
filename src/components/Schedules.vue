<template>
    <div>
        <h5>{{ fullDate }}</h5>
        <div v-for="(inteval, index) in schedule" :key="`inteval-${index}`">
            <div>{{ inteval.start }}</div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Schedules',
    props: [
        'date',
        'schedule'
    ],
    computed: {
        fullDate() {
            const date = new Date(this.date.year, this.date.month, this.date.day);
            const weekdays = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
            const months = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

            return `${weekdays[date.getDay()]}, ${date.getDate()} de ${months[date.getMonth()]} de ${date.getFullYear()}`;
        }
    }
};
</script>