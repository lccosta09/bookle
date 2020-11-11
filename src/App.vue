<template>
    <div>
        <NavBar />
        <div class="container">
            <router-view v-on:open-modal="openModal" />
        </div>
        <Modal :isOpen="isModalOpen" v-on:close-modal="closeModal" />
    </div>
</template>

<script>
import NavBar from './components/NavBar.vue';
import Modal from './components/Modal.vue';

export default {
    name: 'App',
    components: {
        NavBar,
        Modal
    },
    data() {
        return {
            isModalOpen: false
        }
    },
    methods: {
        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        }
    }

}
</script>

<style>
</style>