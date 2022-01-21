<script lang="ts">
  import { Component, Emit, Vue } from 'vue-property-decorator';
  import getPhotoPath from '@/utils/imageProcessing';

  @Component
  export default class  ProfileModal extends Vue {

    constructor() {
      super();

    }

    @Emit('close-auth')
    closeAuth(): void {
    }

    logout() {
      this.$auth.logout({
        makeRequest: true,
        redirect: { name: 'homepage' },
      });
    }

    getAvatar(){
      let avatar = '';
      if(this.$auth.user().media != undefined){
        avatar = this.$auth.user().media.find(o => o.collection_name === 'user_avatars');
        if(avatar != undefined)
          return getPhotoPath(avatar.id + ',' + avatar.name + ',' + avatar.mime_type, 400);
      }
      return '';
    }
  }
</script>

<template>
    <div class="sk-modal-overlay">
      <div class="sk-modal-overlay-inner">
        <div id="login_form">

          <div class="sk-modal-head">
            <h4>{{$auth.user().first_name}} {{$auth.user().last_name}}</h4>
            <span class="close-btn" @click="closeAuth()">
              <i class="fa fa-times"></i>
            </span>
          </div>

          <div class="sk-modal-body">

            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-3">
                  <img class="img-fluid rounded-circle" :src="getAvatar()" :alt="'user_avatar'">
                </div> <!-- col-sm-3 -->
                <div class="col-sm-9">
                  <table class="table table-sm">
                    <tbody>
                      <tr>
                        <th>{{ $t('users.email.label') }}</th>
                        <td>{{$auth.user().email}}</td>
                      </tr>
                      <tr>
                        <th>{{ $t('users.first_name.label') }}</th>
                        <td>{{$auth.user().first_name}}</td>
                      </tr>
                      <tr>
                        <th>{{ $t('users.last_name.label') }}</th>
                        <td>{{$auth.user().last_name}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div> <!-- col-sm-9 -->
              </div>
            </div>
          </div>

          <div class="sk-modal-foot">
            <router-link
              :to="{ path: '/user/dashboard/user-profile' }"
              @click.native="closeAuth()"
              class="btn btn-primary">
              <i class="fa fa-user mr-2"></i>
              {{ $t('general.my.profile') }}
            </router-link>
            <a
              @click.prevent="logout"
              class="btn">
              {{ $t('general.logout') }}
              <i class="fa fa-sign-out ml-1"></i>
            </a>
          </div>

        </div>
      </div>
    </div>
</template>
