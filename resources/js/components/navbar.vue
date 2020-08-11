<template>
    <div>
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <a :href="`/${$props.user.token}`"  class="navbar-item">
                        <p class="logo">Airducate ✈️</p>
                    </a>
                    <span class="navbar-burger burger" @click="toggleNav" :class="{ 'is-active': showNav }">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                </div>
                <div class="navbar-menu" id="website-mobile-nav-menu">
                    <div class="navbar-end">
                        <a v-if="Object.keys($props.user).length > 0" :href="`/${$props.user.token}`" @click="showNav = false" class="navbar-item">
                            {{ $props.user.first_name }}'s Dashboard
                        </a>
                        <a v-if="Object.keys($props.user).length > 0" href="/logout" @click="showNav = false" class="navbar-item">
                            Logout
                        </a>
                        <a v-if="Object.keys($props.user).length === 0" href="/login" @click="showNav = false" class="navbar-item">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="nav-background" @click="toggleNav"></div>
    </div>
</template>

<script>
export default {
    name: "Navbar",
    props: {
        user: {
            default: () => ({}),
            type: Object
        }
    },
    data() {
        return {
            showNav: false
        }
    },
    methods: {
        toggleNav() {
            if (this.showNav) {
                $("#website-mobile-nav-menu").slideUp(1000, "linear");
                setTimeout(() => {
                    const navBackground = $(".nav-background");
                    navBackground.css("opacity", 1)
                        .animate(
                            { opacity: 0 },
                            { queue: false, duration: 500 }
                        );
                    $("html").removeClass("is-clipped max-height");
                    setTimeout(() => {
                        navBackground.css("display", "none");
                    }, 750);
                }, 500);
            } else {
                $(".nav-background").css("display", "block")
                    .css("opacity", 0)
                    .animate(
                        { opacity: 1 },
                        { queue: false, duration: 500 }
                    );
                setTimeout(() => {
                    $("html").addClass("is-clipped max-height");
                    $("#website-mobile-nav-menu").slideDown(1000, "linear");
                }, 250);
            }
            this.showNav = !this.showNav;
        }
    }
};
</script>
