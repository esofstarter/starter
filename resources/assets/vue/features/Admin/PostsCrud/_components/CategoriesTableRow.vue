<script lang="ts">
  import { Component, Watch, Prop, Vue } from 'vue-property-decorator';
  import TableColumn from '@/components/Datatables/_partials/TableColumn.vue'
  import dialog from '@/utils/dialog';


  @Component({
               components: {
                 TableColumn
               },
             })
  export default class CategoriesTableRow extends Vue {
    @Prop() value;
    @Prop() columns;
    @Prop() category;

    isHovering: boolean = false;
    order_statuses: Array<any>;

    constructor() {
      super();
      this.order_statuses = [
        {'id': 0, 'name': 'Approved'},
        {'id': 1, 'name': 'Declined'},
        {'id': 2, 'name': 'Shipped'},
        {'id': 3, 'name': 'Delivered'}
      ];
    }

    async deleteCategory(category: CategoryFormItem, index: number): Promise<void> {
      if (!await dialog('general.confirm.delete', true)) {
        return;
      }
      this.axios.get('category/'+index+'/delete')
        .then(response => {
          dialog('strings.front.deleted_successfully', false);
          this.$emit('get-data');
        })
        .catch(error => {
          dialog(error.response.data.message, false);
        });
    }
  }
</script>

<template>
  <tr
    @mouseover="isHovering = true"
    @mouseout="isHovering = false"
    v-if="columns"
    class="kt-datatable__row"
    :class="{'kt-datatable__row--hover': isHovering}"> <!--kt-datatable__row&#45;&#45;even-->

    <table-column :width="columns[0].width">
      {{category.id}}
    </table-column>

    <table-column :width="columns[1].width">
      {{category.title}}
    </table-column>

    <table-column :width="columns[2].width">
      {{ category.slug }}
    </table-column>

    <table-column :width="columns[3].width">
      <router-link v-if="$auth.user().permissions_array.includes('user_write')"
                   :to="{ name: 'edit.category', params: { categoryId: category.id }}"
                   exact="">
        <i aria-hidden="true"
           class="fa fa-pencil-square-o"></i> 
        {{ $t('buttons.edit') }}
      </router-link>
    </table-column>

    <table-column :width="columns[4].width">
      <i v-if="$auth.user().permissions_array.includes('user_write')"
         @click="deleteCategory(category, category.id)"
         variant="link"
         aria-hidden="true"
         class="fa fa-trash-o"></i>
    </table-column>

  </tr>
</template>
