<template>
    <div>
        <div class="row">
            <div v-for="doctor in this.$store.state.doctor.doctors" :key="doctor.id" class="col-lg-4">
                <div class="bs-component">
                    <div class="card border-primary mb-3 doctor">
                        <div class="card-body">
                            <h4 class="card-title" v-text="doctor.name"></h4>
                            <p class="card-text" v-text="doctor.description"></p>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse">
                            <button type="button" class="btn btn-primary" v-on:click="this.openDoctorsModal">Ver agenda</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal show" v-show="isDoctorsModalOpened">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Doctors',
    data() {
        return {
            isDoctorsModalOpened: false
        }
    },
    methods: {
        openDoctorsModal() {
            this.isDoctorsModalOpened = true;
        },
        closeDoctorsModal() {
            this.isDoctorsModalOpened = false;
        }
    }
}
</script>

<style scoped>
    .doctor {
        min-height: 200px;
    }

    .show {
        display: block;
    }

    .hide {
        display: none;
    }
</style>
