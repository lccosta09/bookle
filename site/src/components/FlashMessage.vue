<template>
    <div v-if="visible" class="alert alert-dismissible" :class="`alert-${type}`">
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
    watch: {
        visible: {
            immediate: true,
            handler(newValue, oldValue) {
                if (newValue !== oldValue && newValue) {
                    setTimeout(() => this.$emit('close'), this.timeout);
                }
            }
        }
    }
};
</script>

<style scoped>
</style>