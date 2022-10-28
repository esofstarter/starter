<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import {namespace, State} from 'vuex-class';

  import CategoryDatatable from '@/features/Admin/PostsCrud/_components/CategoryDatatable.vue';

  const { Action } = namespace('Root');

  @Component({
               components: {
                 CategoryDatatable,
               },
             })
  export default class Categories extends Vue {
    @Action('setBackUrl') setBackUrl;
    @Action('setMenu') setMenu;
    @Action('setActiveClasses') setActiveClasses;
    @State('homePath') homePath;

    columns: Array<ColumnObject>;

    constructor() {
      super();

      this.setBackUrl('/');

      this.setActiveClasses({
                              main: 'users',
                              sub: 'users',
                              title: 'users.title',
                              hasFilters: 'users',
                            });

      this.columns = [
        {id: 0, width: '15%', label: 'id', name: 'id', sortable: true},
        {id: 1, width: '15%', label: 'title', name: 'title', sortable: true},
        {id: 2, width: '20%', label: 'slug', name: 'slug', sortable: true},
        {id: 3, width: '5%', label: 'strings.actions', name: 'actions', sortable: false},
        {id: 4, width: '5%', label: 'strings.delete', name: 'actions', sortable: false}
      ];
    }
  }
</script>

<template>
  <category-datatable :columns="columns"/>
</template>
