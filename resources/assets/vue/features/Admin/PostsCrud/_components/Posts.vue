<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import {namespace, State} from 'vuex-class';

    import PostsDatatable from "./PostsDatatable.vue";

    const { Action } = namespace('Root');

    @Component({
        components: {
            PostsDatatable,
        },
    })
    export default class Users extends Vue {
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
                {id: 2, width: '20%', label: 'body', name: 'body', sortable: true},
                {id: 3, width: '10%', label: 'creator', name: 'creator', sortable: true},
                {id: 5, width: '5%', label: 'strings.actions', name: 'actions', sortable: false},
                {id: 6, width: '5%', label: 'strings.delete', name: 'actions', sortable: false}
            ];
        }
    }
</script>

<template>
  <posts-datatable :columns="columns"/>
</template>
