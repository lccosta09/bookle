<template>
    <div>
        <div class="modal fade show" v-show="isModalOpen">
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
                        <button type="button" class="btn btn-secondary" v-on:click="this.closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-show="isModalOpen" v-on:click="this.closeModal"></div>
    </div>
</template>

<script>
export default {
    name: 'Modal',
    props: ['isOpen'],
    data() {
        return {
            isModalOpen: false
        }
    },
    updated() {
        this.isModalOpen = this.isOpen;
    },
    methods: {
        closeModal() {
            this.isModalOpen = false;
        }
    }
}
</script>

<style scoped>
    .show {
        display: block;
    }
</style>
