<script lang="ts">
    import { Component, Emit, Vue, Prop } from 'vue-property-decorator';
    import { namespace } from 'vuex-class';
    import formValidation from '../../../../../utils/formValidation';
    import EventBus from "@/utils/event-bus";

    const { Action } = namespace('Root');
    const { State } = namespace('Root');

    @Component
    export default class Login extends Vue {
        @Action('Root/setData') setData;
        @Prop() wizardLogin;
        @Prop({ default: true }) redirect;

        form = {};
        authError = false;
        isSending = false;
        redirectRouteName: string = 'dashboard';

        @Emit('close-auth')
        closeAuth(): void {
        }

        @Emit('set-active-section')
        setActiveSection(string: string): void {
        }

        async doLogin() {
            await this.$auth.login({
                data: this.form,
                success(response) {
                    const { status } = response;

                    // this.setUser(this.$auth.user());

                    if (status === 401) {
                        this.authError = true;
                    }
                    this.closeAuth();
                    this.setData();
                    if(this.redirect) {
                        if (this.$auth.user().roles_array.includes(1)) {
                            console.log('User is admin. ');
                            window.location.assign('/admin');
                        }
                        if (this.$auth.user().roles_array.includes(3)) {
                            console.log('User is public. ');
                            console.log(this.$auth.user());
                            this.$router.push({name: 'user.dashboard'});
                        }
                    }
                    else {
                        EventBus.$emit("authenticationSuccessful");
                    }
                },
                redirect: (false)
            });
        }

        async login(evt: Event) {
            if (!formValidation(evt)) return;

            this.isSending = true;

            try {
                await this.doLogin();
            } catch {
                this.authError = true;
            }

            this.isSending = false;
        }
    }
</script>

<template>
    <div class="sk-modal-overlay">
      <div class="sk-modal-overlay-inner">
        <form id="login_form"
                class="ajaxform"
                @submit="login">

          <div class="sk-modal-head">
            <h4>{{ $t('auth.login.title') }}</h4>
            <span class="close-btn" @click="closeAuth()">
              <i class="fa fa-times"></i>
            </span>
          </div>

          <div v-if="wizardLogin"><b style="color: #ff526e">To create an entry, you must log in or register.</b></div>

          <div class="sk-modal-body">

            <div class="form-group">
              <label for="login-email-input">{{ $t('auth.email') }}</label>
              <input type="text"
                     v-model="form.email"
                     name="email"
                     id="login-email-input"
                     class="form-control"
                     required="required">
            </div>

            <div class="form-group">
              <label for="login-password-input">{{ $t('auth.password') }}</label>
              <input type="password"
                     id="login-password-input"
                     class="form-control"
                     v-model="form.password"
                     required="required">
            </div>

            <div
              class="alert alert-danger"
              role="alert"
              v-if="authError">
              {{ $t('auth.login.incorrect_password') }}
            </div>

            <div class="form-group">
              <input
                type="submit"
                v-bind:value="$t('auth.login.title')"
                :class="{ disabled: isSending }"
                class="btn btn-primary btn-block">
            </div>

            <div class="text-right">
              <a class="link"
                 @click="setActiveSection('reset')"
                 v-bind:title="$t('auth.login.forgot_your_password')"
                 type="button">
                {{ $t('auth.login.forgot_your_password') }} ?
              </a>
            </div>
            <!--<input type="checkbox" id="permanent" name="permanent" value="1"><label for="permanent"><b></b>Eingeloggt bleiben</label>-->

          </div>

            <div class="sk-modal-foot">
                <span class="mr-2">{{ $t('auth.login.no_account_yet') }} ?</span>
                <span
                  @click="setActiveSection('register')"
                  :class="(wizardLogin ? 'wizard_login' : '')"
                  class="link">
                    {{ $t('auth.register') }}
                </span>
            </div>

        </form>
      </div>
    </div>
</template>
