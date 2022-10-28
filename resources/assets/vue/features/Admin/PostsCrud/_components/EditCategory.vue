<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import { namespace } from 'vuex-class';
  import PostForm from './PostForm.vue';
  const { Action } = namespace('Root');
  @Component({
               components: {
                 PostForm,
               },
             })
  export default class EditUser extends Vue {
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
  <post-form/>
</template>
