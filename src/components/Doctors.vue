<template>
    <div class="row">
        <div v-for="doctor in this.$store.state.doctor.doctors" :key="doctor.id" class="col-lg-4">
            <div class="bs-component">
                <div class="card border-primary mb-3 doctor">
                    <div class="card-body">
                        <h4 class="card-title" v-text="doctor.name"></h4>
                        <p class="card-text" v-text="doctor.description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Doctors'
}
</script>

<style scoped>
    .doctor {
        min-height: 200px;
    }
</style>
