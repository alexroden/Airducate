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
            <table class="table is-fullwidth">
                <tbody>
                <tr>
                    <td class="px-3 py-3"><strong>Filter:</strong></td>
                    <td>
                        <div class="select">
                            <select v-model="type">
                                <option disabled> -- Select -- </option>
                                <option value="categories">Category</option>
                                <option value="types">Type</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <multi-select
                            v-model="filtering"
                            :options="options"
                            placeholder="Filter by category and type"
                            label="name"
                            track-by="name"
                        ></multi-select>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="tile is-ancestor has-text-centered" v-for="assignment in list">
                <div class="tile is-parent">
                    <article class="tile is-child box" :style="tileStyles(assignment)" @click.prevent="$root.openModal(assignment.modal, {
                        assignment,
                        user: $props.user
                    })">
                        <p class="subtitle"><i class="fas fa-check" v-if="$root.hasCompleted(assignment.id)"></i><span class="sub-bg" v-if="assignment.cover_image !== null">{{ assignment.name }}</span><span v-else>{{ assignment.name }}</span></p>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Breadcrumbs from "./breadcumbs";
import MultiSelect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
    name: "User-Modules",
    props: {
        module: {
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
            assignments: [],
            crumbs: [
                {
                    name: 'Dashboard',
                    url: `/`
                }, {
                    name: 'Modules',
                    url: `/${window.user_token}/modules`
                }
            ],
            filtering: null,
            filters: [],
            type: null
        }
    },
    computed: {
        options() {
            if (
                Object.keys(this.filters).length > 0
                && this.type !== null
            ) {
                return this.filters[this.type];
            }

            return [];
        },
        list() {
            let assignments = this.assignments;

            if (assignments.length === 0) {
                return [];
            }

            if (this.filtering !== null && Object.keys(this.filtering).length > 0 && this.type !== null) {
                assignments = assignments.filter((val) => {
                    return val[this.type].filter((v) => v.name === this.filtering.name).length > 0
                })
            }

            return assignments;
        }
    },
    created() {
        this.getUserModules();
        this.getFilters();
    },
    mounted() {
        this.crumbs.push({
            name: this.$props.module.name,
            url: `/modules/${this.$props.module.token}`
        });
    },
    methods: {
        async getFilters() {
            try {
                const response = await window.axios
                    .get("/api/filters");

                const data = response.data.data;
                if (data) {
                    this.filters = data;
                }
            } catch (e) {
                //
            }
        },
        async getUserModules() {
            try {
                const response = await window.axios
                    .get(`/api/modules/${this.$props.module.token}/assignments`);

                const data = response.data.data;
                if (data) {
                    this.assignments = data;
                }
            } catch (e) {
                //
            }
        },
        tileStyles(assignment) {
            const style = {};
            if (assignment.cover_image) {
                style['background'] = `url('${assignment.cover_image}')`;
            }

            return style;
        }
    },
    components: {
        Breadcrumbs,
        MultiSelect
    },
    watch: {
        type(val) {
            this.filtering = null;
        }
    }
}
</script>
