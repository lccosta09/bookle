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
                            <button type="button" class="btn btn-primary" v-on:click="() => this.openModal(doctor)">Ver agenda</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :title="doctor.name" :isOpen="isModalOpen" v-on:close="onCloseModal">
            <Doctor
                :doctor="doctor"
                :page="modalPage"
                :date="date"
                v-on:set-page="onSetModalPage"
                v-on:set-date="onSetDate" />
        </Modal>
    </div>
</template>

<script>
import Modal from './Modal.vue';
import Doctor from './Doctor.vue';

export default {
    name: 'Doctors',
    components: {
        Modal,
        Doctor
    },
    data() {
        const date = new Date();

        return {
            isModalOpen: false,
            doctor: {
                name: '',
            },
            modalPage: 'calendar',
            date: {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            }
        }
    },
    methods: {
        openModal(doctor) {
            this.isModalOpen = true;
            this.doctor = doctor;
        },
        onCloseModal() {
            const date = new Date();

            this.isModalOpen = false;
            this.modalPage = 'calendar';
            this.date = {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            };
        },
        onSetModalPage(page) {
            this.modalPage = page;
        },
        onSetDate(date) {
            this.date = date;
        }
    }
};
</script>

<style scoped>
    .doctor {
        min-height: 200px;
    }

    .show {
        display: block;
    }
</style>
