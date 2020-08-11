<template>
<div class="column is-8 is-offset-2 register">
    <div class="columns">
        <div class="column has-text-centered">
            <div class="field">
                <label class="label">Password</label>
                <div class="control">
                    <input
                        class="input is-medium"
                        type="password"
                        name="password"
                        v-model="password"
                        v-validate="'required|verify_password'"
                    >
                </div>
                <p
                    v-if="errors.has('password')"
                    class="help is-danger"
                >
                    {{ errors.first('password') }}
                </p>
            </div>
            <div class="field">
                <label class="label">{{ Object.keys($props.questions)[0] }}</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="question one" v-model="question_one" v-validate="'required'">
                            <option disabled> -- Select -- </option>
                            <option v-for="(answer, key) in $props.questions[Object.keys($props.questions)[0]]" :value="key">{{ answer }}</option>
                        </select>
                    </div>
                </div>
                <p
                    v-if="errors.has('question one')"
                    class="help is-danger"
                >
                    {{ errors.first('question one') }}
                </p>
            </div>
            <div class="field">
                <label class="label">{{ Object.keys($props.questions)[1] }}</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="question two" v-model="question_two" v-validate="'required'" :disabled="questionTwoOptions.length === 0">
                            <option disabled> -- Select -- </option>
                            <option v-for="(answer, key) in questionTwoOptions" :value="key">{{ answer }}</option>
                        </select>
                    </div>
                </div>
                <p
                    v-if="errors.has('question two')"
                    class="help is-danger"
                >
                    {{ errors.first('question two') }}
                </p>
            </div>

            <button class="button is-block is-primary is-fullwidth is-medium" @click.prevent="login">Invite</button>
            <br />
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Register",
    props: {
        questions: {
            default: () => ({}),
            type: Object
        },
        token: {
            type: String
        }
    },
    data() {
        return {
            password: null,
            question_one: null,
            question_two: null
        }
    },
    computed: {
        questionTwoOptions() {
            if (this.question_one !== null) {
                const key = this.$props.questions[Object.keys(this.$props.questions)[0]][this.question_one];

                return Object.keys(this.$props.questions[Object.keys(this.$props.questions)[1]][key]);
            }

            return [];
        }
    },
    methods: {
        async login() {
            const {
                password,
                question_one,
                question_two
            } = this.$data;

            try {
                const response = await axios.post('/api/register', {
                    user: this.$props.token,
                    password,
                    questions: [
                        [question_one],
                        [question_two]
                    ]
                });

                const data = response.data.data;
                if (data) {
                    window.location = data.route;
                }
            } catch (e) {
                this.$root.showAlert("is-danger", e.response.data.message);
            }
        }
    }
}
</script>
