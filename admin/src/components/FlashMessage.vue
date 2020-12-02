<template>
    <div v-if="isVisible" class="alert alert-dismissible" :class="`alert-${type}`">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'FlashMessage',
    props: {
        'type': {
            default: () => {
                return 'danger';
            }
        },
        'visible': {
            default: () => {
                return false;
            }
        },
        'timeout': {
            default: () => {
                return 3000;
            }
        }
    },
    data() {
        return {
            isVisible: Boolean(this.visible)
        }
    },
    watch: {
        visible: {
            immediate: true,
            handler(newValue, oldValue) {
                if (newValue !== oldValue && newValue) {
                    setTimeout(() => this.isVisible = false, this.timeout);
                }
            }
        }
    }
};
</script>

<style scoped>
</style>