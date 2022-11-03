<script lang="ts">
import "reflect-metadata";
import { Component, Mixins, Vue, Watch } from "vue-property-decorator";
import Form from "../../../../../../../node_modules/form-backend-validation";
import { namespace } from "vuex-class";
import { cloneDeep } from "lodash";
import "bootstrap";
import FormInput from "../../_partials/FormInput.vue";
import Textarea from "../../_partials/TextArea.vue";
import { FormMixin } from "@/mixins/FormMixin";
import AdminSection from "@/components/AdminSection/AdminSection";
import UnsavedChangesModal from "@/features/Front/Users/_components/UnsavedChangesModal.vue";
import getPhotoPath from "@/utils/imageProcessing";
import VueSelect from 'vue-select';

import { category, post } from "@/utils/Objects";
// import {createFile} from "@/utils/edgeFileUpload";

const { State } = namespace("Root");
const { Action } = namespace("Root");

@Component({
  components: {
    FormInput,
    AdminSection,
    UnsavedChangesModal,
    Textarea,
    VueSelect
  },
})
export default class PostForm extends Mixins(FormMixin) {
  @State("homePath") homePath;

  @Action("setBackUrl") setBackUrl;
  @Action("setMenu") setMenu;
  @Action("setActiveClasses") setActiveClasses;

  edit: boolean;
  form: Form;
  item: PostFormItem;
  categories: any = [];
  // selectedCategories: any = [];

  constructor() {
    super();
    this.item = cloneDeep(post);
    this.edit = Vue.router.currentRoute.name == "edit.post";
    this.form = new Form(this.item);
  }

  mounted() {
    this.fetchPost();
    this.fetchCategories();
    
  }

  getRoute() {
    if (this.edit) {
      return "/posts/" + Vue.router.currentRoute.params.postId + "/edit";
    }
    return "/posts/new";
  }

  getRedirectRoute() {
    return "all_posts";
  }

  fetchPost() {
    if (this.edit) {
      var getRoute = "/posts/" + Vue.router.currentRoute.params.postId + "/get";
      this.axios.get(getRoute).then((response) => {
        this.form.title = response.data.title;
        this.form.body = response.data.body;
        this.form.id = response.data.id;
      });
    }
    this.loading = false;
  }

  fetchCategories() {
    this.axios.get('/category/all').then(resp => {
      this.categories = resp.data;
    })
  }

  getAvatar() {
    let avatar = "";
    if (this.item.media != undefined) {
      avatar = this.item.media.find(
        (o) => o.collection_name === "user_avatars"
      );
      if (avatar != undefined)
        return getPhotoPath(
          avatar.id + "," + avatar.name + "," + avatar.mime_type,
          400
        );
    }
    return "";
  }
  // selectedOptions(option){
  //   this.selectedCategories.push(option);
  // }
  // removeOption(optionToBeRemoved){
  //   console.log("remove clicked");
  //   this.form.categories = this.form.categories.filter((tag) => tag.name !== optionToBeRemoved.name);
  // }

  beforeSubmit(route, redirect_success, stop_redirect) {
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
    class="container-fluid"
  >
    <div class="row">
      <div class="col-md-12">
        <admin-section :loading="loading">
<h4 slot="header">{{ $t("posts.basic.posts") }}</h4>

<template slot="content">
  <div class="form-row">
    <div class="col-md-12 col-sm-6">
      <form-input
        :id="'title'"
        :label="'posts.basic.title'"
        v-model="form.title"
        :form="form"
      ></form-input>
    </div>
    <div class="col-md-12 col-sm-6">
      <form-input
        :id="'post_body'"
        :label="'posts.basic.post'"
        v-model="form.body"
        :form="form"
      ></form-input>
    </div>
    <div class="col-md-12 col-sm-6 form-group">
      <label for="categories">Categories</label>
      <vue-select multiple v-model="form.categories" :options="categories">
        <template v-slot:option="option">
          <span :class="option.icon"></span>
          {{ option.title }}
        </template>
        <template #selected-option="option">
          <div style="display: flex; align-items: baseline">
            {{ option.title }}
          </div>
        </template>
      </vue-select>
    </div>
  </div>
</template>
        </admin-section>
      </div>
<div class="col-md-3">
        <button
          type="submit"
          :loading="loading"
          class="btn btn-success"
          slot="footer"
        >
          <i class="fa fa-save mr-1"></i>
          {{ $t("buttons.save") }}
        </button>

        <router-link
          :loading="loading"
          :to="`/admin/all_posts`"
          exact=""
          class="btn btn-outline-secondary"
          slot="footer"
        >
          {{ $t("buttons.cancel") }}
        </router-link>
      </div>
    </div>

    <unsaved-changes-modal
      v-if="confirmUnsavedChangesModal"
      @confirm-unsaved-changes="confirmUnsavedChanges"
      @cancel-unsaved-changes="cancelUnsavedChanges"
    >
    </unsaved-changes-modal>
  </form>
</template>
