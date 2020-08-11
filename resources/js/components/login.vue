<template>
<div class="column is-8-desktop is-offset-2-desktop is-12-tablet is-offset-0-tablet register">
    <div class="columns">
        <div class="column left">
            <h1 class="title is-2">Welcome to Airducate ✈️</h1>
            <h2 class="subtitle colored is-4">Your one stop place for all your employment training.</h2>
        </div>
        <div class="column right has-text-centered">
            <div class="field">
                <div class="control">
                    <input
                        class="input is-medium"
                        type="email"
                        name="email"
                        placeholder="john@example.com"
                        v-model="email"
                        v-validate="'required|email'"
                    >
                </div>
                <p
                    v-if="errors.has('email')"
                    class="help is-danger"
                >
                    {{ errors.first('email') }}
                </p>
            </div>

            <div class="field">
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
            <button class="button is-block is-primary is-fullwidth is-medium" @click.prevent="login">Submit</button>
            <br />
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            email: null,
            password: null
        }
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', {
                    ...this.$data
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
