<script lang="ts">
  import {Component, Mixins, Prop, Vue} from 'vue-property-decorator';
  import { namespace } from 'vuex-class';
  import Datatable from '../../../../components/Datatables/Datatable.vue';
  import Pagination from '../../../../components/Datatables/Pagination.vue'
  import { DatatableMixin } from '@/mixins/DatatableMixin';
  import DatatableNew from "@/components/Datatables/DatatableNew.vue";
  import CategoryTableRow from './CategoriesTableRow.vue';

  @Component({
               components: {
                 Datatable,
                 Pagination,
                 CategoryTableRow,
                 DatatableNew,
               }
             })

  export default class CategoryDatatable extends Mixins(DatatableMixin) {

    endpoint: string = 'categories';
    datatable_data: UserTableRow[] = [];
    roles: Array<any>;
    statuses: Array<any>;
    categories: Array<any>;
    tableData;

    constructor() {
      super();
      this.roles = [];
      this.categories = [];
      this.statuses = [
        {id: 3, name: 'All status'},
        {id: 0, name: 'Enabled'},
        {id: 1, name: 'Disabled'},
      ];
      this.sortKey = 'first_name';
      this.tableData = {
        draw: 1,
        length: 10,
        search: '',
        column: 0,
        dir: 'desc',
        error: false,
        errorMessage: '',
        noRecords: false,
      };
    }

    async mounted() {
      this.columns.forEach((column) => {
        this.sortOrders[column.name] = -1;
      });
      await this.fetchRoles();
      await this.fetchCategories();
      // await this.getData();
      // await this.fetchData();
      if (Number(Vue.router.currentRoute.params.success)) {
        this.success = 1;
      } else {
        this.success = 0;
      }
    }

    fetchCategories() {
      this.axios.get('category/all')
        .then((response) => {
          this.datatable_data = response.data;
          this.loading = false;
        }).catch(err => {
        console.log(err.message);
      });
    }

    fetchRoles() {
      this.axios.get('user/roles/get')
        .then((response) => {
          this.roles = response.data;
          this.roles.push({id: 0, display_name: '- All roles -'});
        });
    }
  }
</script>
<template>

  <datatable-new v-model="tableData"
                 :loading="loading"
                 :columns="columns"
                 :sortKey="sortKey"
                 :pagination="pagination"
                 :langKey="'categories'"
                 :addRouteName="'add_categories'"
                 :datatableData="datatable_data"
                 @trigger-sort="triggerSort"
                 @get-data="fetchCategories"
                 @length="changeLength">
    <category-table-row v-for="category in datatable_data" :key="category.id" :columns="columns" @get-data="fetchCategories" :category="category"></category-table-row>
  </datatable-new>
</template>
