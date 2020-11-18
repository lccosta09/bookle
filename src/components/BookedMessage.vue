<template>
    <div>
        <h5 class="message">Sua consulta foi agendada com sucesso!</h5>
    </div>
</template>

<script>

export default {
    name: 'BookedMessage',
    props: [
        'date',
        'doctor',
        'interval'
    ]
};
</script>

<style scoped>
    .message {
        text-align: center;
        font-weight: normal;
        font-size: 1.015625rem;
    }
</style>