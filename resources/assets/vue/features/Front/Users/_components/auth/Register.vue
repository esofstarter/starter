<script lang="ts">
    import { Component, Emit, Vue, Prop } from 'vue-property-decorator';
    import { namespace } from 'vuex-class';
    import Form from '../../../../../../../../node_modules/form-backend-validation';

    const { Action } = namespace('Root');
    const { State } = namespace('Root');

    @Component
    export default class Register extends Vue {
        @Action('Root/setData') setData;
        @Prop() wizardLogin;
        @Prop() product_id;
        @Prop() offer_type;
        @Prop() price;
        @Prop() name;

        login_form: any;
        showMessage = false;
        authError = false;
        isSending = false;
        user: MyProfileFormItem;
        form: Form;

        constructor() {
            super();
            this.user = {
              email: '',
              first_name: '',
              last_name: '',
              password: '',
              password_confirmation: '',
              source: 'login',
              product_id: this.product_id,
              offer_type: this.offer_type,
              price: this.price,
              name: this.name,
            };
            this.login_form = {
              email: '',
              password: '',
            };
          this.form = new Form(this.user);
        }

        @Emit('close-auth')
        closeAuth(): void {
        }

        @Emit('set-active-section')
        setActiveSection(string: string): void {
        }

        onSubmit() {
            this.isSending = true;
            this.login_form.email = this.form.email;
            this.login_form.password = this.form.password;
            if(this.form.password == ''){
                delete(this.form.password);
            }
            this.form.post('/guest/user/new')
                .then((response) => {
                    this.isSending = false;
                    // TODO: #26689 Upon successful registration redirect to new page with only the verify user message (new component, new route) HINT: similar to User Activate
                    this.$router.push({name: 'verify_registration'});
                    // try {
                    //   this.showMessage = true;
                    // } catch {
                    //   this.authError = true;
                    // }
                })
                .catch((error) => {
                    this.authError = true;
                    this.isSending = false;
                });
        }

        async doLogin() {
            await this.$auth.login({
                data: this.login_form,
                success(response) {
                    const { status } = response;

                    // this.setUser(this.$auth.user());

                    if (status === 401) {
                        this.authError = true;
                    }
                    this.closeAuth();
                    this.setData();
                },
                redirect: (!this.wizardLogin ? { name: 'user.dashboard', params: { success: '1' }} : false)
            });
        }
    }
</script>

<template>
    <div class="sk-modal-overlay">
      <div v-if="showMessage"
           class="sk-modal-overlay-inner">
          <div class="sk-modal-head">
            <h4>{{ $t('auth.registration.title') }}</h4>
            <span class="close-btn" @click="closeAuth()">
              <i class="fa fa-times"></i>
            </span>
          </div> <!-- sk-modal-head -->

          <div class="sk-modal-body">
            <p>
              You have been sent a verification email. Please verify the email address by visiting the link you have received.
            </p>
          </div> <!-- sk-modal-body -->

          <div class="sk-modal-foot">
              <span class="mr-2">{{ $t('auth.registration.already_have_account') }} ?</span>
              <span
                @click="setActiveSection('login')"
                :class="(wizardLogin ? 'wizard_login' : '')"
                class="link">{{ $t('auth.login.title') }}</span>
          </div> <!-- sk-foot -->
      </div>
      <div v-else
           class="sk-modal-overlay-inner">
        <form id="login_form"
              class="ajaxform"
              name="registration"
              @submit.prevent="onSubmit"
              @keydown="form.errors.clear($event.target.name)">

          <div class="sk-modal-head">
            <h4>{{ $t('auth.registration.title') }}</h4>
            <span class="close-btn" @click="closeAuth()">
              <i class="fa fa-times"></i>
            </span>
          </div> <!-- sk-modal-head -->

          <div class="sk-modal-body">

            <div class="form-group">
              <label for="first-name-input">{{ $t('users.first_name.label') }}</label>
              <input type="text"
                     v-model="form.first_name"
                     name="first_name"
                     id="first-name-input"
                     class="form-control">
              <div class="invalid-feedback" v-if="form.errors.has('first_name')">
                {{ $t(form.errors.get('first_name')) }}
              </div>
            </div> <!-- .form-group -->

            <div class="form-group">
              <label for="last-name-input">{{ $t('users.last_name.label') }}</label>
              <input type="text"
                     v-model="form.last_name"
                     name="last_name"
                     id="last-name-input"
                     class="form-control">
              <div class="invalid-feedback" v-if="form.errors.has('last_name')">
                {{ $t(form.errors.get('last_name')) }}
              </div>
            </div> <!-- .form-group -->

            <div class="form-group">
              <label for="email-input">{{ $t('auth.email') }}</label>
              <input type="text"
                     v-model="form.email"
                     name="email"
                     id="email-input"
                     class="form-control">
              <div class="invalid-feedback" v-if="form.errors.has('email')">
                {{ $t(form.errors.get('email')) }}
              </div>
            </div> <!-- .form-group -->

            <div class="form-group">
              <label for="password-input">{{ $t('auth.password') }}</label>
              <input type="password"
                     v-model="form.password"
                     id="password-input"
                     name="password"
                     class="form-control">
              <div class="invalid-feedback" v-if="form.errors.has('password')">
                {{ $t(form.errors.get('password')) }}
              </div>
            </div> <!-- .form-group -->

            <div class="form-group">
              <label for="password-confirmation-input">{{ $t('auth.confirm_password') }}</label>
              <input type="password"
                     v-model="form.password_confirmation"
                     id="password-confirmation-input"
                     name="password_confirmation"
                     class="form-control">
              <div class="invalid-feedback" v-if="form.errors.has('password_confirmation')">
                {{ $t(form.errors.get('password_confirmation')) }}
              </div>
            </div> <!-- .form-group -->

            <div class="form-group">
              <input type="submit"
                     :class="{ disabled: isSending }"
                     value="Register"
                     class="btn btn-primary btn-block">
            </div><!-- .form-group -->

          </div> <!-- sk-modal-body -->

          <div class="sk-modal-foot">
              <span class="mr-2">{{ $t('auth.registration.already_have_account') }} ?</span>
              <span
                @click="setActiveSection('login')"
                :class="(wizardLogin ? 'wizard_login' : '')"
                class="link">{{ $t('auth.login.title') }}</span>
          </div> <!-- sk-foot -->

        </form>
      </div> <!-- sk-modal-overlay-inner -->
    </div> <!-- sk-modal-overlay -->
</template>
