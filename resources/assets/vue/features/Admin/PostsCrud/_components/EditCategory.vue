<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import { namespace } from 'vuex-class';
  import PostForm from './PostForm.vue';
  import CategoryForm from '@/features/Admin/PostsCrud/_components/CategoryForm.vue';
  const { Action } = namespace('Root');
  @Component({
               components: {
                 CategoryForm,
               },
             })
  export default class EditCategory extends Vue {
    @Action('setBackUrl') setBackUrl;
    @Action('setMenu') setMenu;
    @Action('setActiveClasses') setActiveClasses;
    constructor() {
      super();
    }
    mounted() {
      this.setBackUrl('/all_categories');
      this.setActiveClasses({
                              main: '/all_categories',
                              sub: 'edit.category',
                              title: 'users.title',
                            });
    }
  }
</script>

<template>
  <category-form/>
</template>
