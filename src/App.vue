<template>
    <div>
        <NavBar />
        <div class="container">
            <router-view v-on:open-modal="openModal" />
        </div>
        <Modal :isOpen="isModalOpen" />
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
        }
    }

}
</script>

<style>
</style>