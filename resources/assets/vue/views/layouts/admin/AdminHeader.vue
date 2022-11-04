<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import UserBar from '@/components/AdminSection/UserBar.vue'

    @Component({
        components: {
          UserBar
        }
    })
    export default class AdminHeader extends Vue {

    }
</script>
<template>
  <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed">

    <!-- begin:: Header Menu -->
    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
      <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default "></div>
    </div>
    <!-- end:: Header Menu -->

    <!-- begin:: Header Topbar -->

    <div class="kt-header__topbar">
      <user-bar/>
    </div>

    <!-- end:: Header Topbar -->
  </div>
</template>
