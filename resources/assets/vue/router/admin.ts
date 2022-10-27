import Vue from 'vue';
import { RouteConfig } from 'vue-router';
// Authenticated user routes
const AdminDefaultPage = () => import(/* webpackChunkName: "AdminDefaultPage" */ '../views/layouts/admin/AdminDefaultPage.vue');
const Dashboard = () => import(/* webpackChunkName: "AdminDashboard" */ '../views/admin/Dashboard.vue');
const Users = () => import(/* webpackChunkName: "Users" */ '../views/admin/Users/Users.vue');
const PublicUsers = () => import(/* webpackChunkName: "PublicUsers" */ '../views/admin/Users/PublicUsers.vue');
const MyProfile = () => import(/* webpackChunkName: "MyProfile" */ '../views/admin/Users/MyProfile.vue');
const UserForm = () => import(/* webpackChunkName: "EditUser" */ '../features/Admin/UsersCrud/_components/UserForm.vue');
const EditUserAdditionalData = () => import(/* webpackChunkName: "EditUserAdditionalData" */ '../views/admin/Users/EditUserAdditionalData.vue');
const PostForm = () => import(/* webpackChunkName: "EditPost" */ '../features/Admin/PostsCrud/_components/PostForm.vue');
const Posts = () => import(/* webpackChunkName: "EditPost" */ '../features/Admin/PostsCrud/_components/Posts.vue');
/*INSERT NEW IMPORTS HERE*/

export let adminPaths: RouteConfig =
  {
    path: '/admin',
    component: AdminDefaultPage,
    meta: {
      title: Vue.i18n.translate('strings.home', null),
      auth: {
        roles: ['user_view'],
        forbiddenRedirect: '/access/restricted'
      }
    },
    children: [
      {
        path: '',
        name: 'dashboard',
        component: Dashboard,
        meta: {
          title: Vue.i18n.translate('strings.home', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      },
      {
        path: '',
        name: 'initial_dashboard',
        component: Dashboard,
        meta: {
          title: Vue.i18n.translate('strings.home', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, {
        path: 'myprofile',
        name: 'myprofile',
        component: MyProfile,
        meta: {
          title: Vue.i18n.translate('strings.myprofile', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, {
        path: 'users',
        name: 'users',
        component: Users,
        meta: {
          title: Vue.i18n.translate('strings.users.admin', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, {
        path: 'users/public',
        name: 'users.public',
        component: PublicUsers,
        meta: {
          title: Vue.i18n.translate('strings.users.public', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, {
        path: 'usersadd',
        name: 'add.user',
        component: UserForm,
        meta: {
          title: Vue.i18n.translate('users.add', null),
          auth: {
            roles: ['user_write'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, {
        path: 'usersedit/:userId/edit',
        name: 'edit.user',
        component: UserForm,
        meta: {
          title: Vue.i18n.translate('users.edit_user', null),
          auth: {
            roles: ['user_write'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, {
        path: 'userseditadditional/:userId/edit',
        name: 'edit.user_additional',
        component: EditUserAdditionalData,
        meta: {
          title: Vue.i18n.translate('users.edit_user', null),
          auth: {
            roles: ['user_write'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, {
        path: 'my_posts',
        name: 'my_posts',
        component: PostForm,
        meta: {
          title: Vue.i18n.translate('strings.posts.main', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/access/restricted'
          }
        }
        }, {
          path: 'add_posts',
          name: 'add_posts',
          component: PostForm,
          meta: {
            title: Vue.i18n.translate('strings.posts.main', null),
            auth: {
              roles: ['user_view'],
              forbiddenRedirect: '/access/restricted'
            }
          }
      }, {
        path: 'all_posts',
        name: 'all_posts',
        component: Posts,
        meta: {
          title: Vue.i18n.translate('strings.posts.all_posts', null),
          auth: {
            roles: ['user_view'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, 
      {
        path: 'postsadd',
        name: 'add.post',
        component: PostForm,
        meta: {
          title: Vue.i18n.translate('posts.add', null),
          auth: {
            roles: ['user_write'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      }, 
      {
        path: 'postsedit/:postId/edit',
        name: 'edit.post',
        component: PostForm,
        meta: {
          title: Vue.i18n.translate('posts.edit_post', null),
          auth: {
            roles: ['user_write'],
            forbiddenRedirect: '/access/restricted'
          }
        }
      },
      /*INSERT NEW CONFIGURATOR OPTIONS HERE*/
    ]
  };
