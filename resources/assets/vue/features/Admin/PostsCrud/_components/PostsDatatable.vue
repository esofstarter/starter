<script lang="ts">
    import {Component, Mixins, Prop, Vue} from 'vue-property-decorator';
    import { namespace } from 'vuex-class';
    import Datatable from '../../../../components/Datatables/Datatable.vue';
    import Pagination from '../../../../components/Datatables/Pagination.vue'
    import { DatatableMixin } from '@/mixins/DatatableMixin';
    import DatatableNew from "@/components/Datatables/DatatableNew.vue";
    import PostsTableRow from './PostsTableRow.vue';

    @Component({
        components: {
            Datatable,
            Pagination,
            PostsTableRow,
            DatatableNew,
        }
    })

    export default class PostsDatatable extends Mixins(DatatableMixin) {

        endpoint: string = 'posts';
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
            await this.fetchData();
            if (Number(Vue.router.currentRoute.params.success)) {
                this.success = 1;
            } else {
                this.success = 0;
            }
        }

        fetchData() {

            let pathToController;
            
            if(this.$route.path == '/admin/my_posts'){
                pathToController = this.endpoint+'/drawMyPosts';
            }else{
                pathToController = this.endpoint+'/draw';
            }

            this.axios.post(pathToController, this.tableData).then(resp => {
                this.datatable_data = resp.data;
                this.loading = false;
            }).catch(err => {
                console.log(err.message);
            })
        }
        fetchCategories() {
          this.axios.get('category/all')
            .then((response) => {
              this.categories = response.data;
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
                 :langKey="'posts'"
                 :addRouteName="'add_posts'"
                 :datatableData="datatable_data"
                 @trigger-sort="triggerSort"
                 @get-data="fetchData"
                 @length="changeLength">
    <posts-table-row v-for="post in datatable_data" :key="post.id" :columns="columns" @get-data="fetchData" :post="post"></posts-table-row>
  </datatable-new>
</template>
