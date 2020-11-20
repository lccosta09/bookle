<template>
    <div>
        <h5 class="message">Sua consulta foi agendada com sucesso!</h5>
        <fieldset class="information">
            <div class="form-group row">
                <label for="date" class="col-sm-2 col-form-label">Data</label>
                <div class="col-sm-10">
                    <div class="form-control-plaintext" id="date">{{ fullDate }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="interval" class="col-sm-2 col-form-label">Horário</label>
                <div class="col-sm-10">
                    <div class="form-control-plaintext" id="interval">{{ interval.start }}h as {{ interval.end }}h</div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>

export default {
    name: 'BookedMessage',
    props: [
        'date',
        'doctor',
        'interval'
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
    .information {
        background: #f8f8f8;
        min-width: 370px;
        max-width: 370px;
        padding: 10px;
        margin: 0 auto;
    }

    .row {
        margin: 0;
    }

    .message {
        text-align: center;
        font-weight: normal;
        font-size: 1.015625rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .form-group {
        padding: 3px;
        margin-bottom: 0
    }

    .form-group .col-form-label {
        font-size: 0.95rem;
        font-weight: bold;
        padding: 0;
    }

    .form-group .form-control-plaintext {
        font-size: 0.95rem;
        padding: 0;
    }
</style>