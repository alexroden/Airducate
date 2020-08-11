<template>
    <div v-if="$root.modal !== null">
        <component :is="$root.modal" v-bind="props"></component>
    </div>
</template>

<script>
import documentModal from "./modals/document";
import { EventBus } from "../helpers/event-bus.js";
import videoModal from "./modals/video";

export default {
    name: "Modal",
    data() {
        return {
            data: null
        };
    },
    computed: {
        props() {
            const props = {};
            if (this.data) {
                const keys = Object.keys(this.data);
                for (let i = 0; i < keys.length; i++) {
                    props[keys[i]] = this.data[keys[i]];
                }
            }
            return props;
        }
    },
    created() {
        EventBus.$on("modal-add-data", (data) => {
            this.data = data;
        });
    },
    methods: {
        closeModal() {
            $(".modal-card").css("opacity", 1)
                .animate(
                    { opacity: 0.8 },
                    { queue: false, duration: 125 }
                ).removeClass("open")
                .css("opacity", 0.8)
                .animate(
                    { opacity: 0 },
                    { queue: false, duration: 125 }
                );
            setTimeout(() => {
                $(".modal-background").css("opacity", 1)
                    .animate(
                        { opacity: 0 },
                        { queue: false, duration: 100 }
                    );
                $("html").removeClass("is-clipped");
                setTimeout(() => {
                    this.$root.modal = null;
                }, 100);
            }, 400);
        }
    },
    components: {
        documentModal,
        videoModal
    }
};
</script>
