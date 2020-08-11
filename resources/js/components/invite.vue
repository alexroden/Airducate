<template>
<div class="column is-8 is-offset-2 register">
    <div class="columns">
        <div class="column has-text-centered">
            <div class="field">
                <div class="control">
                    <input
                        class="input is-medium"
                        type="text"
                        name="first name"
                        placeholder="John"
                        v-model="first_name"
                        v-validate="'required'"
                    >
                </div>
                <p
                    v-if="errors.has('first name')"
                    class="help is-danger"
                >
                    {{ errors.first('first name') }}
                </p>
            </div>
            <div class="field">
                <div class="control">
                    <input
                        class="input is-medium"
                        type="text"
                        name="last name"
                        placeholder="Doe"
                        v-model="last_name"
                        v-validate="'required'"
                    >
                </div>
                <p
                    v-if="errors.has('last name')"
                    class="help is-danger"
                >
                    {{ errors.first('last name') }}
                </p>
            </div>
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

            <button class="button is-block is-primary is-fullwidth is-medium" @click.prevent="login">Invite</button>
            <br />
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Invite",
    data() {
        return {
            first_name: null,
            email: null,
            last_name: null
        }
    },
    methods: {
        async login() {
            try {
                await axios.post('/api/invite', {
                    ...this.$data
                });

                this.first_name = null;
                this.email = null;
                this.last_name = null;

                document.querySelectorAll('.input').forEach((input) => {
                    input.classList.remove('is-success')
                });

                this.$root.showAlert("is-success", 'Invite has been sent ✉️');
            } catch (e) {
                this.$root.showAlert("is-danger", e.response.data.message);
            }
        }
    }
}
</script>
