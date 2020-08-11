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
            <div class="tile is-ancestor has-text-centered" v-for="module in list">
                <div class="tile is-parent">
                    <article class="tile is-child box" style="cursor: pointer;" @click.prevent="redirect(module.route)">
                        <p class="subtitle">{{ module.name }}</p>
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
                }, {
                    name: 'Modules',
                    url: `/${window.user_token}/modules`
                }
            ],
            filtering: null,
            filters: [],
            modules: [],
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
            let modules = this.modules;

            if (modules.length === 0) {
                return [];
            }

            if (this.filtering !== null && Object.keys(this.filtering).length > 0 && this.type !== null) {
                modules = modules.filter((val) => {
                    return val[this.type].filter((v) => v.name === this.filtering.name).length > 0
                })
            }

            return modules;
        }
    },
    created() {
        this.getUserModules();
        this.getFilters();
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
                    .get("/api/modules");

                const data = response.data.data;
                if (data) {
                    this.modules = data;
                }
            } catch (e) {
                //
            }
        },
        redirect(route) {
            window.location = route;
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
