<template>
    <transition name="slide">
        <div
            v-if="data && Object.keys(data).length > 0"
            class="notification"
            :class="data.type"
        >
            <button
                class="delete"
                @click.prevnt="close"
            ></button>
            <span id="alert-message">
            {{ data.message }}
        </span>
        </div>
    </transition>
</template>

<script>
import { EventBus } from "../helpers/event-bus";
export default {
    name: "Alerts",
    data() {
        return {
            data: null
        };
    },
    created() {
        EventBus.$on("alert-add-data", (data) => {
            this.data = data;
            setTimeout(() => {
                this.close();
            }, 5000);
        });
    },
    methods: {
        close() {
            this.data = null;
        }
    }
};
</script>

<style scoped>
.notification {
    margin-bottom: 0;
    border-radius: 0;
    padding: 0;
    height: 70px;
}
.delete {
    top: 1rem;
}
.slide-enter-active {
    -moz-transition-duration: 3s;
    -webkit-transition-duration: 3s;
    -o-transition-duration: 3s;
    transition-duration: 3s;
    -moz-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
}
.slide-leave-active {
    -moz-transition-duration: 3s;
    -webkit-transition-duration: 3s;
    -o-transition-duration: 3s;
    transition-duration: 3s;
    -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}
.slide-enter-to, .slide-leave {
    max-height: 1000px;
    overflow: hidden;
}
.slide-enter, .slide-leave-to {
    overflow: hidden;
    max-height: 0;
}
#alert-message {
    position: absolute;
    top: 27px;
    left: 16px;
}
</style>
