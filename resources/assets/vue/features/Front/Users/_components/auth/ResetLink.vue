<script lang="ts">
    import { Component, Emit, Vue } from 'vue-property-decorator';
    import Form from '../../../../../../../../node_modules/form-backend-validation';

    @Component
    export default class ResetLink extends Vue {
        form: Form;
        user: any;
        success: boolean;
        isSending: boolean;

        constructor() {
            super();
            this.isSending = false;
            this.success = false;
            this.user = {
                email: '',
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
            this.form.post('../password/email')
                .then((response) => {
                    this.isSending = false;
                    this.success = true;
                })
                .catch((error) => {
                    this.isSending = false;
                });
        }
    }
</script>

<template>
  <div class="sk-modal-overlay">
    <div class="sk-modal-overlay-inner">
      <form id="login_form"
            class="ajaxform"
            @submit.prevent="onSubmit"
            @keydown="form.errors.clear($event.target.name)">

        <div class="sk-modal-head">
          <h4>{{ $t('auth.forgot_password.title') }}</h4>
          <span class="close-btn" @click="closeAuth()">
              <i class="fa fa-times"></i>
            </span>
        </div>

        <div class="sk-modal-body">

          <div class="alert alert-success" role="alert" v-if="success">
            {{ $t('auth.forgot_password.reset_password_email') }}
          </div>

          <div class="alert alert-danger" role="alert" v-if="form.errors.any()">
            {{(form.errors.has('email') ? $t(form.errors.get('email')[0]): $t('errors.generic_error'))}}
          </div>

          <div class="form-group">
            <label for="reset-email-input">{{ $t('auth.email') }}</label>
            <input type="text"
                   name="email"
                   id="reset-email-input"
                   class="form-control"
                   v-model="form.email">
          </div>

          <div class="form-group">
            <input type="submit"
                   value="Send link to reset"
                   :class="{ disabled: isSending }"
                   class="btn btn-primary btn-block">
          </div>

          <a class="link"
             @click="setActiveSection('login')"
             title="Login"
             type="button">{{ $t('auth.login.title') }}</a>

        </div>

        <div class="sk-modal-foot">
          <span class="mr-2">{{ $t('auth.login.no_account_yet') }} ?</span>
<!--TODO      wizard login is not set here it should either be passed or removed. I removed it because the original reason behind the use was from another project-->
<!--          <span-->
<!--            @click="setActiveSection('register')"-->
<!--            :class="(wizardLogin ? 'wizard_login' : '')"-->
<!--            class="link">-->
<!--              {{ $t('auth.register') }}-->
<!--          </span>-->
          <span
            @click="setActiveSection('register')"
            class="link">
              {{ $t('auth.register') }}
          </span>
        </div>

      </form>
    </div>
  </div>
</template>
