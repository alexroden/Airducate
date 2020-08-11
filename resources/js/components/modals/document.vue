<template>
    <div class="modal">
        <div class="modal-background" @click.prevent="closeModal"></div>
        <div class="modal-card">
            <div class="modal-content">
                <pdf :src="assignment.source"></pdf>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close" @click.prevent="closeModal"></button>
    </div>
</template>

<script>
import pdf from "vue-pdf";

export default {
    name: "Document-Modal",
    props: {
        assignment: {
            default: () => ({}),
            type: Object
        }
    },
    mounted() {
        this.$nextTick(() => {
            $(".modal-background").css("opacity", 0)
                .animate(
                    { opacity: 1 },
                    { queue: false, duration: 500 }
                );
            $("html").addClass("is-clipped");
            setTimeout(() => {
                $(".modal-card").css("opacity", 0)
                    .animate(
                        { opacity: 1 },
                        { queue: false, duration: 125 }
                    ).addClass("open");
            }, 125);
        });
    },
    methods: {
        closeModal() {
            try {
                window.axios
                    .post(`/api/assignments/${this.$props.assignment.token}`, {
                        progress: 1,
                    });

                this.$parent.closeModal();
            } catch (e) {
                //
            }
        }
    },
    components: {
        pdf
    }
};
</script>

<style scoped>
    .doc {
        width: 100%;
        height: 500px;
    }
</style>
