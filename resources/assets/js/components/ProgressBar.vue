<template>
    <div id="ns-progress" v-mdl v-if="active" class="ns-progress ns-full-width mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
</template>

<script>

    export default {
        name: 'progress-bar',

        data() {
            return {
                active: false
            }
        },

        mounted: function () {
            Event.listen('progress-bar--show', active => {
                this.active = active;
            })
        },

        methods: {

            show() {
                this.active = true;
            },

            hide() {
                this.active = false;
            },
        }
    }
</script>

<style>
    .ns-progress {
        position: absolute;
        top: 0;
    }

    .ns-full-width {
        width: 100%;
    }
</style>