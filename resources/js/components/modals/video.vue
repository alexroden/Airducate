<template>
    <div class="modal">
        <div class="modal-background" @click.prevent="closeModal"></div>
        <div class="modal-card">
            <div class="modal-content">
                <video-player
                    class="video-player-box"
                   ref="videoPlayer"
                   :options="playerOptions"
                   :playsinline="true"
                ></video-player>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close" @click.prevent="closeModal"></button>
    </div>
</template>

<script>
import "video.js/dist/video-js.css";
import { videoPlayer } from "vue-video-player";

export default {
    name: "Video-Modal",
    props: {
        assignment: {
            default: () => ({}),
            type: Object
        },
        user: {
            default: () => ({}),
            type: Object
        }
    },
    data() {
        return {
            grade: null,
            playerOptions: {
                starttime: 330,
                muted: false,
                language: 'en',
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                sources: [{
                    type: "video/mp4",
                    src: null
                }],
            }
        }
    },
    computed: {
        player() {
            return this.$refs.videoPlayer.player
        }
    },
    created() {
        this.getGrade();
    },
    mounted() {
        this.$nextTick(() => {
            this.playerOptions.sources[0].src = this.$props.assignment.source;

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
        async closeModal() {
            let seconds = 0;
            let minutes = 0;
            for (let t = 0; t <= this.player.currentTime(); t++) {
                seconds++;
                if (seconds === 60) {
                    minutes++;
                    seconds = 0;
                }
            }

            try {
                await window.axios
                    .post(`/api/assignments/${this.$props.assignment.token}`, {
                        progress: parseFloat(minutes + "." + seconds) / this.assignment.length,
                    });

                this.$parent.closeModal();
            } catch (e) {
                //
            }
        },
        async getGrade() {
            try {
                const response = await window.axios
                    .get(`/api/assignments/${this.$props.assignment.token}`);

                const data = response.data.data;
                if (data) {
                    this.grade = data[0];
                    if (this.grade.progress !== null) {
                        this.player.currentTime((this.assignment.length * this.grade.progress) * 60);
                    }
                }
            } catch (e) {
                //
            }
        }
    },
    components: {
        videoPlayer
    }
};
</script>

<style>
.video-js {
    width: 100%;
}
</style>
