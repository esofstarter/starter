<script lang="ts">
    import { Component, Watch, Prop, Vue } from 'vue-property-decorator';
    import TableColumn from '@/components/Datatables/_partials/TableColumn.vue'
    import dialog from '@/utils/dialog';


    @Component({
      components: {
        TableColumn
      },
    })
    export default class PostsTableRow extends Vue {
        @Prop() value;
        @Prop() columns;
        @Prop() post;

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

        async deletePost(post: PostFormItem, index: number): Promise<void> {
          if (!await dialog('general.confirm.delete', true)) {
            return;
          }
          this.axios.get('posts/'+index+'/delete')
            .then(response => {
              dialog('strings.front.deleted_successfully', false);
              this.$emit('getData');
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
      {{post.id}}
    </table-column>

    <table-column :width="columns[1].width">
      {{post.title}}
    </table-column>

    <table-column :width="columns[2].width">
      {{post.body}}
    </table-column>

    <table-column :width="columns[3].width">
      {{ post.user_id }}
    </table-column>

    <table-column :width="columns[4].width">
      <router-link v-if="$auth.user().permissions_array.includes('user_write')"
                   :to="{ name: 'edit.post', params: { postId: post.id }}"
                   exact="">
        <i aria-hidden="true"
           class="fa fa-pencil-square-o"></i> 
        {{ $t('buttons.edit') }}
      </router-link>
    </table-column>

    <table-column :width="columns[5].width">
      <i v-if="$auth.user().permissions_array.includes('user_write')"
         @click="deletePost(post, post.id)"
         variant="link"
         aria-hidden="true"
         class="fa fa-trash-o"></i>
    </table-column>

  </tr>
</template>
