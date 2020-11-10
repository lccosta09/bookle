<template>
    <div class="row">
        <div v-for="doctor in this.$store.state.doctor.doctors" :key="doctor.id" class="col-lg-4">
            <div class="bs-component">
                <div class="card border-primary mb-3">
                    <div class="card-header" v-text="doctor.name"></div>
                    <div class="card-body">
                        <h4 class="card-title">Primary card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
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
</style>
