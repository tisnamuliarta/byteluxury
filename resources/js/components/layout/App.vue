<template>
  <v-app id="inspire">

    <v-navigation-drawer
      :clipped="$vuetify.breakpoint.lgAndUp"
      v-model="drawer"
      fixed
      temporary>

      <v-list dense>
        <v-list-group
          v-for="item in items"
          :key="item.text"
          v-model="item.model"
          :prepend-icon="item['icon-alt']"
        >

          <v-list-tile slot="activator" :to="item.route">
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-list-tile
            v-for="(child, i) in item.children"
            :key="i"
            :to="child.route"
          >
            <v-list-tile-action v-if="child.icon">
              <v-icon>{{ child.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ child.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider></v-divider>
        </v-list-group>

      </v-list>
    </v-navigation-drawer>

    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      color="cyan lighten-5"
      app
      fixed
      dense>
      <!--dense-->
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <!--<span class="hidden-sm-and-down">E-KB</span>-->
        <router-link to="/" >
          <img src="/imgs/logo.png" class="mt-12 " height="36" alt="E-KB">
        </router-link>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <span class="hidden-xs-only">Hi, {{ user.name }}</span>

      <v-menu
        bottom
        min-width="200"
        offset-y
        left>
        <v-btn
          slot="activator"
          icon>
          <v-icon>notifications</v-icon>
        </v-btn>

        <v-list v-if="notification.length > 0">
          <v-list-tile
            v-for="(notif, i) in notification"
            :key="i"
            @click="openLink(notif)">
            <v-list-tile-content>
              <v-list-tile-title>{{ notif.Messages }}</v-list-tile-title>
              <v-list-tile-sub-title>{{ formatDate(notif) }}</v-list-tile-sub-title>
            </v-list-tile-content>
            <v-list-tile-action>

              <v-icon v-if="notif.Read == '0'" color="blue">mail</v-icon>
              <v-icon v-else color="green">drafts</v-icon>

            </v-list-tile-action>
          </v-list-tile>
          <v-btn v-if="notification.length >= 8" @click="$router.push({ name: 'notification' })" outline small color="secondary" dark>Load More</v-btn>
        </v-list>
      </v-menu>

      <span style="margin-left: -15px; margin-top: -10px;">
        {{ (read >= 8) ? '8+': read }}
      </span>

      <v-menu
        bottom
        min-width="200"
        offset-y
        left>
        <v-btn
          slot="activator"
          icon>
          <v-icon>account_circle</v-icon>
        </v-btn>

        <v-list >
          <v-list-tile
            v-for="setting in settings"
            :key="setting.title"
            @click.prevent="checkAction(setting.action)">
            <v-list-tile-avatar>
              <v-icon>{{ setting.icon }}</v-icon>
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title>{{ setting.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
      <!--      <v-btn @click.prevent="logout" icon>-->
      <!--        <v-icon>power_settings_new</v-icon>-->
      <!--      </v-btn>-->
    </v-toolbar>

    <v-content>
      <v-container transition="slide-x-transition" fluid fill-height class="mtop-15">
        <router-view @updateNotification="updateNotification" :user="user" :roles="roles"></router-view>
      </v-container>
    </v-content>

    <!--loading-->
    <v-dialog v-model="loadModal" hide-overlay persistent width="300">
      <v-card color="primary" dark>
        <v-card-text>
          Loading...
          <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <!-- loading -->
  </v-app>
</template>
<script>
import { mapGetters, mapState } from 'vuex'
import jwtToken from '../../helper/jwt-token'
import axios from 'axios'

export default {
  name: 'default-layout',
  computed: {
    ...mapGetters([
      'isLoggedIn'
    ]),
    ...mapState({
      user: state => state.auth
    })
  },

  data () {
    return {
      dialog: false,
      drawer: null,
      loadModal: false,
      items: [],
      currentUserId: null,
      date: null,
      read: 0,
      notification: [],
      userRoles: [],
      settings: [
        {icon: 'settings_applications', title: 'Settings', action: 'openSettings'},
        {icon: 'power_settings_new', title: 'Logout', action: 'logout'},
      ]
    }
  },

  created () {
    this.getNotification()
    this.menu()
    this.initPusher()
    // this.getItem()
  },

  methods: {
    getDate() {
      let date = new Date();
      this.date = date.getFullYear()
    },

    checkAction(action) {
      switch (action) {
        case 'openSettings':
          this.openSettings()
          break;
        case 'logout':
          this.logout()
          break;
      }
    },

    getItem() {
      if (localStorage.getItem("itemcode") === null) {
        axios.get(`/api/transact/itemcode`)
          .then(res => {
            localStorage.setItem('itemcode', JSON.stringify(res.data.items))
          })
      }
    },

    openSettings() {
      this.$router.push({ name: 'settingsProfile' })
    },


    initPusher() {
      // let notif = this.$store.dispatch("GET_NOTIFICATIONS")
      let entry = JSON.parse(window.localStorage.getItem('currEntry'))
      // this.$store.commit('ADD_NOTIFICATION', e.notification)
      // console.log(this.notifications.notifications)
      // this.notification.unshift(e.notification)
      // console.log(this.notification)
      if (this.notification.length > 8) {
        this.notification = this.notification.slice(0, 7)
        this.read = '8+'
      } else {
        this.read = this.read + 1
      }
      // this.$store.dispatch("GET_NOTIFICATIONS")
      // console.log(this.notification.length)
      // window.Echo.private(`newNotification.${entry[0].id}`)
      //   .listen('.notification-created', e => {
      //     console.log(e)
      //
      // })
    },

    formatDate(notif) {
      return window.moment(notif.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow()
    },

    updateNotification(res) {
      this.notification = res.data.notifications
      this.read = res.data.read
    },

    openLink(notif) {
      if (notif.Type === 'IP') {
        axios.put(`/api/notification/${notif.DocEntry}`)
          .then(res => {
            this.notification = res.data.notifications
            this.read = res.data.read
            this.$router.push({ name: 'transactImport', params: { id: notif.DocNum, status: 'update'  } })
          })
      }else if (notif.Type === 'TD') {
        axios.put(`/api/notification/${notif.DocEntry}`)
          .then(res => {
            this.notification = res.data.notifications
            this.read = res.data.read
            this.$router.push({ name: 'transactTrading', params: { id: notif.DocNum, status: 'update'  } })
          })
      }
    },

    getNotification() {
      if (jwtToken.getToken()) {
        axios.get(`/api/notification`)
          .then(res => {
            this.notification = res.data.notifications
            this.read = res.data.read
            // console.log(window.moment('2019-05-14 14:48:04.080', 'YYYY-MM-DD HH:mm:ss').fromNow())
          }).catch(error => {
          console.log(error)
        })
      }
    },

    logout () {
      jwtToken.removeToken()
      localStorage.removeItem("itemcode");
      this.loadModal = true
      this.$store.dispatch('unsetRole')
      this.$store.dispatch('unsetAuthUser')
        .then(() => {
          this.loadModal = false
          this.$router.push({ name: 'login' })
        })
    },

    menu () {
      if (jwtToken.getToken()) {
        axios.get(`/api/menu`)
          .then(res => {
            this.items = res.data.menu
            if (localStorage.getItem('role')) {
              localStorage.removeItem('role')
              localStorage.setItem('role', JSON.stringify(res.data.role))
              window.ERole = JSON.parse(localStorage.getItem('role'))
            } else {
              localStorage.setItem('role', JSON.stringify(res.data.role))
            }
          })
      }
    }
  },

  props: {
    source: String
  }
}
</script>

<style scoped>
table.v-table tbody td:first-child, table.v-table tbody td:not(:first-child),
table.v-table tbody th:first-child, table.v-table tbody th:not(:first-child),
table.v-table thead td:first-child, table.v-table thead td:not(:first-child),
table.v-table thead th:first-child, table.v-table thead th:not(:first-child) {
  padding: 0 10px !important;
}

table.v-table tbody td {
  font-weight: 400;
  font-size: 12px;
}

.w-100 {
  width: 100%;
}

table.v-table tbody td {
  font-weight: 400;
  font-size: 12px;
}

.inputPrice input[type='number'] {
  -moz-appearance: textfield;
}

.inputPrice input::-webkit-outer-spin-button,
.inputPrice input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
.mt-12 {
  margin-bottom: -12px!important;
}
.mtop-15 {
  margin-top: -15px;
}

</style>
