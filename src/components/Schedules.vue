<template>
    <div>
        <div class="back" v-on:click="$emit('previous-page')">
            <span class="icon">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
            </span>Voltar
        </div>
        <h5 class="date">{{ fullDate }}</h5>
        <div class="intervals">
            <div class="interval" v-for="(inteval, index) in schedule" :key="`inteval-${index}`">
                <div class="label">{{ inteval.start }} - {{ inteval.end }}</div>
                <div class="select">
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="$emit('book', inteval)">Agendar</button>
                </div>
            </div>
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

<style scoped>
    .date {
        text-align: center;
        font-weight: normal;
        font-size: 1.015625rem;
    }

    .intervals {
        max-width: 380px;
        min-width: 380px;
        margin: 0 auto;
    }

    .intervals .interval {
        height: 2.3rem;
        line-height: 2.3rem;
        padding: 7px 0;
        position: relative;
    }

    .intervals .interval .label {
        left: 0;
        position: absolute;
        font-weight: bold;
        font-size: 1.015625rem;
    }

    .intervals .interval .select {
        right: 0;
        position: absolute;
    }

    .back {
        height: 1.5rem;
        line-height: 1.5rem;
        cursor: pointer;
        margin-bottom: 15px;
        display: inline-block;
    }
</style>