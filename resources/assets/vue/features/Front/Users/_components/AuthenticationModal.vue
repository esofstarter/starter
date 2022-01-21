<script lang="ts">
  import 'reflect-metadata';
  import { Component, Emit, Vue, Prop } from 'vue-property-decorator';
  import Login from './auth/Login.vue';
  import Register from './auth/Register.vue';
  import ResetLink from './auth/ResetLink.vue';

  @Component({
    components: {
      Login,
      Register,
      ResetLink
    }
  })
  export default class AuthenticationModal extends Vue {

    @Prop({ default: false }) wizardLogin;
    @Prop({ default: true }) redirect;
    @Prop() product_id;
    @Prop() offer_type;
    @Prop() price;
    @Prop() name;

    active_section: string;

    constructor() {
      super();
      this.active_section = 'login';
    }

    @Emit('close-auth')
    closeAuth(): void {
    }

    setActiveSection(section: string): void {
        this.active_section = section;
    }
  }
</script>

<template>
    <div>
        <div v-if="active_section === 'login'">
            <!-- Login -->
            <login @set-active-section="setActiveSection"
                   @close-auth="closeAuth" :redirect="redirect" :wizardLogin="wizardLogin">
            </login>
        </div>
        <div v-if="active_section === 'register'">
            <!-- Registration -->
            <register @set-active-section="setActiveSection"
                      @close-auth="closeAuth"
                      :wizardLogin="wizardLogin"
                      :product_id="product_id"
                      :offer_type="offer_type"
                      :price="price"
                      :name="name"
            >
            </register>
        </div>
        <div v-if="active_section === 'reset'">
            <!-- Forgot your password? -->
            <reset-link @set-active-section="setActiveSection"
                        @close-auth="closeAuth">
            </reset-link>
        </div>
    </div>
</template>
