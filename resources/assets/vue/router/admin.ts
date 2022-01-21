import Vue from 'vue';
import { RouteConfig } from 'vue-router';
// Authenticated user routes
const AdminDefaultPage = () => import(/* webpackChunkName: "AdminDefaultPage" */ '../views/layouts/admin/AdminDefaultPage.vue');
const Dashboard = () => import(/* webpackChunkName: "AdminDashboard" */ '../views/admin/Dashboard.vue');
const Users = () => import(/* webpackChunkName: "Users" */ '../views/admin/Users/Users.vue');
const PublicUsers = () => import(/* webpackChunkName: "PublicUsers" */ '../views/admin/Users/PublicUsers.vue');
const MyProfile = () => import(/* webpackChunkName: "MyProfile" */ '../views/admin/Users/MyProfile.vue');
// const AddUser = () => import(/* webpackChunkName: "AddUser" */ '../views/admin/Users/AddUser.vue');
// const EditUser = () => import(/* webpackChunkName: "EditUser" */ '../views/admin/Users/EditUser.vue');
const UserForm = () => import(/* webpackChunkName: "EditUser" */ '../features/Admin/UsersCrud/_components/UserForm.vue');
// const EditProduct = () => import(/* webpackChunkName: "EditProduct" */ '../views/admin/Products/EditProduct.vue');
// const AddProduct = () => import(/* webpackChunkName: "AddProduct" */ '../views/admin/Products/AddProduct.vue');
const EditUserAdditionalData = () => import(/* webpackChunkName: "EditUserAdditionalData" */ '../views/admin/Users/EditUserAdditionalData.vue');
const Combination = () => import(/* webpackChunkName: "CombinationsCRUD" */ '../views/admin/Taxonomies/Combination.vue');
const Parameter = () =>  import(/* webpackChunkName: "ParametersCRUD" */ '../views/admin/Taxonomies/Parameter.vue');
const Format = () =>  import(/* webpackChunkName: "FormatsCRUD" */ '../views/admin/Taxonomies/Format.vue');
const Cliche = () =>  import(/* webpackChunkName: "ClichesCRUD" */ '../views/admin/Taxonomies/Cliche.vue');
const Color = () =>  import(/* webpackChunkName: "ColorsCRUD" */ '../views/admin/Taxonomies/Color.vue');
const Handle = () =>  import(/* webpackChunkName: "HandlesCRUD" */ '../views/admin/Taxonomies/Handle.vue');
const Lamination = () =>  import(/* webpackChunkName: "LaminationsCRUD" */ '../views/admin/Taxonomies/Lamination.vue');
const Paper = () =>  import(/* webpackChunkName: "PapersCRUD" */ '../views/admin/Taxonomies/Paper.vue');
const PackageWeight = () =>  import(/* webpackChunkName: "PackageWeightsCRUD" */ '../views/admin/Taxonomies/PackageWeight.vue');
const HomepageSlider = () =>  import(/* webpackChunkName: "HomepageSlider" */ '../views/admin/Sliders/HomepageSlider.vue');
const AddSlide = () =>  import(/* webpackChunkName: "AddSlide" */ '../views/admin/Sliders/AddSlide.vue');
const EditSlide = () =>  import(/* webpackChunkName: "EditSlide" */ '../views/admin/Sliders/EditSlide.vue');

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
      },
      /*INSERT NEW CONFIGURATOR OPTIONS HERE*/
    ]
  };
