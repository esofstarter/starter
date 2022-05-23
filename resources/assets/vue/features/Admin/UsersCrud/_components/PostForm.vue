<script lang="ts">
    import 'reflect-metadata'
    import {Component, Mixins, Vue, Watch} from 'vue-property-decorator';
    import Form from '../../../../../../../node_modules/form-backend-validation';
    import { namespace } from 'vuex-class';
    import { cloneDeep } from 'lodash';
    import 'bootstrap';
    import FormInput from "../../_partials/FormInput.vue";
    import {FormMixin} from "@/mixins/FormMixin";
    import EventBus from '@/utils/event-bus';
    import AdminSection from '@/components/AdminSection/AdminSection';
    import UnsavedChangesModal from "@/features/Front/Users/_components/UnsavedChangesModal.vue";
    import getPhotoPath from '@/utils/imageProcessing';

    import { user } from '@/utils/Objects';
    // import {createFile} from "@/utils/edgeFileUpload";

    const { State } = namespace('Root');
    const { Action } = namespace('Root');

    @Component({
        components:{
            FormInput,
            AdminSection,
            UnsavedChangesModal
        }
    })
    export default class UserForm extends Mixins(FormMixin) {
        @State('homePath') homePath;

        @Action('setBackUrl') setBackUrl;
        @Action('setMenu') setMenu;
        @Action('setActiveClasses') setActiveClasses;

        @Watch('item')
        handleAdditionalInitialisation()
        {
          if(this.edit) {
              this.item.roles = this.item.roles_array[0];
          }
          else{
              this.item.roles = 3;
          }
          this.form.populate(this.item);
          this.form.setInitialValues(this.item);
        }

        loading: boolean;
        item: UserFormItem;
        fetchUri: string;
        id: number | undefined;
        edit: boolean;
        form: Form;
        roles: Array<any>;
        countries: Array<any> = [];

        constructor() {
            super();
            this.loading = true;
            this.edit = Vue.router.currentRoute.name == 'edit.user';
            this.id = Number(Vue.router.currentRoute.params.userId);
            this.fetchUri = '/user/' + this.id + '/get';
            this.item = cloneDeep(user);
            this.form = new Form(this.item);
            this.roles = [];
        }

        mounted() {
            this.fetchRoles();
            if (this.edit) {
              this.initFormFromItem();
            }
            // else{
            //     this.loading = false;
            // }
            this.setActiveClasses({
              main: '/users',
              sub: this.$router.currentRoute.name,
              title: 'users.title',
            });
        }

        getRoute() {
            if (this.edit) {
                return '/user/' + Vue.router.currentRoute.params.userId + '/edit';
            }
            return '/user/new';
        }

        getRedirectRoute() {
            if (this.form.roles == 1 || this.form.roles == 2) {
                return 'users';
            }if (this.form.roles == 3) {
                return 'users.public';
            }
        }

        fetchRoles() {
            this.axios.get('user/roles/get')
                .then((response) => {
                    this.roles = response.data;
                    this.loading = false;
                });
        }

        getAvatar(){
            let avatar = '';
            if(this.item.media != undefined){
                avatar = this.item.media.find(o => o.collection_name === 'user_avatars');
                if(avatar != undefined)
                    return getPhotoPath(avatar.id + ',' + avatar.name + ',' + avatar.mime_type, 400);
            }
            return '';
        }

        beforeSubmit(route, redirect_success, stop_redirect){
          // if(this.form.password == '' && this.form.password_confirmation == '') {
          //   delete (this.form.password);
          //   delete (this.form.password_confirmation);
          // }
          this.onSubmit(route, redirect_success, stop_redirect);
        }
    }
</script>

<template>
  <form
    @submit.prevent="beforeSubmit(getRoute(), getRedirectRoute(), false)"
    @keydown="form.errors.clear($event.target.name)"
    autocomplete="off"
    enctype="multipart/form-data"
    class="container-fluid">
    <div class="row">

      <div class="col-md-9">
        <admin-section :loading="loading">

          <h4 slot="header">{{ $t('users.basic.information') }}</h4>

          <template slot="content">

            <div class="form-row">
              <div class="col-md-3 col-sm-6">
                <form-input :id="'title'" :label="'posts.title.label'" v-model="form.title" :form="form"></form-input>
              </div>
              <div class="col-md-3 col-sm-6">
                <form-input :id="'first_name'" :label="'posts.post'" v-model="form.post" :form="form"></form-input>
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-3 col-sm-6">
                <form-input :id="'email'" :label="'posts.email.label'" v-model="form.email" :form="form"></form-input>
              </div>
            </div>

            <hr>

            <div class="form-row">
              <div class="col-12">
                <h4>{{ $t('users.password.new_password') }}</h4>
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-3 col-sm-6">
                <form-input :id="'password'" :label="'users.password.label'" v-model="form.password" :form="form"></form-input>
              </div>
              <div class="col-md-3 col-sm-6">
                <form-input :id="'password_confirmation'" :label="'users.password.confirm'" v-model="form.password_confirmation" :form="form"></form-input>
              </div>
            </div>

          </template>

        </admin-section>

      </div>

      <div class="col-md-3">
        <admin-section :loading="loading">

          <h4 slot="header">{{ $t('users.user_status') }}</h4>

          <div class="form-row" slot="content">
            <div class="col-12">
              <form-dropdown :id="'roles'" :label="'users.roles.label'" v-model="form.roles" :options="roles" :form="form" isInline="true"></form-dropdown>
            </div>
          </div>

          <div class="form-row" slot="content">
            <div class="col-md-12">
              <form-input-radio :id="'enabled'" :label="'users.status'" :options="[{'id': 0, 'name':'Enabled'},{'id': 1, 'name':'Disabled'}]" v-model="form.is_disabled" :form="form"></form-input-radio>
            </div>
          </div>

          <button
            type="submit"
            :loading="loading"
            class="btn btn-success"
            slot="footer">
            <i class="fa fa-save mr-1"></i>
            {{ $t('buttons.save') }}
          </button>

          <router-link
            :loading="loading"
            :to="`/admin/users/public`"
            exact=""
            class="btn btn-outline-secondary"
            slot="footer">
            {{ $t('buttons.cancel') }}
          </router-link>

        </admin-section>

        <admin-section :loading="loading">

          <h4 slot="header">{{$t('users.avatar')}}</h4>

          <file-upload
            slot="content"
            :id="'uploaded_file'"
            v-model="form.uploaded_file"
            :placeholder-image="getAvatar()"
            :form="form"></file-upload>

        </admin-section>
      </div>

    </div>
    <unsaved-changes-modal
      v-if="confirmUnsavedChangesModal"
      @confirm-unsaved-changes="confirmUnsavedChanges"
      @cancel-unsaved-changes="cancelUnsavedChanges">

    </unsaved-changes-modal>
  </form>
</template>
