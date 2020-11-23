<template>
    <div>
        <div class="modal-dialog" show v-show="isOpen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-text="title"></h5>
                    <button type="button" class="close" v-on:click="$emit('close')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <Loading :loading="loadind" />
                    <slot v-if="!loadind"></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="$emit('close')">Fechar</button>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-show="isOpen" v-on:click="$emit('close')"></div>
    </div>
</template>

<script>
import Loading from './Loading.vue';

export default {
    name: 'Modal',
    props: [
        'title',
        'loadind',
        'isOpen'
    ],
    components: {
        Loading
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
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 90%;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            width: 500px;
            max-width: 500px;
        }
    }

    @media (min-width: 768px) {
        .modal-dialog {
            width: 650px;
            max-width: 650px;
        }
    }

    @media (min-width: 992px) {
        .modal-dialog {
            width: 800px;
            max-width: 800px;
        }
    }
</style>
