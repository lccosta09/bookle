<template>
    <div>
        <div class="modal-dialog" show v-show="isModalOpen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" v-on:click="$emit('close-modal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="$emit('close-modal')">Close</button>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-show="isModalOpen" v-on:click="$emit('close-modal')"></div>
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
    }
}
</script>

<style scoped>
    .show {
        display: block;
    }

    .modal-backdrop {
        position: absolute;
        z-index: 2000;
    }

    .modal-dialog {
        position: absolute;
        z-index: 2001;
        top: 0;
        left: 0;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            width: 500px;
        }
    }
</style>
