<template>
<div class="column is-8 is-offset-2">
    <div class="columns mt-5">
        <div class="column">
            <breadcrumbs
                :crumbs="crumbs"
            ></breadcrumbs>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="tile is-ancestor has-text-centered" v-if="$root.hasPermission('invite users')">
                <div class="tile is-parent">
                    <article class="tile is-child box" style="cursor: pointer;" @click.prevent="redirectInvite">
                        <p class="title"><i class="fas fa-3x fa-users"></i></p>
                        <p class="subtitle">Invite Users</p>
                    </article>
                </div>
            </div>
            <div class="tile is-ancestor has-text-centered">
                <div class="tile is-parent">
                    <article class="tile is-child box" style="cursor: pointer;" @click.prevent="redirectModules">
                        <p class="title"><i class="fas fa-3x fa-chalkboard"></i></p>
                        <p class="subtitle">Modules</p>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Breadcrumbs from "./breadcumbs";

export default {
    name: "User-Dashboard",
    props: {
        user: {
            default: () => ({}),
            type: Object
        }
    },
    data() {
        return {
            crumbs: [
                {
                    name: 'Dashboard',
                    url: `/`
                }
            ],
        }
    },
    methods: {
        redirectInvite() {
            window.location = 'invite';
        },
        redirectModules() {
            window.location = `/${this.$props.user.token}/modules`;
        }
    },
    components: {
        Breadcrumbs
    }
}
</script>
